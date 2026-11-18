<?php

namespace Rmunate\Calendar\Tests;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\TestCase;
use Rmunate\Calendar\Colombia;

/**
 * Pruebas de integración de la API con el SQLite distribuido.
 */
final class CalendarTest extends TestCase
{
    /**
     * Configura una base de la aplicación que no debe confundirse con el calendario.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $app = class_exists(Application::class) ? new Application(dirname(__DIR__)) : new Container();
        $app->instance('config', new Repository([
            'app'      => ['timezone' => 'America/Bogota'],
            'database' => [
                'default'     => 'db_colombiancalendar',
                'connections' => [
                    'db_colombiancalendar' => ['driver' => 'sqlite', 'database' => ':memory:'],
                ],
            ],
        ]));
        if ($app instanceof Application) {
            $app->register(DatabaseServiceProvider::class);
        } else {
            (new DatabaseServiceProvider($app))->register();
        }

        Facade::setFacadeApplication($app);
    }

    /**
     * Restaura el estado global de Carbon y las fachadas entre pruebas.
     */
    protected function tearDown(): void
    {
        Carbon::setTestNow();
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(null);
        Container::setInstance(null);

        parent::tearDown();
    }

    /**
     * Contrasta el calendario nacional de 2026 con las fechas de descanso de ambas leyes.
     */
    public function testListsEveryNationalHolidayIn2026(): void
    {
        $dates = Colombia::whereNotIn('holiday_reason', ['Día Domingo Festivo'])
            ->where('year', 2026)
            ->orderBy('full_date')
            ->pluck('full_date')
            ->all();

        self::assertSame([
            '2026-01-01', '2026-01-12', '2026-03-23', '2026-04-02', '2026-04-03',
            '2026-05-01', '2026-05-18', '2026-06-08', '2026-06-15', '2026-06-29',
            '2026-07-13', '2026-07-20', '2026-08-07', '2026-08-17', '2026-10-12',
            '2026-11-02', '2026-11-16', '2026-12-08', '2026-12-25',
        ], $dates);
    }

    /**
     * Valida la fecha efectiva y la vigencia del nuevo festivo, sin perder los domingos.
     */
    public function testResolvesObservedDatesAndSundays(): void
    {
        self::assertTrue(Colombia::isHoliday('2026-07-13'));
        self::assertSame(
            'Día de Nuestra Señora del Rosario de Chiquinquirá',
            Colombia::getDescriptionIfHoliday('2026-07-13')
        );
        self::assertFalse(Colombia::isHoliday('2026-07-09'));
        self::assertNull(Colombia::getDescriptionIfHoliday('2025-07-14'));
        self::assertTrue(Colombia::isHoliday('2029-07-09'));
        self::assertTrue(Colombia::isHoliday('2026-07-12'));
        self::assertSame('Día Domingo Festivo', Colombia::getDescriptionIfHoliday('2026-07-12'));
    }

    /**
     * Conserva todos los motivos nacionales cuando dos reglas coinciden.
     */
    public function testPreservesReasonsOnOverlappingDates(): void
    {
        self::assertSame('Inmaculada Concepción', Colombia::getDescriptionIfHoliday('2024-12-08'));
        self::assertFalse(Colombia::isHoliday('2024-12-09'));
        self::assertSame(
            'Festivo por el día de San Pedro y San Pablo / Festivo por el día del Sagrado Corazón de Jesús',
            Colombia::getDescriptionIfHoliday('2014-06-30')
        );
        self::assertSame(1, Colombia::where('full_date', '2014-06-30')->count());
    }

    /**
     * Verifica los límites de cobertura y el orden de la colección completa.
     */
    public function testReturnsChronologicalResultsWithinTheSupportedYears(): void
    {
        $calendar = Colombia::all();
        self::assertInstanceOf(Collection::class, $calendar);
        self::assertSame('2000-01-01', $calendar->first()->full_date);
        self::assertSame(2100, (int) $calendar->last()->year);
        self::assertSame($calendar->pluck('full_date')->sort()->values()->all(), $calendar->pluck('full_date')->all());
        self::assertTrue(Colombia::isHoliday('2100-12-25'));
        self::assertFalse(Colombia::isHoliday('1999-12-25'));
        self::assertNull(Colombia::getDescriptionIfHoliday('2101-01-01'));
    }

