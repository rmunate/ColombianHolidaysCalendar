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
        $country = new static();
        
        return Collection::make($country->{$country}());
    }
}
