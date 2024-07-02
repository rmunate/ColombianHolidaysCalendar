<?php

namespace Rmunate\Calendar;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Colombia
{
    /**
     * Establishes and returns an ad-hoc connection to the SQLite database.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private static function connect()
    {
        // Dynamically configure the ad-hoc SQLite connection
        Config::set('database.connections.db_colombiancalendar', [
            'driver'                  => 'sqlite',
            'database'                => dirname(__FILE__).'/Database/SQLite/Holidays.db',
            'prefix'                  => '',
            'foreign_key_constraints' => true,
        ]);

        // Use Laravel's Query Builder on the ad-hoc connection
        return DB::connection('db_colombiancalendar')
                ->table('holidays')
                ->select(
                    'day',
                    'month',
                    'year',
                    'day_name',
                    'month_name',
                    'full_date',
                    'iso_day',
                    'iso_week',
                    'day_of_year',
                    'holiday_reason'
                );
    }

    /**
     * Filter records by a specific column and value.
     *
     * @param string $column The column to filter by.
     * @param mixed  $value  The value to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function where(...$values)
    {
        return self::connect()->where(...$values);
    }

    /**
     * Filter records by a specific column and value, excluding matches.
     *
     * @param string $column The column to filter by.
     * @param mixed  $value  The value to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereNot(...$values)
    {
        return self::connect()->whereNot(...$values);
    }

    /**
     * Filter records by a specific column and value within an array.
     *
     * @param string $column The column to filter by.
     * @param array  $values The values to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereIn(...$values)
    {
        return self::connect()->whereIn(...$values);
    }

    /**
     * Filter records by a specific column and value outside an array.
     *
     * @param string $column The column to filter by.
     * @param array  $values The values to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereNotIn(...$values)
    {
        return self::connect()->whereNotIn(...$values);
    }

    /**
     * Filter records by a specific column and value range.
     *
     * @param string $column The column to filter by.
     * @param array  $values The range values to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereBetween(...$values)
    {
        return self::connect()->whereBetween(...$values);
    }

    /**
     * Filter records by a specific column and value range excluding the range.
     *
     * @param string $column The column to filter by.
     * @param array  $values The range values to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereNotBetween(...$values)
    {
        return self::connect()->whereNotBetween(...$values);
    }

    /**
     * Filter records by a specific date.
     *
     * @param string $column The column to filter by.
     * @param mixed  $value  The value to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereDate(...$values)
    {
        return self::connect()->whereDate(...$values);
    }

    /**
     * Filter records by a specific month.
     *
     * @param string $column The column to filter by.
     * @param mixed  $value  The value to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereMonth(...$values)
    {
        return self::connect()->whereMonth(...$values);
    }

    /**
     * Filter records by a specific day.
     *
     * @param string $column The column to filter by.
     * @param mixed  $value  The value to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereDay(...$values)
    {
        return self::connect()->whereDay(...$values);
    }

    /**
     * Filter records by a specific year.
     *
     * @param string $column The column to filter by.
     * @param mixed  $value  The value to compare.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereYear(...$values)
    {
        return self::connect()->whereYear(...$values);
    }

    /**
     * Retrieve PDO instance from the holidays table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function query()
    {
        return self::connect();
    }

    /**
     * Retrieve all data from the holidays table.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all()
    {
        return self::connect()->get();
    }

    /**
     * Check if a given date is a holiday.
     *
     * @param string $date The date in Y-m-d format.
     *
     * @return bool True if it's a holiday, False otherwise.
     */
    public static function isHoliday(string $date)
    {
        $date = Carbon::parse($date, Config::get('app.timezone'))->format('Y-m-d');

        // Search for a record with the full date in the holidays table
        $response = self::connect()->where('full_date', $date)->first();

        return !empty($response);
    }

    /**
     * Get the description of the holiday if the date is a holiday.
     *
     * @param string $date The date in Y-m-d format.
     *
     * @return string|null The description of the holiday, or null if it's not a holiday.
     */
    public static function getDescriptionIfHoliday(string $date)
    {
        $date = Carbon::parse($date, Config::get('app.timezone'))->format('Y-m-d');

        // Search for a record with the full date in the holidays table
        $response = self::connect()->where('full_date', $date)->first();

        return !empty($response) ? $response->holiday_reason : null;
    }
}
