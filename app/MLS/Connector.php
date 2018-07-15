<?php

namespace App\MLS;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Listing;
use App\MlsPullDate;

/**
 * Class Connector
 *
 * @package App\MLS
 */
abstract class Connector
{
    protected $config;
    protected $session;
    protected $connection;

    /**
     * The below consts should be defined and initialized in the child class
     */
    const TYPE_RESIDENTIAL = '';
    const TYPE_LAND = '';
    const TYPE_COMMERCIAL = '';
    const TYPE_MULTI_FAMILY = '';
    const TYPE_RENTAL = '';

    const TYPES = [];

    const STATUS_ACTIVE_VALUE = '';
    const STATUS_ACTIVE_LOOKUP = '';

    const MLS_COLUMN_STATUS = '';
    const MLS_COLUMN_UPDATED_AT = '';

    abstract protected function mapToListingDB(array $mlsProperty): array;

    /**
     * Constructor for MLS Connector
     *
     * @param $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        $this->config = (new \PHRETS\Configuration)
            ->setLoginUrl($config['loginUrl'])
            ->setUsername($config['username'])
            ->setPassword($config['password'])
            ->setRetsVersion(array_key_exists('version', $config) ? $config['version'] : '1.7.2');

        $this->session = new \PHRETS\Session($this->config);
        $this->connection = $this->session->Login();
    }

    /**
     * Helper function to make sure we return a number when accessing
     * an array property
     *
     * @param $array
     * @param $property
     * @return mixed|null
     */
    protected function array_number($array, $property)
    {
        $value = array_get($array, $property);
        return is_numeric($value) ? $value : null;
    }

    protected function array_date($array, $property)
    {
        $value = array_get($array, $property);
        return strtotime($value) ? $value : null;
    }

    /**
     * Get properties
     *
     * @return array|mixed
     * @throws \PHRETS\Exceptions\CapabilityUnavailable
     */
    public function getMLSMedia()
    {
        // TODO: implement method
    }

    /**
     * Get latest MLS pull date for this Connector class
     *
     * @return mixed
     */
    public function getLatestPullDate()
    {
        $date = MlsPullDate::where('connector_class', static::class)
            ->orderBy('pull_date', 'desc')
            ->first();

        Log::info(sprintf('Retrieved latest MLS Pull Date: %s',
                $date ? $date->pull_date : 'NO DATE FOUND')
        );

        return !$date ? null : Carbon::parse($date->pull_date)
            ->setTimezone('GMT')
            ->format('Y-m-d\TH:i:s');
    }

    /**
     * Get MLS properties
     *
     * @param string $date (i.e. 2009-01-01T00:00:00)
     * @return array
     * @throws \PHRETS\Exceptions\CapabilityUnavailable
     */
    public function pullMLSProperties(string $date = null)
    {
        $properties = [];
        $latestPullDate = $date ? $date : $this->getLatestPullDate();

        $query = $latestPullDate ?
            sprintf('(%s=%s+)', static::MLS_COLUMN_UPDATED_AT, $latestPullDate) :
            sprintf('(%s=%s)', static::MLS_COLUMN_STATUS, static::STATUS_ACTIVE_LOOKUP);

        foreach (static::TYPES as $type) {
            $properties = array_merge(
                $properties,
                $this->session->Search('Property', $type, $query, ['Format' => 'COMPACT-DECODED'])->toArray()
            );
        }

        return $properties;
    }

    /**
     * Delete Listing
     *
     * @param array $listing
     */
    protected function deleteListing(array $listing = [])
    {
        $listing = Listing::where('mls_id', $listing['mls_id'])->first();

        if ($listing) {
            $listing->delete();
        }
    }

    /**
     * Sync Listing: will either update, create, or delete Listing
     *
     * @param array $listing
     */
    protected function syncListing(array $listing = [])
    {
        if ($listing['status'] !== static::STATUS_ACTIVE_VALUE) {
            $this->deleteListing($listing);
        } else {
            try {
                Listing::updateOrCreate(
                    ['mls_id' => $listing['mls_id']],
                    $listing
                );
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    /**
     * Pull from MLS and sync that data with our database
     *
     * @param string $date (i.e. 2009-01-01T00:00:00)
     * @throws \PHRETS\Exceptions\CapabilityUnavailable
     */
    public function pullAndSync(string $date = null)
    {
        $properties = $this->pullMLSProperties($date);

        foreach ($properties as $property) {
            $this->syncListing($this->mapToListingDB($property));
        }

        $datePulled = $date ? Carbon::parse($date)->timezone('GMT') : Carbon::now('GMT');

        MlsPullDate::create([
            'connector_class' => static::class,
            'pull_date' => $datePulled
        ]);

        Log::info(sprintf('MLS pulled and synced: %s on %s', static::class, $datePulled));
    }
}