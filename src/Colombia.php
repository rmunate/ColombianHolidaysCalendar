<?php

namespace Rmunate\Calendar;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Connectors\SQLiteConnector;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use PDO;
use Pdo\Sqlite;
use stdClass;

/**
 * Consultas de festivos nacionales y domingos en el calendario colombiano.
 */
class Colombia
{
    /** Conexión compartida al archivo del paquete, independiente de la aplicación. */
    private static ?SQLiteConnection $connection = null;

    /**
     * Abre el SQLite del paquete en modo de solo lectura.
     */
    private static function connect(): SQLiteConnection
    {
        $database = implode(DIRECTORY_SEPARATOR, [__DIR__, 'Database', 'SQLite', 'Holidays.db']);
        $config = [
            'name'     => 'db_colombiancalendar',
            'driver'   => 'sqlite',
            'database' => $database,
            'options'  => class_exists(Sqlite::class)
                ? [Sqlite::ATTR_OPEN_FLAGS => Sqlite::OPEN_READONLY]
                : [PDO::SQLITE_ATTR_OPEN_FLAGS => PDO::SQLITE_OPEN_READONLY],
        ];

        return new SQLiteConnection((new SQLiteConnector())->connect($config), $database, '', $config);
    }

    /**
     * Inicia una consulta independiente con las columnas públicas del calendario.
     */
    public static function query(): Builder
    {
        return (self::$connection ??= self::connect())->table('holidays')->select(
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
     * Obtiene todas las fechas disponibles, en orden cronológico.
     *
     * @return Collection<int, stdClass>
     */
    public static function all(): Collection
    {
        return self::query()->orderBy('full_date')->get();
    }

    /**
     * Aplica una condición del Query Builder.
     *
     * @param mixed ...$values Argumentos de {@see Builder::where()}.
     */
    public static function where(...$values): Builder
    {
        return self::query()->where(...$values);
    }

    /**
     * Excluye las filas que coinciden con la condición indicada.
     *
     * @param mixed  $column   Columna, expresión, arreglo de condiciones o cierre.
     * @param mixed  $operator Operador de comparación o valor si se omite el operador.
     * @param mixed  $value    Valor que se compara.
     * @param string $boolean  Conjunción SQL: `and` u `or`.
     */
    public static function whereNot($column, $operator = null, $value = null, string $boolean = 'and'): Builder
    {
        $query = self::query();

        if (method_exists($query, 'whereNot')) {
            return $query->whereNot($column, $operator, $value, $boolean);
        }

        // Las primeras versiones del Query Builder no exponen whereNot().
        return $query->whereNested(static function (Builder $nested) use ($column, $operator, $value): void {
            $nested->where($column, $operator, $value);
        }, $boolean.' not');
    }

    /**
     * Incluye las filas cuyo valor pertenece al conjunto indicado.
     *
     * @param mixed ...$values Argumentos de {@see Builder::whereIn()}.
     */
    public static function whereIn(...$values): Builder
    {
        return self::query()->whereIn(...$values);
    }

    /**
     * Excluye las filas cuyo valor pertenece al conjunto indicado.
     *
     * @param mixed ...$values Argumentos de {@see Builder::whereNotIn()}.
     */
    public static function whereNotIn(...$values): Builder
    {
        return self::query()->whereNotIn(...$values);
    }

    /**
     * Incluye las filas cuyo valor está dentro del rango, incluidos sus extremos.
     *
     * @param mixed ...$values Argumentos de {@see Builder::whereBetween()}.
     */
    public static function whereBetween(...$values): Builder
    {
        return self::query()->whereBetween(...$values);
    }

    /**
     * Excluye las filas cuyo valor está dentro del rango, incluidos sus extremos.
     *
     * @param mixed ...$values Argumentos de {@see Builder::whereNotBetween()}.
     */
    public static function whereNotBetween(...$values): Builder
    {
        return self::query()->whereNotBetween(...$values);
    }

    /**
     * Compara la parte de fecha de una columna.
     *
     * @param mixed ...$values Argumentos de {@see Builder::whereDate()}.
     */
    public static function whereDate(...$values): Builder
    {
        return self::query()->whereDate(...$values);
    }

    /**
     * Compara el mes extraído de una columna de fecha.
     *
     * @param mixed ...$values Argumentos de {@see Builder::whereMonth()}.
     */
    public static function whereMonth(...$values): Builder
    {
        return self::query()->whereMonth(...$values);
    }

    /**
     * Compara el día del mes extraído de una columna de fecha.
     *
     * @param mixed ...$values Argumentos de {@see Builder::whereDay()}.
     */
    public static function whereDay(...$values): Builder
    {
        return self::query()->whereDay(...$values);
    }

    /**
     * Compara el año extraído de una columna de fecha.
     *
     * @param mixed ...$values Argumentos de {@see Builder::whereYear()}.
     */
    public static function whereYear(...$values): Builder
    {
        return self::query()->whereYear(...$values);
    }

    /**
     * Indica si una fecha (preferentemente Y-m-d) está en el calendario.
     *
     * @throws InvalidFormatException Si la fecha está vacía o es inválida.
     */
    public static function isHoliday(string $date): bool
    {
        return self::queryDate($date)->exists();
    }

    /**
     * Obtiene el motivo de la fecha o null si no está en el calendario.
     *
     * @throws InvalidFormatException Si la fecha está vacía o es inválida.
     */
    public static function getDescriptionIfHoliday(string $date): ?string
    {
        return self::queryDate($date)->select('holiday_reason')->value('holiday_reason');
    }

    /**
     * Normaliza la fecha con Carbon sin aceptar fechas imposibles.
     *
     * @throws InvalidFormatException
     */
    private static function queryDate(string $date): Builder
    {
        if (trim($date) === '' || date_parse($date)['warning_count'] > 0) {
            throw new InvalidFormatException('Se requiere una fecha válida.');
        }

        $normalized = Carbon::parse($date, Config::get('app.timezone'))->toDateString();

        return self::query()->where('full_date', $normalized);
    }
}
