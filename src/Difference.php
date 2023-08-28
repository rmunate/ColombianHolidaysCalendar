<?php

namespace Rmunate\Calendario;

use Carbon\Carbon;
use Rmunate\Calendario\Traits\Translator;
use Rmunate\Calendario\Bases\BaseDifference;

final class Difference extends BaseDifference
{
    use Translator;

    private $start;
    private $end;
    private $country;

    public function __construct(string $start, string $end, $country) {
        $this->start = $start;
        $this->end = $end;
        $this->country = $country;
    }

    /**
     * Calculate and retrieve the difference between the start and end dates in intervals.
     *
     * @return object An object containing the difference in years, months, days, hours, minutes, and seconds.
     */
    public function intervals()
    {
        $fechaInicio = Carbon::create($this->start);
        $fechaFin = Carbon::create($this->end);

        $intervalo = $fechaInicio->diffAsCarbonInterval($fechaFin);

        return (object) [
            'years' => $intervalo->y,
            'months' => $intervalo->m,
            'days' => $intervalo->d,
            'hours' => $intervalo->h,
            'minutes' => $intervalo->i,
            'seconds' => $intervalo->s
        ];
    }

    /**
     * Get a human-readable representation of the time difference between the start and end dates.
     *
     * @param string|null $lang The language for formatting (optional).
     * @return string A human-readable time difference string.
     */
    public function forHumans($lang = null)
    {
        if (!empty($lang)) {
            Carbon::setLocale($lang);
        }

        $fechaInicio = Carbon::create($this->start);
        $fechaFin = Carbon::create($this->end);

        return $fechaInicio->diffForHumans($fechaFin);
    }

    /**
     * Calculate and retrieve the difference between the start and end dates in days.
     *
     * @param string|null $lang The language for formatting (optional).
     * @return int The difference in days between the start and end dates.
     */
    public function inDays($lang = null)
    {
        $fechaInicio = Carbon::create($this->start);
        $fechaFin = Carbon::create($this->end);

        return $fechaInicio->diffInDays($fechaFin);
    }

    /**
     * Calculate and retrieve the difference in days, excluding specified days of the week.
     *
     * @param string ...$excludedDays The days of the week to exclude.
     * @return int The difference in days, excluding the specified days.
     */
    public function excludingDays(...$excludedDays)
    {
        $excluded = [];
        foreach ($excludedDays as $nameDay) {
            $name = $this->spanishToEnglishDay($nameDay);
            if ($name !== null) {
                array_push($excluded, $name);
            }
        }

        // Parse the start and end dates using Carbon
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($this->end);

        // Initialize a counter for the difference in days
        $difference = 0;

        // Iterate through each day in the range
        while ($start->lte($end)) {

            // Check if the current day name is in the list of excluded days
            if (!in_array($start->englishDayOfWeek, $excluded)) {
                $difference++;
            }

            // Move to the next day
            $start->addDay();
        }

        return $difference;
    }

    /**
     * Calculate and retrieve the difference in days, excluding holidays.
     *
     * @return int The difference in days, excluding holidays.
     */
    public function excludingHolidays()
    {
        //... (Implementation missing)
    }

    /**
     * Calculate and retrieve the difference in days, excluding holidays and specified days of the week.
     *
     * @param string ...$excludedDays The days of the week to exclude.
     * @return int The difference in days, excluding holidays and specified days.
     */
    public function excludingHolidaysAndThisDays(...$excludedDays)
    {
        //... (Implementation missing)
    }
}
