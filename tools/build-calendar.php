<?php

declare(strict_types=1);

/**
 * Reconstruye y verifica el calendario SQLite distribuido con el paquete.
 */

const FIRST_YEAR = 2000;
const LAST_YEAR = 2100;

/**
 * Devuelve el lunes de la fecha o el lunes inmediatamente posterior.
 */
function observeOnMonday(DateTimeImmutable $date): DateTimeImmutable
{
    return $date->format('N') === '1' ? $date : $date->modify('next monday');
}

/**
 * Calcula las fechas de descanso conforme a las leyes 51 de 1983 y 2578 de 2026.
 *
 * @return array<string, list<string>> Motivos nacionales agrupados por fecha.
 */
function nationalHolidays(int $year, DateTimeZone $timezone): array
{
    $holidays = [];
    foreach ([
        '01-01' => 'Año Nuevo',
        '05-01' => 'Día del trabajo',
        '07-20' => 'Día de la independencia',
        '08-07' => 'Batalla de Boyacá',
        '12-08' => 'Inmaculada Concepción',
        '12-25' => 'Navidad',
    ] as $day => $reason) {
        $holidays[$year.'-'.$day][] = $reason;
    }

    $movable = [
        '01-06' => 'Festivo por el día de los Reyes Magos',
        '03-19' => 'Festivo por el día de San José',
        '06-29' => 'Festivo por el día de San Pedro y San Pablo',
        '08-15' => 'Festivo por la Asunción de la Virgen',
        '10-12' => 'Festivo por el Día de la Raza',
        '11-01' => 'Festivo por el día de todos los Santos',
        '11-11' => 'Festivo por la Independencia de Cartagena',
    ];

    if ($year >= 2026) {
        $movable['07-09'] = 'Día de Nuestra Señora del Rosario de Chiquinquirá';
    }

    foreach ($movable as $day => $reason) {
        $date = observeOnMonday(new DateTimeImmutable($year.'-'.$day, $timezone));
        $holidays[$date->format('Y-m-d')][] = $reason;
    }

    $easter = (new DateTimeImmutable($year.'-03-21', $timezone))
        ->modify('+'.easter_days($year, CAL_EASTER_ALWAYS_GREGORIAN).' days');

    foreach ([
        -3 => 'Jueves Santo',
        -2 => 'Viernes Santo',
        39 => 'Festivo por el Día de la Ascensión',
        60 => 'Festivo por el día de Corpus Christi',
        68 => 'Festivo por el día del Sagrado Corazón de Jesús',
    ] as $offset => $reason) {
        $date = $easter->modify(sprintf('%+d days', $offset));
        if ($offset > 0) {
            $date = observeOnMonday($date);
        }
        $holidays[$date->format('Y-m-d')][] = $reason;
    }

    return $holidays;
}

/**
 * Genera un archivo SQLite nuevo sin escribir sobre la base distribuida.
 */
function buildDatabase(string $path): void
{
    $database = new PDO('sqlite:'.$path, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $database->beginTransaction();
    $database->exec(<<<'SQL'
        CREATE TABLE holidays (
            id INTEGER PRIMARY KEY,
            country TEXT NOT NULL DEFAULT 'Colombia',
            year INTEGER NOT NULL,
            month INTEGER NOT NULL,
            day INTEGER NOT NULL,
            full_date TEXT NOT NULL UNIQUE,
            day_of_year INTEGER NOT NULL,
            iso_week INTEGER NOT NULL,
            iso_day INTEGER NOT NULL,
            holiday_reason TEXT NOT NULL,
            day_name TEXT NOT NULL,
            month_name TEXT NOT NULL
        )
        SQL
    );
    $insert = $database->prepare(<<<'SQL'
        INSERT INTO holidays (year, month, day, full_date, day_of_year, iso_week, iso_day, holiday_reason, day_name, month_name)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        SQL
    );

    $timezone = new DateTimeZone('UTC');
    $interval = new DateInterval('P1D');
    for ($year = FIRST_YEAR; $year <= LAST_YEAR; $year++) {
        $national = nationalHolidays($year, $timezone);
        $start = new DateTimeImmutable($year.'-01-01', $timezone);
        $period = new DatePeriod($start, $interval, $start->modify('+1 year'));

        foreach ($period as $date) {
            $key = $date->format('Y-m-d');
            $weekday = $date->format('N');
            if (!isset($national[$key]) && $weekday !== '7') {
                continue;
            }

            $insert->execute([
                $year,
                $date->format('n'),
                $date->format('j'),
                $key,
                (int) $date->format('z') + 1,
                $date->format('W'),
                $weekday,
                isset($national[$key]) ? implode(' / ', $national[$key]) : 'Día Domingo Festivo',
                $date->format('l'),
                $date->format('F'),
            ]);
        }
    }

    $database->commit();
}

/**
 * Comprueba la integridad y lee el esquema y los datos para compararlos sin depender de bytes de SQLite.
 *
 * @return array{string, list<array<string, mixed>>}
 */
function databaseContents(string $path): array
{
    if (!is_file($path)) {
        throw new RuntimeException('No existe el calendario SQLite. Ejecuta composer calendar:build.');
    }

    $database = new PDO('sqlite:'.$path, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    if ($database->query('PRAGMA integrity_check')->fetchColumn() !== 'ok') {
        throw new RuntimeException('El calendario SQLite no superó la comprobación de integridad.');
    }

    $schema = $database->query("SELECT sql FROM sqlite_master WHERE name = 'holidays'")->fetchColumn();
    if (!is_string($schema)) {
        throw new RuntimeException('No existe la tabla holidays en el calendario SQLite.');
    }

    return [
        str_replace("\r\n", "\n", $schema),
        $database->query('SELECT * FROM holidays ORDER BY id')->fetchAll(PDO::FETCH_ASSOC),
    ];
}

if ($argc > 2 || ($argc === 2 && $argv[1] !== '--check')) {
    fwrite(STDERR, "Uso: php tools/build-calendar.php [--check]\n");
    exit(2);
}

$destination = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'Database', 'SQLite', 'Holidays.db']);
$temporary = tempnam(dirname($destination), 'holidays-');
if ($temporary === false) {
    throw new RuntimeException('No se pudo crear el archivo temporal de SQLite.');
}

try {
    buildDatabase($temporary);

    if ($argc === 2) {
        if (databaseContents($temporary) !== databaseContents($destination)) {
            throw new RuntimeException('El calendario SQLite no está actualizado. Ejecuta composer calendar:build.');
        }
        fwrite(STDOUT, "Calendario SQLite íntegro y actualizado.\n");
    } else {
        if (!rename($temporary, $destination)) {
            throw new RuntimeException('No se pudo reemplazar el calendario SQLite.');
        }
        fwrite(STDOUT, "Calendario SQLite actualizado.\n");
    }
} finally {
    if (is_file($temporary)) {
        unlink($temporary);
    }
}
