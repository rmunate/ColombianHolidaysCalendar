<?php

namespace Rmunate\Calendario\Bases;

use Illuminate\Support\Collection;

abstract class BaseCountry
{
    /**
     * Get a collection of holidays for the country.
     *
     * @param string $country
     *
     * @return Collection
     */
    public static function get(string $country)
    {
        // Convert the country name to lowercase and remove hyphens
        $country = str_replace('-', '', mb_strtolower($country));

        // Create an instance of the class and retrieve country data
        $instance = new static();
        $countryData = $instance->{$country}();

        // Return the data as a collection
        return Collection::make($countryData);
    }
}
