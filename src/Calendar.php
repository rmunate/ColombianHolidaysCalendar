<?php

namespace Rmunate\Calendario;

use Carbon\Carbon;
use Rmunate\Calendario\Traits\TimeZone;
use Rmunate\Calendario\Holidays\Country;
use Rmunate\Calendario\Traits\Translator;
use Rmunate\Calendario\Bases\BaseCalendar;
use Rmunate\Calendario\Traits\CalendarStatic;
use Rmunate\Calendario\Traits\HolidaysFromCollect;

final class Calendar extends BaseCalendar 
{
    use TimeZone; // Include the TimeZone trait.
    use Translator; // Include the Translator trait.
    use CalendarStatic; // Include the CalendarStatic trait.
    use HolidaysFromCollect; // Include the HolidaysFromCollect trait.
    
    private $initializer;
    private $timeZone;
    private $country;
    private $date;

    /**
     * Constructor for the Calendar class.
     *
     * @param mixed $type The type or initialization parameter.
     * @param string|null $date The date to work with (default is null).
     * @param string|null $timeZone The timezone to use (default is null).
     * @param string|null $country The country for holiday data (default is null).
     */
    public function __construct($type, $date = null, $timeZone = null, $country = null) {
        $this->initializer = $type;
        $this->date = $date;
        $this->timeZone = $timeZone;
        $this->country = $country;
        $this->_setTimeZone($this->timeZone);
    }

