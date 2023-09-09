<?php

namespace Rmunate\Calendario\Traits;

use Carbon\Carbon;
use Rmunate\Calendario\Holidays;
use Rmunate\Calendario\Difference;

trait CalendarStatic
{
    /**
     * Get the number of days in a month for a given year and month.
     *
     * @param int $year
     * @param int $month
     * @return int|null
     */
    public static function getDaysInMonth(int $year, int $month)
    {
        $month = ((strlen($month) <= 2) && (intval($month) <= 12)) ? str_pad($month, 2, "0", STR_PAD_LEFT) : null;
        if (!empty($month)) {
            return intval(date('t', strtotime($year . '-' . $month . '-01')));
        }
        return null;
    }

    /**
     * Get the first day of the month for a given year and month.
     *
     * @param int $year
     * @param int $month
     * @return string
     */
    public static function getFirstDayOfMonth(int $year, int $month)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        return $startDate->format('Y-m-d');
    }

    /**
     * Get the last day of the month for a given year and month.
     *
     * @param int $year
     * @param int $month
     * @return string
     */
    public static function getLastDayOfMonth(int $year, int $month)
    {
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        return $endDate->format('Y-m-d');
    }

    /**
     * Check if a given year is a leap year.
     *
     * @param int $year
     * @return bool
     */
    public static function isLeapYear(int $year)
    {
        return Carbon::create($year, 1, 1)->isLeapYear();
    }

    /**
     * Create a new instance of the class by diffing two dates in the array.
     *
     * @param array $array An array containing two date values.
     * @return static|null An instance of the extending class or null if the array is invalid.
     */
    public static function diff(array $array)
    {   
        if (isset($array[0]) && isset($array[1]) && !empty($array[0]) && !empty($array[1])) {
            return Difference::dates($array);
        }
        
        return null;
    }

    /**
     * Get the holidays for a specific country.
     *
     * @param string $country The name of the country (default is 'Colombia').
     * @return Holidays The Holidays instance for the specified country.
     */
    public static function onlyHolidays($country = 'Colombia')
    {
        return Holidays::country($country);
    }

}
