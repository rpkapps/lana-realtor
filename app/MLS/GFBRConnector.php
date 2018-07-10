<?php

namespace App\MLS;


class GFBRConnector extends Connector
{
    const TYPES = [
        'RESIDENTIAL' => 'RE_1',
        'LAND' => 'LD_2',
        'COMMERCIAL/INDUSTRIAL' => 'CI_3',
        'MULTI-FAMILY' => 'MF_4',
        'RENTAL RESIDENTIAL' => 'RR_5'
    ];


    /**
     * Get properties
     *
     * @return array|mixed
     * @throws \PHRETS\Exceptions\CapabilityUnavailable
     */
    public function getProperties()
    {
        $properties = [];

        foreach (self::TYPES as $type) {
            $properties = array_merge(
                $properties,
                $this->session->Search('Property', $type, '(L_StatusCatID=1)', ['Limit' => 1])->toArray()
            );
        }

        return $properties;
    }
}