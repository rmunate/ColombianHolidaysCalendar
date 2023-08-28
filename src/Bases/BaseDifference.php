<?php

namespace Rmunate\Calendario\Bases;

abstract class BaseDifference
{
    /**
     * Create a new instance of the class by diffing two dates in the array.
     *
     * @param array $array An array containing two date values.
     * @return static|null An instance of the extending class or null if the array is invalid.
     */
    public static function dates(array $array, $country = 'Colombia')
    {   
        // Check if the array contains two non-empty date values.
        if (isset($array[0]) && isset($array[1]) && !empty($array[0]) && !empty($array[1])) {

            // Create a new instance of the extending class with the provided dates.
            return new static($array[0], $array[1], $country);
        }
        
        // If the array is invalid, return null.
        return null;
    }
}
