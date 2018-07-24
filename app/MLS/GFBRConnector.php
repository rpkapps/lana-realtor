<?php

namespace App\MLS;

class GFBRConnector extends Connector
{
    const CLASS_RESIDENTIAL = 'RE_1';
    const CLASS_LAND = 'LD_2';
    const CLASS_COMMERCIAL = 'CI_3';
    const CLASS_MULTI_FAMILY = 'MF_4';
    const CLASS_RENTAL = 'RR_5';

    const CLASSES = [
        self::CLASS_RESIDENTIAL,
        self::CLASS_LAND,
        self::CLASS_COMMERCIAL,
        self::CLASS_MULTI_FAMILY,
        self::CLASS_RENTAL
    ];

    const STATUS_ACTIVE_VALUE = 'ACTIVE';
    const STATUS_ACTIVE_LOOKUP = '1_0';

    const MLS_COLUMN_STATUS = 'L_Status';
    const MLS_COLUMN_UPDATED_AT = 'L_UpdateDate';
    const MLS_COLUMN_MEDIA_URL = 'MED_media_url';
    const MLS_COLUMN_ID = 'L_DisplayId';

    const MLS_PHOTO_TYPE = 'Photo';
    const MLS_THUMBNAIL_TYPE = 'Thumbnail';

    /**
     * Returns either static::FOR_RENT or static::FOR_SALE
     *
     * @param $mlsProperty
     * @return string
     */
    protected function getSaleRent($mlsProperty)
    {
        return array_get($mlsProperty, 'L_SaleRent') === 'For Rent' ? static::FOR_RENT : static::FOR_SALE;
    }


    /**
     * Get Property Type
     *
     * @param $mlsProperty
     * @return string: will return on of the TYPE_ constants
     */
    protected function getPropertyType($mlsProperty)
    {
        $class = array_get($mlsProperty, 'L_Class');
        $subtype = array_get($mlsProperty, 'L_Type_');
        $saleRent = $this->getSaleRent($mlsProperty);

        if ($saleRent === static::FOR_RENT) {

            if ($subtype === 'MF APARTMENT') {
                return static::TYPE_APARTMENT;
            } elseif ($subtype === 'CONDOMINIUM') {
                return static::TYPE_CONDO;
            } elseif ($subtype === 'TOWNHOUSE') {
                return static::TYPE_TOWNHOME;
            } elseif ($subtype === 'SINGLE FAMILY') {
                return static::TYPE_SINGLE_FAMILY;
            }

        } else {

            if ($class === 'MULTI-FAMILY') {
                return static::TYPE_MULTI_FAMILY;
            } elseif ($class === 'COMMERCIAL/INDUSTRIAL') {
                return static::TYPE_COMMERCIAL;
            } elseif ($class === 'LAND') {
                return static::TYPE_LAND;
            } elseif ($subtype === 'MOBILE' || $subtype === 'MOBILE HOME W/LAND') {
                return static::TYPE_MOBILE;
            } elseif ($subtype === 'CONDOMINIUM') {
                return static::TYPE_CONDO;
            } elseif ($subtype === 'SINGLE FAMILY' || $subtype === 'ZERO LOT LINE' || $subtype === 'DUPLEX') {
                return static::TYPE_HOUSE;
            }

        }

        return static::TYPE_OTHER;
    }

    /**
     * Map an MLS property to a Listing within our database
     *
     * @param array $mlsProperty
     * @return array
     */
    protected function mapToListingDB(array $mlsProperty): array
    {
        return [
            'mls_id' => $this->arrayNumber($mlsProperty, 'L_DisplayId'),
            'type' => $this->getPropertyType($mlsProperty),
            'sub_type' => array_get($mlsProperty, 'L_Type_'),
            'area' => array_get($mlsProperty, 'L_Area'),
            'system_price' => $this->arrayNumber($mlsProperty, 'L_SystemPrice'),
            'asking_price' => $this->arrayNumber($mlsProperty, 'L_AskingPrice'),
            'street_number' => array_get($mlsProperty, 'L_AddressNumber'),
            'street_name' => array_get($mlsProperty, 'L_AddressStreet'),
            'city' => array_get($mlsProperty, 'L_City'),
            'state' => array_get($mlsProperty, 'L_State'),
            'zip_code' => array_get($mlsProperty, 'L_Zip'),
            'sale_rent' => $this->getSaleRent($mlsProperty),
            'construction' => array_get($mlsProperty, 'L_Keyword1'),
            'foundation' => array_get($mlsProperty, 'L_Keyword2'),
            'age' => array_get($mlsProperty, 'L_Keyword3'),
            'garage' => array_get($mlsProperty, 'L_Keyword4'),
            'style' => array_get($mlsProperty, 'L_Keyword5'),
            'acres' => $this->arrayNumber($mlsProperty, 'L_NumAcres'),
            'listing_date' => $this->arrayDate($mlsProperty, 'L_ListingDate'),
            'mls_updated_at' => $this->arrayDate($mlsProperty, 'L_UpdateDate'),
            'photo_count' => $this->arrayNumber($mlsProperty, 'L_PictureCount'),
            'photo_timestamp' => $this->arrayDate($mlsProperty, 'L_Last_Photo_updt'),
            'full_address' => array_get($mlsProperty, 'L_Address'),
            'status' => array_get($mlsProperty, 'L_Status'),
            'price_per_sqft' => $this->arrayNumber($mlsProperty, 'L_PricePerSQFT'),
            'elementary_school' => array_get($mlsProperty, 'LM_Char10_2'),
            'middle_school' => array_get($mlsProperty, 'LM_Char10_3'),
            'high_school' => array_get($mlsProperty, 'LM_Char10_4'),
            'parking_spaces' => $this->arrayNumber($mlsProperty, 'LM_Int2_1'),
            'beds' => $this->arrayNumber($mlsProperty, 'LM_Int4_1'),
            'full_baths' => $this->arrayNumber($mlsProperty, 'LM_Int4_2'),
            'partial_baths' => $this->arrayNumber($mlsProperty, 'LM_Int4_3'),
            'garage_spaces' => $this->arrayNumber($mlsProperty, 'LM_Int4_4'),
            'total_baths' => $this->arrayNumber($mlsProperty, 'LM_Int4_5'),
            'year_built' => $this->arrayNumber($mlsProperty, 'LM_Int4_6'),
            'residence_sqft' => $this->arrayNumber($mlsProperty, 'LM_Int4_8'),
            'listing_description' => array_get($mlsProperty, 'LR_remarks11'),
            'additional_street_info' => array_get($mlsProperty, 'L_Address2'),
            'price_per_acre' => $this->arrayNumber($mlsProperty, 'L_PricePerAcre'),
            'lot_size' => array_get($mlsProperty, 'L_Keyword9'),
            'building_sqft' => $this->arrayNumber($mlsProperty, 'L_SquareFeet'),
            'rent_date_available' => $this->arrayDate($mlsProperty, 'LM_DateTime_1'),
            'photos' => array_get($mlsProperty, 'photos', '[]'),
            'thumbnails' => array_get($mlsProperty, 'thumbnails', '[]'),
            'latitude' => null,
            'longitude' => null
        ];
    }
}