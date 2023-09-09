<?php

namespace Rmunate\Calendario\Bases;

use Carbon\Carbon;
use Rmunate\LaravelConfigRuntime\LaravelRuntime;

abstract class BaseCalendar
{
    const CALENDAR_DEFAULT_COUNTRY = 'Colombia';

    /**
     * Create a new instance with the current date.
     *
     * @param string|null $timeZone The timezone to use (optional).
     *
     * @return static
     */
    public static function today(string $timeZone = null)
    {
        $timeZone = $timeZone ?? LaravelRuntime::config()->get('app.timezone');
        $date = Carbon::today($timeZone)->format('Y-m-d');

        return new static('Today', $date, $timeZone, self::CALENDAR_DEFAULT_COUNTRY);
    }

    /**
     * Create a new instance with a supplied date.
     *
     * @param string|null $date     The date to use (optional).
     * @param string|null $timeZone The timezone to use (optional).
     *
     * @return static
     */
    public static function date(string $date, string $timeZone = null)
    {
        $timeZone = $timeZone ?? LaravelRuntime::config()->get('app.timezone');
        $date = Carbon::parse($date, $timeZone)->format('Y-m-d');

        return new static('Date', $date, $timeZone, self::CALENDAR_DEFAULT_COUNTRY);
    }

    /**
     * Create a new instance with a supplied timezone.
     *
     * @param string|null $timeZone The timezone to use (optional).
     *
     * @return static
     */
    public static function timeZone(string $timeZone)
    {
        $timeZone = $timeZone ?? LaravelRuntime::config()->get('app.timezone');
        $date = Carbon::today($timeZone)->format('Y-m-d');

        return new static('TimeZone', $date, $timeZone, self::CALENDAR_DEFAULT_COUNTRY);
    }
}
