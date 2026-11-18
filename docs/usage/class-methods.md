---
title: Consultas
---

# Consultas

## Consultar una fecha

```php
use Rmunate\Calendar\Colombia;

Colombia::isHoliday('2026-07-13');             // true
Colombia::getDescriptionIfHoliday('2026-07-13');
// 'Día de Nuestra Señora del Rosario de Chiquinquirá'

Colombia::isHoliday('2026-07-09');             // false: el descanso se trasladó
Colombia::getDescriptionIfHoliday('2026-07-09'); // null

Colombia::getDescriptionIfHoliday('2026-07-12');
// 'Día Domingo Festivo'
```

Se recomienda pasar fechas en formato `Y-m-d` para que la consulta no dependa de la hora de ejecución. También se aceptan fechas válidas interpretadas por Carbon: se usa `config('app.timezone')` cuando la entrada no incluye una zona horaria. Las fechas vacías o inválidas generan `Carbon\Exceptions\InvalidFormatException`.

`false` o `null` significan que no hay una fila para esa fecha. Esto incluye los días ordinarios **y** las fechas fuera de la [cobertura](../getting-started/introduction.md#cobertura-del-calendario).

## Listar y filtrar

`Colombia::all()` devuelve una `Illuminate\Support\Collection` de registros en orden cronológico. `Colombia::query()` devuelve un `Illuminate\Database\Query\Builder` nuevo sobre la base de solo lectura.

```php
// Solo festivos nacionales de 2026, incluidos los que caen en domingo.
$festivos = Colombia::where('year', 2026)
    ->whereNot('holiday_reason', 'Día Domingo Festivo')
    ->orderBy('full_date')
    ->get();

// Incluye los extremos del rango y los domingos.
$semanaSanta = Colombia::whereBetween('full_date', ['2026-04-02', '2026-04-05'])
    ->orderBy('full_date')
    ->pluck('full_date');

// Encuentra un motivo aunque coincida con otro.
$sagradoCorazon = Colombia::query()
    ->where('holiday_reason', 'like', '%Sagrado Corazón de Jesús%')
    ->orderBy('full_date')
    ->get();
```

| Método estático | Ejemplo | Uso |
| --- | --- | --- |
| `where`, `whereNot` | `Colombia::where('year', '>=', 2026)` | Aplica o niega una condición. |
| `whereIn`, `whereNotIn` | `Colombia::whereIn('year', [2025, 2026])` | Incluye o excluye una lista de valores. |
| `whereBetween`, `whereNotBetween` | `Colombia::whereBetween('month', [6, 8])` | Incluye o excluye un rango con sus extremos. |
| `whereDate` | `Colombia::whereDate('full_date', '2026-07-13')` | Compara una fecha. |
| `whereYear`, `whereMonth`, `whereDay` | `Colombia::whereMonth('full_date', 7)` | Compara una parte de la fecha. |

Estos métodos devuelven un Query Builder: añade `get()`, `first()`, `exists()`, `count()` o el método de consulta que necesites. Si el orden importa, usa `orderBy('full_date')`.

La consulta selecciona las columnas públicas de forma predeterminada. Para obtener un solo valor con `value()`, selecciona antes la columna, por ejemplo `->select('full_date')->value('full_date')`.

## Columnas públicas

| Columna | Tipo y contenido |
| --- | --- |
| `year`, `month`, `day` | Enteros: año, mes (1–12) y día (1–31). |
| `full_date` | Texto en formato `YYYY-MM-DD`. |
| `day_name`, `month_name` | Nombres del día de la semana y del mes en inglés. |
| `iso_day` | Día ISO de la semana: lunes = 1, domingo = 7. |
| `iso_week` | Semana ISO (1–53). |
| `day_of_year` | Día ordinal (1–365 o 1–366 en años bisiestos). |
| `holiday_reason` | Motivo en español. Si coinciden dos festivos, ambos aparecen separados por ` / `. |

Estos son los tipos de SQLite. En PHP 7.4 y 8.0, PDO puede devolver las columnas numéricas como cadenas.
