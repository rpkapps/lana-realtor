<?php

namespace App\MLS;

class GFBRConnector extends Connector
{
    const TYPE_RESIDENTIAL = 'RE_1';
    const TYPE_LAND = 'LD_2';
    const TYPE_COMMERCIAL = 'CI_3';
    const TYPE_MULTI_FAMILY = 'MF_4';
    const TYPE_RENTAL = 'RR_5';

    const TYPES = [
        self::TYPE_RESIDENTIAL,
        self::TYPE_LAND,
        self::TYPE_COMMERCIAL,
        self::TYPE_MULTI_FAMILY,
        self::TYPE_RENTAL
    ];

    const STATUS_ACTIVE_VALUE = 'ACTIVE';
    const STATUS_ACTIVE_LOOKUP = '1_0';

    const MLS_COLUMN_STATUS = 'L_Status';
    const MLS_COLUMN_UPDATED_AT = 'L_UpdateDate';

    /**
     * Map an MLS property to a Listing within our database
     *
     * @param array $mlsProperty
     * @return array
     */
    protected function mapToListingDB(array $mlsProperty): array
    {
        return [
            'mls_id' => $this->array_number($mlsProperty, 'L_DisplayId'),
            'sub_type' => array_get($mlsProperty, 'L_Type_'),
            'area' => array_get($mlsProperty, 'L_Area'),
            'system_price' => $this->array_number($mlsProperty, 'L_SystemPrice'),
            'asking_price' => $this->array_number($mlsProperty, 'L_AskingPrice'),
            'street_number' => array_get($mlsProperty, 'L_AddressNumber'),
            'street_name' => array_get($mlsProperty, 'L_AddressStreet'),
            'city' => array_get($mlsProperty, 'L_City'),
            'state' => array_get($mlsProperty, 'L_State'),
            'zip_code' => array_get($mlsProperty, 'L_Zip'),
            'sale_rent' => array_get($mlsProperty, 'L_SaleRent'),
            'construction' => array_get($mlsProperty, 'L_Keyword1'),
            'foundation' => array_get($mlsProperty, 'L_Keyword2'),
            'age' => array_get($mlsProperty, 'L_Keyword3'),
            'garage' => array_get($mlsProperty, 'L_Keyword4'),
            'style' => array_get($mlsProperty, 'L_Keyword5'),
            'acres' => $this->array_number($mlsProperty, 'L_NumAcres'),
            'listing_date' => $this->array_date($mlsProperty, 'L_ListingDate'),
            'mls_updated_at' => $this->array_date($mlsProperty, 'L_UpdateDate'),
            'photo_count' => $this->array_number($mlsProperty, 'L_PictureCount'),
            'photo_timestamp' => $this->array_date($mlsProperty, 'L_Last_Photo_updt'),
            'full_address' => array_get($mlsProperty, 'L_Address'),
            'status' => array_get($mlsProperty, 'L_Status'),
            'price_per_sqft' => $this->array_number($mlsProperty, 'L_PricePerSQFT'),
            'elementary_school' => array_get($mlsProperty, 'LM_Char10_2'),
            'middle_school' => array_get($mlsProperty, 'LM_Char10_3'),
            'high_school' => array_get($mlsProperty, 'LM_Char10_4'),
            'parking_spaces' => $this->array_number($mlsProperty, 'LM_Int2_1'),
            'beds' => $this->array_number($mlsProperty, 'LM_Int4_1'),
            'full_baths' => $this->array_number($mlsProperty, 'LM_Int4_2'),
            'partial_baths' => $this->array_number($mlsProperty, 'LM_Int4_3'),
            'garage_spaces' => $this->array_number($mlsProperty, 'LM_Int4_4'),
            'total_baths' => $this->array_number($mlsProperty, 'LM_Int4_5'),
            'year_built' => $this->array_number($mlsProperty, 'LM_Int4_6'),
            'residence_sqft' => $this->array_number($mlsProperty, 'LM_Int4_8'),
            'listing_description' => array_get($mlsProperty, 'LR_remarks11'),
            'additional_street_info' => array_get($mlsProperty, 'L_Address2'),
            'price_per_acre' => $this->array_number($mlsProperty, 'L_PricePerAcre'),
            'lot_size' => array_get($mlsProperty, 'L_Keyword9'),
            'building_sqft' => $this->array_number($mlsProperty, 'L_SquareFeet'),
            'rent_date_available' => $this->array_date($mlsProperty, 'LM_DateTime_1'),
            'photos' => '',
            'latitude' => null,
            'longitude' => null
        ];
    }
}