<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => 'Lana Kulikovskiy Somers & Associates Realtors', // set false to total remove
            'description'  => 'Residential & Commercial Houses and Land for sale/rent in Delta Junction, North Pole, and Fairbanks Alaska', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ['House for sale', 'House for rent', 'Property for sale', 'Alaska listing',
                                'Delta Junction house', 'Fairbanks house', 'North Pole house', 
                                'Real estate listings MLS', 'Real estate agent listings', 'Real estate listing',
                                'Delta Junction realtor', 'Fairbanks realtor', 'North Pole realtor',
                                'Somers & Associates Realtors', 'Somers', 'House for sale in Alaska', 'House for rent in Alaska',
                                'Greater Fairbanks Board of Realtors', 'GFBR'],
            'canonical'    => 'http://www.lanasellsdelta.com', // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Lana Kulikovskiy Somers & Associates Realtors', // set false to total remove
            'description' => 'Residential & Commercial Houses and Land for sale/rent in Delta Junction, North Pole, and Fairbanks Alaska', // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => 'website',
            'site_name'   => 'Lana Sells Delta',
            'images'      => ['https://s3-us-west-2.amazonaws.com/lana-realtor/images/logo.svg'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary',
            'title'       => 'Lana Kulikovskiy Somers & Associates Realtors', // set false to total remove
            'description' => 'Residential & Commercial Houses and Land for sale/rent in Delta Junction, North Pole, and Fairbanks Alaska', // set false to total remove
            'image'       => 'https://s3-us-west-2.amazonaws.com/lana-realtor/images/logo.svg'
        ],
    ],
];
