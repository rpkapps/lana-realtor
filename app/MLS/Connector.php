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

    protected $updatedListingsCounter = 0;
    protected $createdListingsCounter = 0;

    // Will sync without overriding existing listings and will ignore latest pull date
    // pulling all active listings
    protected $syncWithoutOverride = false;

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
    const MLS_COLUMN_MEDIA_URL = '';
    const MLS_COLUMN_ID = '';

    const MLS_PHOTO_TYPE = '';
    const MLS_THUMBNAIL_TYPE = '';

    abstract protected function mapToListingDB(array $mlsProperty): array;

    /**
     * Constructor for MLS Connector
     *
     * @param $config
     * @param bool $syncWithoutOverride : Will sync without overriding existing listings and
     *                                    will ignore latest pull date pulling all active listings
     * @throws \PHRETS\Exceptions\CapabilityUnavailable
     * @throws \PHRETS\Exceptions\MissingConfiguration
     */
    public function __construct($config, $syncWithoutOverride = false)
    {
        $this->config = (new \PHRETS\Configuration)
            ->setLoginUrl($config['loginUrl'])
            ->setUsername($config['username'])
            ->setPassword($config['password'])
            ->setRetsVersion(array_key_exists('version', $config) ? $config['version'] : '1.7.2');

        $this->session = new \PHRETS\Session($this->config);
        $this->connection = $this->session->Login();

        $this->syncWithoutOverride = $syncWithoutOverride;
    }

    /**
     * Helper function to make sure we return a number when accessing
     * an array property
     *
     * @param $array
     * @param $property
     * @return mixed|null
     */
    protected function arrayNumber($array, $property)
    {
        $value = array_get($array, $property);
        return is_numeric($value) ? $value : null;
    }

    /**
     * Helper function to make sure we return a date when accessing
     * an array property
     *
     * @param $array
     * @param $property
     * @return mixed|null
     */
    protected function arrayDate($array, $property)
    {
        $value = array_get($array, $property);
        return strtotime($value) ? $value : null;
    }

    /**
     * Get latest MLS pull date for this Connector class
     *
     * @return mixed
     */
    protected function getLatestPullDate()
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
     * Format MLS Media Objects into the following array
     *      [ <mlsID> => '"<photoUrl>","<photoUrl>",...' ]
     *
     * @param $mlsMedia
     * @return array
     */
    protected function formatMlsMediaObjects($mlsMediaObjects)
    {
        $media = [];

        foreach ($mlsMediaObjects as $mediaObject) {
            if ($mediaObject->isError()) {
                Log::error('Media Object Error: ' . $mediaObject->getError()->getMessage());
                continue;
            }

            $mlsId = $mediaObject->getContentId();
            $url = $mediaObject->getLocation();

            if (array_key_exists($mlsId, $media) && $url) {
                array_push($media[$mlsId], $url);
            } else {
                $media[$mlsId] = $url ? [$url] : [];
            }
        }

        forEach ($media as $mlsId => $mediaItems) {
            $media[$mlsId] = count($mediaItems) > 0 ? json_encode($mediaItems) : '[]';
        }

        return $media;
    }

    /**
     * Pull MLS media from the MLS database
     *
     * @param array $properties
     * @return array
     * @throws \PHRETS\Exceptions\CapabilityUnavailable
     */
    protected function pullMLSMedia(array $properties)
    {
        $media = [
            'photos' => [],
            'thumbnails' => [],
        ];

        // We can't pull all of the media at once because there is a limit on the number of MLS IDs we can
        // pass to GetObject
        $mlsIdsInChunks = collect($properties)->pluck(static::MLS_COLUMN_ID)->chunk(100);

        forEach ($mlsIdsInChunks as $mlsIdsChunk) {
            $mlsPhotoObjects = $this->session->GetObject('Property', static::MLS_PHOTO_TYPE, $mlsIdsChunk->toArray(),
                '*', 1);

            $mlsThumbnailObjects = $this->session->GetObject('Property', static::MLS_THUMBNAIL_TYPE,
                $mlsIdsChunk->toArray(),
                '*', 1);

            $media['photos'] += $this->formatMlsMediaObjects($mlsPhotoObjects);
            $media['thumbnails'] += $this->formatMlsMediaObjects($mlsThumbnailObjects);
        }

        return $media;
    }

    /**
     * Get MLS properties from the MLS database
     *
     * @return array
     * @throws \PHRETS\Exceptions\CapabilityUnavailable
     */
    public function pullMLSProperties()
    {
        $properties = [];

        $latestPullDate = $this->syncWithoutOverride ? $this->getLatestPullDate() : null;

        $query = $latestPullDate ?
            sprintf('(%s=%s+)', static::MLS_COLUMN_UPDATED_AT, $latestPullDate) :
            sprintf('(%s=%s)', static::MLS_COLUMN_STATUS, static::STATUS_ACTIVE_LOOKUP);

        foreach (static::TYPES as $type) {
            $propertiesByType = $this->session->Search('Property', $type, $query)->toArray();
            $properties = array_merge($properties, $propertiesByType);

            Log::info('Number of properties retrieved for ' . $type . ': ' . count($propertiesByType));
        }


        $media = $this->pullMLSMedia($properties);

        // Map photos and thumbnails to each property
        forEach ($properties as &$property) {
            $mlsId = array_get($property, static::MLS_COLUMN_ID);

            $property['photos'] = array_get($media['photos'], $mlsId, '[]');
            $property['thumbnails'] = array_get($media['thumbnails'], $mlsId, '[]');
        }

        return $properties;
    }

    /**
     * Delete Listing
     *
     * @param array $mlsListing
     */
    protected function deleteListing(array $mlsListing = [])
    {
        $listing = Listing::where('mls_id', $mlsListing['mls_id'])->first();

        if ($listing) {
            $listing->delete();
        }
    }

    /**
     * Set geo coordinates from Google Maps API
     *
     * @param array $mlsListing
     */
    protected function setGeoCoordinatesFromGoogleAPI(array &$mlsListing = [])
    {
        try {
            $address = $mlsListing['full_address'] . ', ' . $mlsListing['city'] . ', ' . $mlsListing['state'];
            $geo = app('geocoder')->geocode($address)->get()->first();

            if ($geo) {
                $coordinates = $geo->getCoordinates();
                $mlsListing['latitude'] = $coordinates->getLatitude();
                $mlsListing['longitude'] = $coordinates->getLongitude();
            }
        } catch (\Exception $e) {
            Log::error('Geocode failed: ' . $e->getMessage());
        }
    }

    /**
     * Update or create listing if it doesn't exist
     *
     * @param array $mlsListing
     */
    protected function updateOrCreate(array $mlsListing = [])
    {
        $listing = Listing::where('mls_id', $mlsListing['mls_id'])->first();

        if($listing && $this->syncWithoutOverride) {
            return;
        }

        if ($listing) {
            $this->updatedListingsCounter++;

            // Set latitude and longitude. Only make the request to Google Maps API
            // when the address changed
            if ($listing->full_address !== $mlsListing['full_address']) {
                Log::info('MLS listing address was updated on the MLS.');

                $this->setGeoCoordinatesFromGoogleAPI($mlsListing);
            } else {
                // Set Geo Coordinates from existing database listing
                $mlsListing['longitude'] = $listing->latitude;
                $mlsListing['latitude'] = $listing->longitude;
            }
        } else {
            $this->createdListingsCounter++;

            // We will need to create a new listing, so grab the GeoLocation from
            // Google Maps API
            $this->setGeoCoordinatesFromGoogleAPI($mlsListing);
        }

        Listing::updateOrCreate(
            ['mls_id' => $mlsListing['mls_id']],
            $mlsListing
        );
    }

    /**
     * Sync Listing: will either update, create, or delete Listing
     *
     * @param array $mlsListing
     */
    protected function syncListing(array $mlsListing = [])
    {
        if ($mlsListing['status'] !== static::STATUS_ACTIVE_VALUE) {
            $this->deleteListing($mlsListing);
        } else {
            try {
                $this->updateOrCreate($mlsListing);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    /**
     * Pull from MLS and sync that data with our database
     *
     * @throws \PHRETS\Exceptions\CapabilityUnavailable
     */
    public function pullAndSync()
    {
        $properties = $this->pullMLSProperties();

        foreach ($properties as $property) {
            $this->syncListing($this->mapToListingDB($property));
        }

        $datePulled = Carbon::now('GMT');

        MlsPullDate::create([
            'connector_class' => static::class,
            'pull_date' => $datePulled
        ]);

        Log::info('Number of listings CREATED in database: ' . $this->createdListingsCounter);
        Log::info('Number of listings UPDATED in database: ' . $this->updatedListingsCounter);
        Log::info(sprintf('MLS pulled and synced: %s on %s', static::class, $datePulled));
    }
}