    /**
     * Set the country for holiday data.
     *
     * @param string $country The country to set.
     * @return $this The current instance of the Calendar class.
     */
    public function country(string $country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Set the timezone for the calendar.
     *
     * @param string $timeZone The timezone to set.
     * @return $this The current instance of the Calendar class.
     */
    public function timezone(string $timeZone)
    {
        $this->_setTimeZone($timeZone);
        return $this;
    }

   /**
     * Check if the current date is a holiday.
     *
     * @return bool True if the date is a holiday, false otherwise.
     */
    public function isHoliday()
    {
        $date = $this->holidays()->where("full_date", $this->date)->first();
        return !empty($date);
    }

    /**
     * Get the description of the holiday if the current date is a holiday.
     *
     * @return string|null The description of the holiday, or null if it's not a holiday.
     */
    public function description()
    {
        $date = $this->holidays()->where("full_date", $this->date)->first();
        return !empty($date) ? $date['holiday_reason'] : null;
    }

    /**
     * Get the description of the holiday if the current date is a holiday.
     *
     * @return string|null The description of the holiday, or null if it's not a holiday.
     */
    public function getDescriptionIfHoliday()
    {
        $date = $this->holidays()->where("full_date", $this->date)->first();
        return !empty($date) ? $date['holiday_reason'] : null;
    }

    /**
     * Check if the current date is a Monday.
     *
     * @return bool True if the date is a Monday, false otherwise.
     */
    public function isMonday()
    {
        return Carbon::parse($this->date)->dayOfWeek === Carbon::MONDAY;
    }

    /**
     * Check if the current date is a Tuesday.
     *
     * @return bool True if the date is a Tuesday, false otherwise.
     */
    public function isTuesday()
    {
        return Carbon::parse($this->date)->dayOfWeek === Carbon::TUESDAY;
    }

    /**
     * Check if the current date is a Wednesday.
     *
     * @return bool True if the date is a Wednesday, false otherwise.
     */
    public function isWednesday()
    {
        return Carbon::parse($this->date)->dayOfWeek === Carbon::WEDNESDAY;
    }

    /**
     * Check if the current date is a Thursday.
     *
     * @return bool True if the date is a Thursday, false otherwise.
     */
    public function isThursday()
    {
        return Carbon::parse($this->date)->dayOfWeek === Carbon::THURSDAY;
    }

    /**
     * Check if the current date is a Friday.
     *
     * @return bool True if the date is a Friday, false otherwise.
     */
    public function isFriday()
    {
        return Carbon::parse($this->date)->dayOfWeek === Carbon::FRIDAY;
    }

    /**
     * Check if the current date is a Saturday.
     *
     * @return bool True if the date is a Saturday, false otherwise.
     */
    public function isSaturday()
    {
        return Carbon::parse($this->date)->dayOfWeek === Carbon::SATURDAY;
    }

    /**
     * Check if the current date is a Sunday.
     *
     * @return bool True if the date is a Sunday, false otherwise.
     */
    public function isSunday()
    {
        return Carbon::parse($this->date)->dayOfWeek === Carbon::SUNDAY;
    }

    /**
     * Get the day number as a string (e.g., '01' for the 1st day of the month).
     *
     * @return string The day number as a string.
     */
    public function getDayNumberString()
    {
        return Carbon::parse($this->date)->format('d');
    }

    /**
     * Get the day number as an integer (e.g., 1 for the 1st day of the month).
     *
     * @return int The day number as an integer.
     */
    public function getDayNumberInteger()
    {
        return intval(Carbon::parse($this->date)->format('j'));
    }

    /**
     * Get the ISO day number as an integer (1 for Monday, 7 for Sunday).
     *
     * @return int The ISO day number as an integer.
     */
    public function getDayNumberISO()
    {
        return intval(Carbon::parse($this->date)->format('N'));
    }

    /**
     * Get the day of the year as an integer (1 to 366).
     *
     * @return int The day of the year as an integer.
     */
    public function getDayYear()
    {
        return intval(Carbon::parse($this->date)->format('z')) + 1;
    }

    /**
     * Get the name of the day in English (e.g., "Monday").
     *
     * @return string The name of the day in English.
     */
    public function getNameDayEnglish()
    {
        return Carbon::parse($this->date)->format('l');
    }

    /**
     * Get the name of the day in Spanish.
     *
     * @return string The name of the day in Spanish.
     */
    public function getNameDaySpanish()
    {
        $inEnglish = Carbon::parse($this->date)->format('l');
        return $this->englishToSpanishDay($inEnglish);
    }

    /**
     * Convert the current date to an associative array with day, month, and year keys.
     *
     * @return array An associative array with day, month, and year keys.
     */
    public function toArray()
    {
        $now = date('d-m-Y', strtotime($this->date));
        return [
            'day' => substr($now, -10, 2),
            'month' => substr($now, -7, 2),
            'year' => substr($now, -4, 4)
        ];
    }

    /**
     * Convert the current date to an object with day, month, and year properties.
     *
     * @return object An object with day, month, and year properties.
     */
    public function destructure()
    {
        $now = date('d-m-Y', strtotime($this->date));
        return (object)[
            'day' => substr($now, -10, 2),
            'month' => substr($now, -7, 2),
            'year' => substr($now, -4, 4)
        ];
    }

    /**
     * Generate an array of dates that starts with the current date and goes forward by the specified number of days.
     *
     * @param int $amount The number of days to add.
     * @return array An array of dates.
     */
    public function fixUp(int $amount = 0)
    {
        $response = [$this->date];

        if ($amount >= 0) {
            // Store the initial date in a variable for clarity
            $currentDate = $this->date;

            for ($dayP = 1; $dayP <= $amount; $dayP++) {
                // Calculate the next date
                $nextDate = date("Y-m-d", strtotime($currentDate . " + 1 day"));
                // Add Value
                array_push($response, $nextDate);
                // Update the current date
                $currentDate = $nextDate;
            }
        }

        return $response;
    }

    /**
     * Generate an array of dates that starts with the current date and goes backward by the specified number of days.
     *
     * @param int $amount The number of days to subtract.
     * @return array An array of dates.
     */
    public function fixDown(int $amount = 0)
    {
        $response = [$this->date];

        if ($amount >= 0) {
            // Store the initial date in a variable for clarity
            $currentDate = $this->date;

            for ($dayP = 1; $dayP <= $amount; $dayP++) {
                // Calculate the previous date
                $previousDate = date("Y-m-d", strtotime($currentDate . " - 1 day"));
                // Add Value
                array_push($response, $previousDate);
                // Update the current date
                $currentDate = $previousDate;
            }
        }

        return $response;
    }

    /**
     * Add a specified number of days to the current date.
     *
     * @param int $amount The number of days to add.
     * @return string The new date as a string in 'Y-m-d' format.
     */
    public function addDays(int $amount = 0)
    {
        $date = Carbon::parse($this->date);
        $newDate = $date->addDays($amount);

        return $newDate->toDateString();
    }

    /**
     * Subtract a specified number of days from the current date.
     *
     * @param int $amount The number of days to subtract.
     * @return string The new date as a string in 'Y-m-d' format.
     */
    public function reduceDays(int $amount = 0)
    {
        $date = Carbon::parse($this->date);
        $newDate = $date->subDays($amount);

        return $newDate->toDateString();
    }

    /**
     * Alias for the `reduceDays` method to subtract a specified number of days from the current date.
     *
     * @param int $amount The number of days to subtract.
     * @return string The new date as a string in 'Y-m-d' format.
     */
    public function subDays(int $amount = 0)
    {
        return $this->reduceDays($amount);
    }

    /**
     * Add a specified number of months to the current date.
     *
     * @param int $amount The number of months to add.
     * @return string The new date as a string in 'Y-m-d' format.
     */
    public function addMonths(int $amount = 0)
    {
        $date = Carbon::parse($this->date);
        $newDate = $date->addMonths($amount);

        return $newDate->toDateString();
    }

    /**
     * Subtract a specified number of months from the current date.
     *
     * @param int $amount The number of months to subtract.
     * @return string The new date as a string in 'Y-m-d' format.
     */
    public function reduceMonths(int $amount = 0)
    {
        $date = Carbon::parse($this->date);
        $newDate = $date->subMonths($amount);

        return $newDate->toDateString();
    }

    /**
     * Alias for the `reduceMonths` method to subtract a specified number of months from the current date.
     *
     * @param int $amount The number of months to subtract.
     * @return string The new date as a string in 'Y-m-d' format.
     */
    public function subMonths(int $amount = 0)
    {
        return $this->reduceMonths($amount);
    }

    /**
     * Add a specified number of years to the current date.
     *
     * @param int $amount The number of years to add.
     * @return string The new date as a string in 'Y-m-d' format.
     */
    public function addYears(int $amount = 0)
    {
        $date = Carbon::parse($this->date);
        $newDate = $date->addYears($amount);

        return $newDate->toDateString();
    }

    /**
     * Subtract a specified number of years from the current date.
     *
     * @param int $amount The number of years to subtract.
     * @return string The new date as a string in 'Y-m-d' format.
     */
    public function reduceYears(int $amount = 0)
    {
        $date = Carbon::parse($this->date);
        $newDate = $date->subYears($amount);

        return $newDate->toDateString();
    }

    /**
     * Alias for the `reduceYears` method to subtract a specified number of years from the current date.
     *
     * @param int $amount The number of years to subtract.
     * @return string The new date as a string in 'Y-m-d' format.
     */
    public function subYears(int $amount = 0)
    {
        return $this->reduceYears($amount);
    }

    /**
     * Get the ISO week number of the current date.
     *
     * @return int The ISO week number.
     */
    public function getWeekISO()
    {
        return intval(Carbon::parse($this->date)->format('W'));
    }

    /**
     * Get the timezone of the calendar.
     *
     * @return string The timezone.
     */
    public function getTimeZone()
    {
        return $this->_getTimeZone();
    }

    /**
     * Get the name of the month in English for the current date.
     *
     * @return string The name of the month.
     */
    public function getNameMonthEnglish()
    {
        return Carbon::parse($this->date)->format("F");
    }

    /**
     * Get the name of the month in Spanish for the current date.
     *
     * @return string The name of the month in Spanish.
     */
    public function getNameMonthSpanish()
    {
        $inEnglish = Carbon::parse($this->date)->format("F");
        return $this->englishToSpanishMonth($inEnglish);
    }

    /**
     * Get the month number of the current date as a string (e.g., "01" for January).
     *
     * @return string The month number as a string.
     */
    public function getMonthNumberString()
    {
        return Carbon::parse($this->date)->format("m");
    }

    /**
     * Get the month number of the current date as an integer (e.g., 1 for January).
     *
     * @return int The month number as an integer.
     */
    public function getMonthNumberInteger()
    {
        return intval(Carbon::parse($this->date)->format("n"));
    }

    /**
     * Get the year of the current date.
     *
     * @return int The year as an integer.
     */
    public function getYear()
    {
        return intval(Carbon::parse($this->date)->format("Y"));
    }

    /**
     * Get a Carbon instance of the current date.
     *
     * @return \Carbon\Carbon The Carbon instance of the current date.
     */
    public function carbon()
    {
        return Carbon::parse($this->date);
    }

    /**
     * Check if the current date is in the past.
     *
     * @return bool True if the date is in the past, false otherwise.
     */
    public function isPast()
    {
        return Carbon::parse($this->date)->isPast($this->date);
    }

    /**
     * Check if the current date is in the future.
     *
     * @return bool True if the date is in the future, false otherwise.
     */
    public function isFuture()
    {
        return Carbon::parse($this->date)->isFuture($this->date);
    }
}