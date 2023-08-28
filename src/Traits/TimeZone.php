<?php

namespace Rmunate\Calendario\Traits;

use DateTime;
use DateTimeZone;
use Rmunate\LaravelConfigRuntime\LaravelRuntime;

trait TimeZone
{
    /**
     * Set the timezone for the class and application.
     *
     * @param string|null $timeZone The timezone to set.
     * @return string The updated timezone.
     */
    private function _setTimeZone($timeZone)
    {
        if (empty($timeZone)) {
            // Use Laravel's configured timezone if $timeZone is empty
            $timeZone = LaravelRuntime::config()->get('app.timezone');
        }

        // Set the timezone in PHP
        @date_default_timezone_set($timeZone);

        // Set the timezone in Laravel's configuration
        LaravelRuntime::config()->set('app.timezone', $timeZone);

        // Set the class property for timezone
        $this->timeZone = $timeZone;

        // If the initializer is "now," update the date property
        if ($this->initializer == "now") {
            $currentDateTime = new DateTime('now', new DateTimeZone($this->timeZone));
            $this->date = $currentDateTime->format('Y-m-d');
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