    /**
     * Verifica que los filtros de exclusión respetan las condiciones agrupadas.
     */
    public function testNegatesWholeConditions(): void
    {
        $dates = ['2026-04-02', '2026-07-12', '2026-07-13'];

        self::assertSame(
            ['2026-04-02', '2026-07-13'],
            Colombia::whereNot('holiday_reason', 'Día Domingo Festivo')
                ->whereIn('full_date', $dates)->orderBy('full_date')->pluck('full_date')->all()
        );
        self::assertSame(
            ['2026-04-02'],
            Colombia::whereNot(['year' => 2026, 'month' => 7])
                ->whereIn('full_date', $dates)->pluck('full_date')->all()
        );
    }

    /**
     * Verifica rangos inclusivos y su complemento en la conexión SQLite.
     */
    public function testComposesRangeAndSetFilters(): void
    {
        $range = ['2026-04-02', '2026-04-05'];

        self::assertSame(
            ['2026-04-02', '2026-04-03', '2026-04-05'],
            Colombia::whereBetween('full_date', $range)->orderBy('full_date')->pluck('full_date')->all()
        );
        self::assertSame(
            ['2026-07-13'],
            Colombia::whereNotBetween('full_date', $range)
                ->whereIn('full_date', ['2026-04-02', '2026-04-05', '2026-07-13'])->pluck('full_date')->all()
        );
        self::assertSame(
            ['2026-04-02'],
            Colombia::whereIn('holiday_reason', ['Jueves Santo'])->where('year', 2026)->pluck('full_date')->all()
        );
    }

    /**
     * Verifica los filtros de fecha y los metadatos de un año bisiesto.
     */
    public function testQueriesDatePartsAndReturnsPublicColumns(): void
    {
        $date = '2024-12-08';
        $row = Colombia::whereDate('full_date', $date)->first();

        $expected = [
            'day'            => 8,
            'month'          => 12,
            'year'           => 2024,
            'day_name'       => 'Sunday',
            'month_name'     => 'December',
            'full_date'      => $date,
            'iso_day'        => 7,
            'iso_week'       => 49,
            'day_of_year'    => 343,
            'holiday_reason' => 'Inmaculada Concepción',
        ];
        if (PHP_VERSION_ID < 80100) {
            // PDO SQLite puede devolver las columnas enteras como cadenas antes de PHP 8.1.
            self::assertEquals($expected, (array) $row);
        } else {
            self::assertSame($expected, (array) $row);
        }

        self::assertSame($date, Colombia::whereYear('full_date', 2024)->where('month', 12)->where('day', 8)->first()->full_date);
        self::assertSame($date, Colombia::whereMonth('full_date', 12)->where('year', 2024)->where('day', 8)->first()->full_date);
        self::assertSame($date, Colombia::whereDay('full_date', 8)->where('year', 2024)->where('month', 12)->first()->full_date);
    }

    /**
     * Mantiene los formatos válidos de Carbon y la zona horaria de la aplicación.
     */
    public function testParsesDatesInTheApplicationTimezone(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-07-14T02:00:00+00:00'));

        self::assertTrue(Colombia::isHoliday('today'));
        self::assertTrue(Colombia::isHoliday('2026-07-13 10:00:00'));
    }

    /**
     * Rechaza una fecha imposible en lugar de normalizarla a otro día festivo.
     */
    public function testRejectsInvalidDates(): void
    {
        $this->expectException(InvalidFormatException::class);

        Colombia::isHoliday('2026-04-31');
    }

    /**
     * Rechaza una fecha vacía sin sustituirla por la fecha actual.
     */
    public function testRejectsBlankDates(): void
    {
        $this->expectException(InvalidFormatException::class);

        Colombia::getDescriptionIfHoliday(' ');
    }

    /**
     * Comprueba que consultar el calendario no modifica la conexión de Laravel ni el archivo.
     */
    public function testUsesAnIsolatedReadOnlyConnection(): void
    {
        $applicationConnection = DB::connection();
        self::assertNotSame($applicationConnection, Colombia::query()->getConnection());
        self::assertTrue(Colombia::isHoliday('2026-01-01'));
        self::assertSame(':memory:', DB::connection()->getDatabaseName());
        self::assertSame(':memory:', Config::get('database.connections.db_colombiancalendar.database'));

        $connection = Colombia::query()->getConnection();
        $connection->beginTransaction();

        try {
            $this->expectException(QueryException::class);
            $this->expectExceptionMessage('readonly');
            Colombia::where('full_date', '2026-01-01')->update(['holiday_reason' => 'Otro motivo']);
        } finally {
            $connection->rollBack();
        }
    }
}
