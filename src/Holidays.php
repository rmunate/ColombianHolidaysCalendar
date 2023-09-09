<?php

namespace Rmunate\Calendario;

use Rmunate\Calendario\Bases\BaseHolidays;
use Rmunate\Calendario\Traits\HolidaysFromCollect;
use Rmunate\Calendario\Traits\Translator;

final class Holidays extends BaseHolidays
{
    use HolidaysFromCollect;
    use Translator;

    private $country;
    private $response;

    /**
     * Constructor for the class.
     *
     * @param string $country The country for which holidays are requested.
     */
    public function __construct($country)
    {
        $this->country = $country;
    }

    /**
     * Returns the available years for querying holidays.
     *
     * @return array
     */
    public function yearsAvailable()
    {
        return $this->holidays()->pluck('year')->unique()->values()->toArray();
    }

    /**
     * Returns the entire collection of holidays.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->holidays();
    }

    // Methods for filtering holidays:

    /**
     * Filter holidays by a specific year.
     *
     * @param int $year The year to filter by.
     *
     * @return $this
     */
    public function year(int $year)
    {
        $this->response = $this->query()->where('year', $year)->values();

        return $this;
    }

    /**
     * Filter holidays by multiple years.
     *
     * @param array ...$years An array of years to filter by.
     *
     * @return $this
     */
    public function years(...$years)
    {
        $this->response = $this->query()->whereIn('year', $years)->values();

        return $this;
    }

    /**
     * Filter holidays by a specific month.
     *
     * @param int $month The month to filter by.
     *
     * @return $this
     */
    public function month(int $month)
    {
        $this->response = $this->query()->where('month', $month)->values();

        return $this;
    }

    /**
     * Filter holidays by multiple months.
     *
     * @param array ...$months An array of months to filter by.
     *
     * @return $this
     */
    public function months(...$months)
    {
        $this->response = $this->query()->whereIn('month', $months)->values();

        return $this;
    }

    /**
     * Filter holidays by a date range.
     *
     * @param array $between An array containing the start and end dates.
     *
     * @return $this
     */
    public function between(array $between)
    {
        $this->response = $this->query()->whereBetween('full_date', $between)->values();

        return $this;
    }

    /**
     * Exclude specific days from the holidays.
     *
     * @param string ...$days An array of days to exclude.
     *
     * @return $this
     */
    public function notInclude(...$days)
    {
        $daysArray = [];
        foreach ($days as $value) {
            $name = $this->spanishToEnglishDay($value);
            array_push($daysArray, ($name !== null) ? $name : $value);
        }

        $this->response = $this->query()->whereNotIn('day_name', $daysArray)->values();

        return $this;
    }

    /**
     * Exclude specific days from the holidays.
     *
     * @param string ...$days An array of days to exclude.
     *
     * @return $this
     */
    public function except(...$days)
    {
        $daysArray = [];
        foreach ($days as $value) {
            $name = $this->spanishToEnglishDay($value);
            array_push($daysArray, ($name !== null) ? $name : $value);
        }

        $this->response = $this->query()->whereNotIn('day_name', $daysArray)->values();

        return $this;
    }

    /**
     * Include only specific days in the holidays.
     *
     * @param string ...$days An array of days to include.
     *
     * @return $this
     */
    public function only(...$days)
    {
        $daysArray = [];
        foreach ($days as $value) {
            $name = $this->spanishToEnglishDay($value);
            array_push($daysArray, ($name !== null) ? $name : $value);
        }

        $this->response = $this->query()->whereIn('day_name', $daysArray)->values();

        return $this;
    }

    /**
     * Include specific days in the holidays.
     *
     * @param string ...$days An array of days to include.
     *
     * @return $this
     */
    public function include(...$days)
    {
        $daysArray = [];
        foreach ($days as $value) {
            $name = $this->spanishToEnglishDay($value);
            array_push($daysArray, ($name !== null) ? $name : $value);
        }

        $this->response = $this->query()->whereIn('day_name', $daysArray)->values();

        return $this;
    }

    // Methods for retrieving and formatting results:

    /**
     * Get the filtered holidays as a collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return $this->response();
    }

    /**
     * Get the filtered holidays as a collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function toCollect()
    {
        return $this->response();
    }

    /**
     * Get the filtered holidays as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response()->toArray();
    }

    /**
     * Get the filtered holidays as a JSON string.
     *
     * @return string
     */
    public function toJson()
    {
        return $this->response()->toJson();
    }

    /**
     * Get the count of filtered holidays.
     *
     * @return int
     */
    public function count()
    {
        return $this->response()->count();
    }

    /**
     * Get the first filtered holiday.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->response()->first();
    }

    /**
     * Get the last filtered holiday.
     *
     * @return mixed
     */
    public function last()
    {
        return $this->response()->last();
    }

    /**
     * Pluck a column's value from the filtered holidays.
     *
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function pluck($column, $key = null)
    {
        return $this->response()->pluck($column, $key);
    }

    /**
     * Group the filtered holidays by a given key.
     *
     * @param string $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function groupBy($key)
    {
        return $this->response()->groupBy($key);
    }
}
