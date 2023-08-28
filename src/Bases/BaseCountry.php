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
        $country = lcfirst(str_replace("-", "", $country));
        return Collection::make((new static())->{$country}());
    }
}
