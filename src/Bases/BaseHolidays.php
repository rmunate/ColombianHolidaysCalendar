<?php

namespace Rmunate\Calendario\Bases;

abstract class BaseHolidays
{
    /**
     * Create a new instance of the class for a specific country.
     *
     * @param string $country The name of the country.
     *
     * @return static
     */
    public static function country($country = 'Colombia')
    {
        return new static($country);
    }

    /**
     * Create a new instance of the class for Colombia.
     *
     * @return static
     */
    public static function colombia()
    {
        return new static('Colombia');
    }
    
}
