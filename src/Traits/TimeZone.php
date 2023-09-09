<?php

namespace Rmunate\Calendario\Traits;

use Carbon\Carbon;
use Rmunate\LaravelConfigRuntime\LaravelRuntime;

trait TimeZone
{
    /**
     * Set the timezone for the class and application.
     *
     * @param string|null $timeZone The timezone to set.
     * @return string The updated timezone.
     */
    private function _setTimeZone(string $timeZone)
    {
        $timeZone = $timeZone ?? LaravelRuntime::config()->get('app.timezone');

        // Set the timezone in Laravel's configuration
        @date_default_timezone_set($timeZone);
        LaravelRuntime::config()->set('app.timezone', $timeZone);

        // Set the class property for timezone
        $this->timeZone = $timeZone;

        // If the initializer is "Today," update the date property
        if ($this->initializer == "Today") {
            $this->date = Carbon::today($this->timeZone)->format('Y-m-d');
        }

        return $this->timeZone;
    }

    /**
     * Get the timezone from the Laravel application configuration.
     *
     * @return string The current timezone.
     */
    private function _getTimeZone()
    {
        return LaravelRuntime::config()->get('app.timezone');
    }
}
