---
title: Métodos de Clase
editLink: true
outline: deep
---

## Métodos Estáticos Únicos

Este paquete te ofrece dos métodos simples para determinar los datos relevantes sobre la validación de días festivos en Colombia.

### Validar si una fecha es festiva

Con el método `isHoliday` y pasando una fecha en el formato indicado, puedes determinar si la fecha es o no festiva en el calendario colombiano.

```php
use Rmunate\Calendar\Colombia;

$isHoliday = Colombia::isHoliday('2024-01-01');
// true

$isHoliday = Colombia::isHoliday('2024-03-01');
// false
```

### Conocer el motivo de un día festivo

Usando el método `getDescriptionIfHoliday` y pasando una fecha en el formato indicado, puedes obtener el motivo por el cual un día es festivo, siempre y cuando lo sea. Si no es festivo, se retornará un valor nulo.

```php
use Rmunate\Calendar\Colombia;

$description = Colombia::getDescriptionIfHoliday('2024-01-01');
// 'Año nuevo'

$description = Colombia::getDescriptionIfHoliday('2024-03-01');
// null
```

### Obtener todos los días festivos disponibles

Si deseas obtener todos los días festivos disponibles en el paquete, tu mejor opción es el método `all()`. Esto retornará una colección de Laravel (`\Illuminate\Support\Collection`) con toda la data lista para que apliques los filtros o tratamientos que necesites.

```php
use Rmunate\Calendar\Colombia;

$all_holidays = Colombia::all();
```

## Ejecutar consultas específicas

Es posible que necesites realizar consultas específicas. Con este paquete puedes aplicar cualquier condición que te sea conveniente a los valores disponibles.

Columnas de la tabla:
- **day**: Número del día (numérico)
- **month**: Número del mes (numérico)
- **year**: Número del año (numérico)
- **day_name**: Nombre del día en inglés (texto)
- **month_name**: Nombre del mes en inglés (texto)
- **full_date**: Fecha completa en formato YYYY-MM-DD
- **iso_day**: Número ISO del día (numérico)
- **iso_week**: Número ISO de la semana (numérico)
- **day_of_year**: Día dentro del año (365 días) (numérico)
- **holiday_reason**: Motivo de que sea festivo (texto)

Con esto en mente, puedes usar cualquier consulta con QueryBuilder.

```php
use Rmunate\Calendar\Colombia;

$data = Colombia::where('day', 1)->where('month', 1)->get();
$data = Colombia::where('year', 2024)->where('month', 7)->get();
$data = Colombia::where('full_date', '2024-01-01')->first();
$data = Colombia::where('day_of_year', '>=', 180)->where('year', 2024)->get();

$data = Colombia::where('day_name', '!=', 'Sunday')->where('year', 2024)->get();
$data = Colombia::whereNot('day_name', 'Sunday')->where('year', 2024)->get();

$data = Colombia::whereIn('year', [2024, 2025])->whereIn('month', [1, 2, 3, 4, 5, 6])->get();
$data = Colombia::whereIn('holiday_reason', ['Jueves Santo', 'Viernes Santo'])->where('year', 2024)->get();
$data = Colombia::whereNotIn('holiday_reason', ['Jueves Santo', 'Viernes Santo'])->where('year', 2024)->get();

$data = Colombia::whereBetween('full_date', ['2024-01-01', '2024-03-01'])->get();
$data = Colombia::whereNotBetween('full_date', ['2024-01-01', '2024-03-01'])->get();

$data = Colombia::whereDate('full_date', '2024-01-01')->get();
$data = Colombia::whereMonth('full_date', '01')->get();
$data = Colombia::whereDay('full_date', '01')->get();
$data = Colombia::whereYear('full_date', 2024)->get();
```

En resumen, tienes tantas combinaciones como necesites. Además, el método `Colombia::query()` también está disponible en el paquete y retorna una instancia válida de `\Illuminate\Database\Query\Builder`, lo que te permite usar métodos diferentes de Query Builder que no estén listados en los ejemplos anteriores.

```php
use Rmunate\Calendar\Colombia;

$data = Colombia::query()->where(function (Builder $query) {
            $query->where('month', 3)->orWhere('month', 7);
        });
```

Con estos métodos, puedes manejar y consultar los días festivos de Colombia de manera eficiente y flexible. ¡Aprovecha todas las posibilidades que este paquete te ofrece!