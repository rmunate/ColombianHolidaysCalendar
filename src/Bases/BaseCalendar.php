<?php

namespace Rmunate\Calendario\Bases;

abstract class BaseCalendar
{
    /**
     * Create a new instance representing the current date.
     *
     * @param string|null $timeZone Optional timezone identifier.
     * @return static A new instance representing the current date.
     */
    public static function now($timeZone = null, $country = 'Colombia')
    {
        return new static('now', null, $timeZone, $country);
    }

    /**
     * Create a new instance representing a specific date.
     *
     * @param string $date The date in 'Y-m-d' format.
     * @param string|null $timeZone Optional timezone identifier.
     * @return static A new instance representing the specified date.
     */
    public static function date(string $date, $timeZone = null, $country = 'Colombia')
    {
        return new static('date', $date, $timeZone, $country);
    }
}
