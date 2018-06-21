<?php

namespace App\Helpers;


class FormHelper
{
    /**
     * Returns 'checked' if query parameter key is equal to given value
     * @param $key
     * @param $value
     * @return string
     */
    static function checked($key, $value)
    {
        return is_array(request()->input($key)) && in_array($value, request()->input($key)) ? 'checked' : '';
    }

    /**
     * Returns 'selected' if query parameter key is equal to given value
     * @param $key
     * @param $value
     * @return string
     */
    static function selected($key, $value)
    {
        return request()->input($key) == $value ? 'selected' : '';
    }

    /**
     * Return value of given query parameter key
     * @param $key
     * @return array|string
     */
    static function value($key)
    {
        return request()->input($key) ? request()->input($key) : '';
    }

    /**
     * Returns 'active' if query parameter key is equal to given value
     * @param $key
     * @param $value
     * @return string
     */
    static function activeClass($key, $value)
    {
        return request()->input($key) == $value ? 'active' : '';
    }

    /**
     * Returns 'N/A' if $feature is not set
     * @param $feature
     * @param string $textIfValid
     * @return string
     */
    static function fallback($feature, $textIfValid = '')
    {
        if ($feature) {
            return $feature . $textIfValid;
        }

        return 'N/A';
    }

    /**
     * Returns value of given query parameter (referenced by $key) with '+ ' at the end
     * @param $key
     * @return string
     */
    static function numberPlus($key)
    {
        // used for filter bar tab titles
        return request()->input($key) ? request()->input($key) . '+ ' : '';
    }

    /**
     * Returns number of selected checkboxes (in parentheses) given a query parameter key
     * @param $key
     * @return string
     */
    static function numberOfCheckboxesSelected($key)
    {
        // used for filter bar tab titles
        try {
            $numberSelected = count(request()->input($key));
            return $numberSelected > 0 ? "($numberSelected)" : '';
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Format min max price from query
     * @param $minKey
     * @param $maxKey
     * @param $defaultText
     */
    static function formatPriceFromQuery($minKey, $maxKey, $defaultText) {
        $prices = self::getPrices();
        $minVal = request()->input($minKey);
        $maxVal = request()->input($maxKey);
        try {
            if(!$minVal && !$maxVal) {
                // here it doesn't matter which element we pass ($min or $max)
                return $defaultText;
            }

            if(!$minVal) {
                return '$0 - ' . $prices[$maxVal];
            }

            if(!$maxVal) {
                return $prices[$minVal] . '+';
            }

            return $prices[$minVal] . ' - ' . $prices[$maxVal];

        } catch(\Exception $e) {
            return $defaultText;
        }
    }

    /**
     * Format min max area from query
     * @param $minKey
     * @param $maxKey
     * @param $defaultText
     */
    static function formatAreaFromQuery($minKey, $maxKey, $defaultText) {
        $minVal = request()->input($minKey);
        $maxVal = request()->input($maxKey);
        try {
            if(!$minVal && !$maxVal) {
                // here it doesn't matter which element we pass ($min or $max)
                return $defaultText;
            }

            if(!$minVal) {
                return '0 - ' . number_format($maxVal) . ' (sqft)';
            }

            if(!$maxVal) {
                return number_format($minVal) . '+ (sqft)';
            }

            return number_format($minVal) . ' - ' . number_format($maxVal) . ' (sqft)';

        } catch(\Exception $e) {
            return $defaultText;
        }
    }

    /**
     * Returns list of available prices
     * @param string $defaultLabel
     * @param string $defaultValue
     * @return array
     */
    static function getPrices($defaultLabel = 'Default', $defaultValue = '') {
        return [
            $defaultValue => $defaultLabel,
            '10000' => '$10k',
            '20000' => '$20k',
            '30000' => '$30k',
            '50000' => '$50k',
            '100000' => '$100k',
            '130000' => '$130k',
            '150000' => '$150k',
            '200000' => '$200k',
            '250000' => '$250k',
            '300000' => '$300k',
            '350000' => '$350k',
            '400000' => '$400k',
            '450000' => '$450k',
            '500000' => '$500k',
            '550000' => '$550k',
            '600000' => '$600k',
            '650000' => '$650k',
            '700000' => '$700k',
            '750000' => '$750k',
            '800000' => '$800k',
            '850000' => '$850k',
            '900000' => '$900k',
            '950000' => '$950k',
            '1000000' => '$1m',
            '1100000' => '$1.1m',
            '1200000' => '$1.2m',
            '1250000' => '$1.25m',
            '1400000' => '$1.4m',
            '1500000' => '$1.5m',
            '1600000' => '$1.6m',
            '1700000' => '$1.7m',
            '1750000' => '$1.75m',
            '1800000' => '$1.8m',
            '1900000' => '$1.9m',
            '2000000' => '$2m',
            '2250000' => '$2.25m',
            '2500000' => '$2.5m',
            '2750000' => '$2.75m',
            '3000000' => '$3m',
            '3500000' => '$3.5m',
            '4000000' => '$4m',
            '5000000' => '$5m',
            '10000000' => '$10m',
            '20000000' => '$20m'
        ];
    }
}