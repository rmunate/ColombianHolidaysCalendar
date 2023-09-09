# Calendario de Festivos Colombia

Este paquete cuenta con la capacidad de permitirte trabajar con las fechas festivas de Colombia. Con el uso de dos clases, podrás lograr resultados increíbles en tus proyectos. Seguramente te será de utilidad para proyectos donde requieras validar si una fecha es festiva, si un año es bisiesto, cuántos festivos existen entre un rango de fechas y mucho más. Este paquete cuenta actualmente con soporte desde el año 2000 hasta el 2034. Cada año iremos agregando más años, nuestro compromiso es que siempre cuentes con la información de al menos 10 años a futuro.

⚙️ Esta librería es compatible con Laravel 9.0 y versiones posteriores ⚙️

[![Laravel 9.0+](https://img.shields.io/badge/Laravel-9.0%2B-orange.svg)](https://laravel.com)
[![Laravel 10.0+](https://img.shields.io/badge/Laravel-10.0%2B-orange.svg)](https://laravel.com)

📖 [**DOCUMENTACIÓN EN INGLES**](README_ENGLISH.md) 📖

## Tabla de Contenido
- [Introducción](#introducción)
- [Instalación](#instalación)
- [Uso de la Clase **Calendar**](#uso-de-la-clase-calendar)
  - [Método `today()`](#método-today)
  - [Método `date()`](#método-date)
  - [Método `timeZone()`](#método-timezone)
  - [Métodos de Asignación Encadenados](#métodos-de-asignación-encadenados)
  - [Métodos de Manipulación de Fechas](#métodos-de-manipulación-de-fechas)
  - [Métodos Directos](#métodos-directos)
  - [Métodos para Calcular Diferencias de Fechas](#métodos-para-calcular-diferencias-de-fechas)
- [Uso de la Clase **Holidays**](#uso-de-la-clase-holidays)
  - [Métodos Disponibles para Trabajar con Festivos](#métodos-disponibles-para-trabajar-con-festivos)
- [Creador](#creador)
- [Licencia](#licencia)

## Introducción
Este paquete cuenta con dos clases de acceso a los métodos. La clase `Calendar` permitirá que trabajes con las fechas ejecutando tareas de trabajo de rangos, aumentos, disminuciones y muchas otras tareas útiles. La clase `Holidays` te permitirá trabajar de manera exclusiva con las fechas festivas. El paquete actualmente solo cuenta con soporte para Colombia.

## Instalación
Para instalar la dependencia a través de **Composer**, ejecuta el siguiente comando:

```shell
composer require rmunate/calendario-colombia
```

## Uso de la Clase **Calendar**
Para poder emplear los diferentes métodos disponibles en la clase, podrás inicializar su uso de tres formas diferentes:

### Método `today()`
Este método inicializará la clase con la fecha actual de acuerdo a la zona horaria configurada en Laravel o de acuerdo a la zona horaria suministrada como argumento.

```php
use Rmunate\Calendario\Calendar;

// Inicializar la clase con la fecha actual de acuerdo a la zona horaria cargada en Laravel
$calendar = Calendar::today();

// Inicializar la clase con la fecha actual de la zona horaria suministrada.
$calendar = Calendar::today('America/Bogota');
```

### Método `date()`
Este método permite enviar una fecha específica para inicializar la clase.

```php
use Rmunate\Calendario\Calendar;

// Con una fecha específica
$calendar = Calendar::date('2023-09-01');

// Con una fecha específica y una zona horaria específica
$calendar = Calendar::date('2023-09-01', 'America/Bogota');
```

### Método `timeZone()`
Este método inicializa la clase con una zona horaria específica.

```php
use Rmunate\Calendario\Calendar;

$calendar = Calendar::timeZone('America/Bogota');
```

### Métodos de Asignación Encadenados
A continuación, listamos los métodos disponibles dentro de la clase que podrás usar para concatenarlos entre sí y configurar la inicialización de la clase de una manera más clara y estructurada.

#### Método `setTimezone()`
Asignar una zona horaria después de los métodos inicializadores `today()` o `date()`.

```php
use Rmunate\Calendario\Calendar;

$calendar = Calendar::date('2023-09-10')->setTimezone('America/Bogota');
$calendar = Calendar::today()->setTimezone('America/Bogota');
```

#### Método `setDate()`
Asignar una fecha en caso de que el método inicializador sea `timeZone()`.

```php
use Rmunate\Calendario\Calendar;

$calendar = Calendar::timeZone('America/Bogota')->setDate('2023-09-10');
```

### Métodos de Manipulación de Fechas
A continuación, listamos los métodos que podrás emplear anidados a cualquiera de los métodos de inicialización previamente mencionados. Para efectos de este manual, usaremos el método de inicialización `date()`, pero puedes usar cualquiera de los métodos mencionados anteriormente.

```php
use Rmunate\Calendario\Calendar;

// Saber si la fecha es un día festivo en Colombia.
$isHoliday = Calendar::date('2023-09-10')->isHoliday();

// Obtener el motivo del día festivo o nulo en caso de que no sea festivo.
$descriptionIfHoliday = Calendar::date('2023-09-10')->getDescriptionIfHoliday();

// Validar si la fecha corresponde a un día específico de la semana. Retorna verdadero o falso.
$isMonday = Calendar::date('2023-09-10')->isMonday();
$isTuesday = Calendar::date('2023-09-10')->isTuesday();
$isWednesday = Calendar::date('2023-09-10')->isWednesday();
$isThursday = Calendar::date('2023-09-10')->isThursday();
$isFriday = Calendar::date('2023-09-10')->isFriday();
$isSaturday = Calendar::date('2023-09-10')->isSaturday();
$isSunday = Calendar::date('2023-09-10')->isSunday();

// Obtener valores específicos de la fecha.
// Obtener el día del mes en formato de cadena o entero.
$dayNumberString = Calendar::date('2023-09-01')->getDayNumberString(); //"01"
$dayNumberInteger = Calendar::date('2023-09-01')->getDayNumberInteger(); //1

$monthNumberString = Calendar::date('2023-09-01')->getMonthNumberString(); //"09"
$monthNumberInteger = Calendar::date('2023-09-01')->getMonthNumberInteger(); //9

$year = Calendar::date('2023-09-01')->getYear(); //2023

// Obtener el ISO del día.
$isoDate = Calendar::date('2023-09-10')->getDayNumberISO(); //7 (1 para lunes - 7 para domingo)
$isoWeek = Calendar::date('2023-09-10')->getWeekISO(); //33

// Obtener el número del día en el año.
$numberDayInYear = Calendar::date('2023-09-10')->getDayYear(); //253

// Obtener el nombre del día en español o inglés.
$nameEnglish = Calendar::date('2023-09-10')->getNameDayEnglish(): //"Sunday"
$nameSpanish = Calendar::date('2023-09-10')->getNameDaySpanish(); //"Domingo"

// Obtener el nombre del mes en español o inglés.
$nameEnglish = Calendar::date('2023-09-10')->getNameMonthEnglish(): //"September"
$nameSpanish = Calendar::date('2023-09-10')->getNameDaySpanish(); //"Septiembre"

// Obtener la fecha como un arreglo.
$dateInArray = Calendar::date('2023-09-10')->toArray();
// array:3 [▼ 
//   "day" => "10"
//   "month" => "09"
//   "year" => "2023"
// ]

// Obtener la fecha como un objeto.
$dateInObject = Calendar::date('2023-09-10')->toObject();
// {#403 ▼ 
//   +"day": "10"
//   +"month": "09"
//   +"year": "2023"
// }

// Crear un arreglo de días hacia adelante de acuerdo a la cantidad suministrada.
$fixUp = Calendar::date('2023-09-10')->fixUp(3);
// array:4 [▼ 
//   0 => "2023-09-10"
//   1 => "2023-09-11"
//   2 => "2023-09-12"
//   3 => "2023-09-13"
// ]

// Crear un arreglo de días hacia atrás de acuerdo a la cantidad suministrada.
$fixDown = Calendar::date('2023-09-10')->fixDown(3);
// array:4 [▼
//   0 => "2023-09-10"
//   1 => "2023-09-09"
//   2 => "2023-09-08"
//   3 => "2023-09-07"
// ]

// Agregar o restar días y obtener la fecha final.
$addDays = Calendar::date('2023-09-10')->addDays(3); //"2023-09-13"
$reduceDays = Calendar::date('2023-09-10')->subDays(3); //"2023-09-07" 

// Agregar o restar meses.
$addMonths = Calendar::date('2023-09-10')->addMonths(3); //"2023-12-10"
$subMonths = Calendar::date('2023-09-10')->subMonths(3); //"2023-06-10"

// Agregar o restar años.
$addYears = Calendar::date('2023-09-10')->addYears(3); //"2026-09-10"
$subYears = Calendar::date('2023-09-10')->subYears(3); //"2020-09-10"

// Validar si la fecha es pasada o futura. Retorna verdadero o falso.
$isPast = Calendar::date('2023-09-10')->isPast();
$isFuture = Calendar::date('2023-09-10')->isFuture();
```

### Métodos Directos
A continuación, se listan los métodos que no requieren una inicialización a través de una fecha o una zona horaria.

```php
use Rmunate\Calendario\Calendar;

// Conocer la cantidad de días de un mes en específico.
$numberOfDaysMonth = Calendar::getDaysInMonth(2023, 9); //30

// Primer día del mes.
$firstDayOfMonth = Calendar::getFirstDayOfMonth(2023, 9); //"2023-09-01"

// Último día del mes.
$lastDayOfMonth = Calendar::getLastDayOfMonth(2023, 9); //"2023-09-30"

// Validar si es un año bisiesto - Retorna verdadero o falso.
$isLeapYear = Calendar::isLeapYear(2023);
```

### Métodos para Calcular Diferencias entre Fechas
```php
use Rmunate\Calendario\Calendar;

// Diferencia entre dos fechas contemplando horas, minutos y segundos.
$diff = Calendar::diff(['2023-09-01 00:01:00', '2023-09-09 12:00:00'])->getDatetimeIntervals();
// {#404 ▼
//   +"years": 0
//   +"months": 0
//   +"days": 8
//   +"hours": 11
//   +"minutes": 59
//   +"seconds": 0
// }

// Diferencia entre dos fechas sin contemplar horas, minutos y segundos.
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->getDateIntervals();
// {#404 ▼
//   +"years": 0
//   +"months": 0
//   +"days": 8
// }

// Diferencia en Lenguaje Humano.
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans(); //"1 Semana Antes"
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans('es'); //"1 Semana Antes"
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans('en'); //"1 Week Before"
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans('fr'); //"1 Semaine Avant"
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans(...); //"...."

// Diferencia específicamente en días.
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->inDays(); //8

// Diferencia excluyendo días específicos. Tener presente que este método cuenta día a día, a excepción del método inDays() que no contempla el día inicial.
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->excludingDays(); //9 
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->excludingDays('Sabado', 'Domingo'); //6
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->excludingDays('Saturday', 'Sunday'); //6

// Diferencia entre dos fechas excluyendo festivos.
$diff = Calendar::diff(['2023-08-01', '2023-09-09'])->excludingHolidays(); //33

// Diferencia entre dos fechas excluyendo días específicos más días festivos.
$diff = Calendar::diff(['2023-08-01', '2023-09-09'])->excludingHolidaysAndThisDays('Viernes', 'Domingo'); //27
```

## Uso de la Clase **Holidays**
Con esta clase, podrás realizar diversas operaciones específicamente con las fechas festivas del país. Podrás inicializar la clase a través de la Clase `Calendar` o directamente usando `Holidays`.

Usando Calendar:
```php
use Rmunate\Calendario\Calendar;

$holidays = Calendar::onlyHolidays();
```

Usando Holidays:
```php
use Rmunate\Calendario\Holidays;

$holidays = Holidays::colombia();
```

### Métodos Disponibles para Trabajar con Días Festivos
Podrás usar cualquiera de los siguientes métodos concatenándolos a las dos posibles maneras de inicializar la consulta de fechas festivas. Para efectos del manual, usaremos la clase `Holidays`.

```php
use Rmunate\Calendario\Holidays;

// Consultar los años actualmente disponibles para trabajar los festivos.
$holidays = Holidays::colombia()->yearsAvailable();
// array:35 [▼
//   0 => 2000
//   ...
//   34 => 2034
// ]

// Consulta del 100% de los días festivos disponibles en una colección de Laravel Framework.
$holidays = Holidays::colombia()->all();

// Retorna los festivos específicos de un año en una colección de Laravel Framework.
$holidays = Holidays::colombia()->year(2023)->get();

// Consultar los festivos de uno o varios años.
$holidays = Holidays::colombia()->years(2022, 2023)->get();

// Consultar a su vez los festivos de un mes o varios meses en específico.
$holidays = Holidays::colombia()->year(2023)->month(8)->get();
$holidays = Holidays::colombia()->years(2022, 2023)->month(8)->get();

$holidays = Holidays::colombia()->year(2023)->months(8, 9)->get();
$holidays = Holidays::colombia()->years(2022, 2023)->months(8, 9)->get();

// Consultar los festivos entre dos fechas.
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->get();

// Consultar los festivos sin incluir ciertos días.
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->notInclude('Domingo')->get();
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->notInclude('Sunday')->get();
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->notInclude('Viernes', 'Domingo')->get();

$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->except('Domingo')->get();
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->except('Sunday')->get();
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->except('Viernes', 'Domingo')->get();

// Consultar los festivos de los días de la semana suministrados.
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->include('Lunes')->get()
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->include('Sunday')->get()
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->include('Viernes', 'Domingo')->get()

$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->only('Lunes')->get()
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->only('Sunday')->get()
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->only('Viernes', 'Domingo')->get()
```

### Métodos Finales Diferentes a `->get()`
Además del método get, tendrás la posibilidad de emplear los siguientes métodos finales.

```php
$holidays = Holidays::colombia()->year(2023)->get(); // Retorna una colección de Laravel
$holidays = Holidays::colombia()->year(2023)->toCollect(); // Retorna una colección de Laravel
$holidays = Holidays::colombia()->year(2023)->toArray(); // Retorna la respuesta como un array
$holidays = Holidays::colombia()->year(2023)->toJson(); // Retorna la respuesta como un JSON
$holidays = Holidays::colombia()->year(2023)->count(); // Retorna la cuenta de días festivos
$holidays = Holidays::colombia()->year(2023)->first(); // Retorna el primer día festivo
$holidays = Holidays::colombia()->year(2023)->last(); // Retorna el último día festivo
$holidays = Holidays::colombia()->year(2023)->pluck('holiday_reason', 'full_date'); // Retorna un arreglo indexado de fecha y motivo del festivo
$holidays = Holidays::colombia()->year(2023)->groupBy('month'); // Retorna la data agrupada según sea solicitado.
```

## Creador
- 🇨🇴 Raúl Mauricio Uñate Castro
- Email: raulmauriciounate@gmail.com

## Licencia
Este proyecto está bajo la [Licencia MIT](https://choosealicense.com/licenses/mit/).

🌟 ¡Apoya mis proyectos! 🚀

Haz las contribuciones que consideres adecuadas; el código es completamente tuyo. Juntos, podemos hacer cosas increíbles y mejorar el mundo del desarrollo. Tu apoyo es invaluable. ✨

Si tienes ideas, sugerencias o simplemente quieres colaborar, estamos abiertos a todo. Únete a nuestra comunidad y sé parte de nuestro viaje hacia el éxito. 🌐👩‍💻👨‍💻