# Calendario y Festivos Colombia (LARAVEL)
> [![Raul Mauricio Uñate Castro](https://storage.googleapis.com/lola-web/storage_apls/RecursosCompartidos/LogoGithubLibrerias.png)](#)

Control fácil del calendario de Colombia, control de festivos, fechas, rangos y manejo de días.
Es una versión destinada netamente al control de las fechas de Colombia, esta clase al igual que la clase Carbon, se hereda de metodos y clases originales de PHP DateTime::class(). 
Esta es una versión totalmente libre y se busca que en comunidad se mejore y se brinde mejores métodos y opciones para los programadores que deciden usarla.

## Características
- Los años actualmente disponibles son del 2000 al 2034, estos se actualizan constantemente garantizando minimo 10 años a futuro, el año mas antiguo disponible en esta y en proximas versiones siempre será 2000.
- Manipular fechas y/o rangos de fechas con las características específicas del calendario de Colombia.
- Validar datos de fechas puntuales como festivos, domingos, nombres, datos exactos, etc.
- Conocer los días laborales de acuerdo al estándar de Colombia.
- Generar colecciones con los días festivos de un mes y/o año especifico.
- Generar Migraciones y Seeders en laravel con tan solo invocar un metodo de la clase.
- Llamado estático en cualquier lugar del sistema.
- Concatenación de métodos para fácil uso.
- Trabaja siempre sobre la hora y fecha de Colombia sin importar la configuración del servidor.
- Código libre y totalmente modificable.

# Instalación
## _Instalación a través de Composer_

```console
composer require rmunate/calendario-colombia v2.0.x-dev
```

## Metodos

|       LLAMADO METODOS CLASE       |       DESCRIPCIÓN METODO       |
| ------ | ------ |
| ``` CalendarioColombia::timezone() ``` | Setea la Zona de Tiempo De Bogota Colombia al sistema. |
| ``` CalendarioColombia::holidays() ``` | Este método retorna la clase completa, donde se puede visualisar los años con data disponible en la propiedad privada ***holidays***. |
| ``` CalendarioColombia::holidays()->all() ``` | Este método retorna la colección completa de días festivos sin agruparlos. |
| ``` CalendarioColombia::holidays()->year(2020)->get() ``` | Este método retorna la colección completa de días festivos del año ingresado en ***year*** y generando la colección con el metodo ***->get()***. |
| ``` CalendarioColombia::holidays()->year(2020)->get()->values() ``` | Este método retorna la colección completa de días festivos del año ingresado en ***year*** y generando la colección con el metodo ***->get()*** iniciando las llaves desde el 0. |
| ``` CalendarioColombia::holidays()->years([2020,2021])->get() ``` | Este método retorna la colección completa de los días festivos de los años ingresado en ***years*** y generando la colección con el metodo ***->get()***. |
| ``` CalendarioColombia::holidays()->years([2020,2021])->get()->values() ``` | Este método retorna la colección completa de los días festivos de los años ingresado en ***years*** y generando la colección con el metodo ***->get()*** iniciando las llaves desde el 0. |
| ``` CalendarioColombia::holidays()->year(2020)->month(8)->get() ``` | Este método retorna la colección completa de días festivos del año ingresado en ***year*** y del mes ingresado en ***month*** generando la colección con el metodo ***->get()***. |
| ``` CalendarioColombia::holidays()->year(2020)->month(8)->get()->values() ``` | Este método retorna la colección completa de días festivos del año ingresado en ***year*** y del mes ingresado en ***month*** generando la colección con el metodo ***->get()*** iniciando las llaves desde el 0. |
| ``` CalendarioColombia::holidays()->years([2020,2021])->months([8,9])->get() ``` | Este método retorna la colección completa de días festivos de los años ingresados en ***years*** y de los meses ingresados en ***months*** generando la colección con el metodo ***->get()***. |
| ``` CalendarioColombia::holidays()->years([2020,2021])->months([8,9])->get()->values() ``` | Este método retorna la colección completa de días festivos de los años ingresados en ***years*** y de los meses ingresados en ***months*** generando la colección con el metodo ***->get()*** iniciando las llaves desde el 0. |
| ``` CalendarioColombia::holidays()->between(['2022-08-01','2022-09-01'])->get() ``` | Retorna los días festivos entre las fechas establecidas. |
| ``` CalendarioColombia::holidays()->between(['2022-08-01','2022-09-01'])->get()->values() ``` | Retorna los días festivos entre las fechas establecidas iniciando las llaves en 0. |
| ``` CalendarioColombia::holidays()->between(['2022-08-01','2022-09-01'])->notInclude('Sabado','Domingo')->get() ``` | Retorna los días festivos entre las fechas establecidas, sin incluir los dias que esten en el metodo ***notInclude***, los dias pueden ingresarse en español (todo en minusculas sin tildes) o ingles. |
| ``` CalendarioColombia::holidays()->between(['2022-08-01','2022-09-01'])->notInclude('Sabado','Domingo')->get()->values() ``` | Retorna los días festivos entre las fechas establecidas, sin incluir los dias que esten en el metodo ***notInclude***, los dias pueden ingresarse en español (todo en minusculas sin tildes) o ingles. Reiniciando las llaves desde 0. |
| ``` CalendarioColombia::holidays()->years([2020,2021])->months([8,9])->notInclude('Sabado','Domingo')->get() ``` | El metodo ***notInclude*** tambien se puede usar con los filtros por años y/o meses, tambien se puede usar el metodo `->values()` para reiniciar las llaves desde 0. |
| ``` CalendarioColombia::holidays()->between(['2022-08-01','2022-09-01'])->include('Sabado','Domingo')->get() ``` | Retorna los días festivos entre las fechas establecidas, incluyendo solo los dias que esten en el metodo ***include***, los dias pueden ingresarse en español (todo en minusculas sin tildes) o ingles, tambien se puede usar el metodo `->values()` para reiniciar las llaves desde 0. |
| ``` CalendarioColombia::holidays()->years([2022...]).....->include('Sabado','Domingo')->get() ``` | El metodo ***include*** tambien se puede usar con los filtros por años y/o meses al igual que el notInclude, tambien se puede usar el metodo `->values()` para reiniciar las llaves desde 0. |

## METODOS PARA FECHAS

|       LLAMADO METODOS CLASE       |       DESCRIPCIÓN METODO       |
| ------ | ------ |
| ``` CalendarioColombia::now()->....() ``` | Se puede inicializar este listado de metodos con la fecha actual. |
| ``` CalendarioColombia::date('2022-03-01')->isHoliday() ``` | Retorna verdadero o falso dependiendo si es o no festivo. |
| ``` CalendarioColombia::date('2022-03-01')->description() ``` | Retorna el motivo que hace que el día sea festivo, en caso de no ser una fecha festiva, retorna `null`. |
| ``` CalendarioColombia::date('2022-03-01')->isMonday() ``` | Retorna verdadero o falso dependiendo si es o no lunes. |
| ``` CalendarioColombia::date('2022-03-01')->isTuesday() ``` | Retorna verdadero o falso dependiendo si es o no martes. |
| ``` CalendarioColombia::date('2022-03-01')->isWednesday() ``` | Retorna verdadero o falso dependiendo si es o no miercoles. |
| ``` CalendarioColombia::date('2022-03-01')->isThursday() ``` | Retorna verdadero o falso dependiendo si es o no jueves. |
| ``` CalendarioColombia::date('2022-03-01')->isFriday() ``` | Retorna verdadero o falso dependiendo si es o no viernes. |
| ``` CalendarioColombia::date('2022-03-01')->isSaturday() ``` | Retorna verdadero o falso dependiendo si es o no sabado. |
| ``` CalendarioColombia::date('2022-03-01')->isSunday() ``` | Retorna verdadero o falso dependiendo si es o no domingo. |
| ``` CalendarioColombia::date('2022-03-01')->getDayString() ``` | Retorna el numero del dia en string conservando el cero al inicio. |
| ``` CalendarioColombia::date('2022-03-01')->getDayInt() ``` | Retorna el numero del dia en formato numero. |
| ``` CalendarioColombia::date('2022-03-01')->getDayNumberISO() ``` | Retorna el numero del dia en formato ISO. |
| ``` CalendarioColombia::date('2022-03-01')->getDayYear() ``` | Extrae el numero del año en formato entero |
| ``` CalendarioColombia::date('2022-03-01')->getDayES() ``` | Retorna el nombre del dia en Español. |
| ``` CalendarioColombia::date('2022-03-01')->getDayEN() ``` | Retorna el nombre del dia en Ingles. |
| ``` CalendarioColombia::date('2022-03-01')->toArray() ``` | Retorna la fecha de hoy separo el dia el mes y el año. |
| ``` CalendarioColombia::date('2022-03-01')->fixUp(10) ``` | Retorna un Arreglo con los dias agregados en el metodo hacia adelante. |
| ``` CalendarioColombia::date('2022-03-01')->fixDown(10) ``` | Retorna un Arreglo con los dias agregados en el metodo hacia atrás. |
| ``` CalendarioColombia::date('2022-03-01')->addDays(10) ``` | Suma los dias a la fecha establecida. |
| ``` CalendarioColombia::date('2022-03-01')->reduceDays(10) ``` | Resta los dias a la fecha establecida. |
| ``` CalendarioColombia::date('2022-03-01')->addMonths(10) ``` | Suma los meses a la fecha establecida. |
| ``` CalendarioColombia::date('2022-03-01')->reduceMonths(10) ``` | Suma los meses a la fecha establecida. |
| ``` CalendarioColombia::date('2022-03-01')->addYears(10) ``` | Suma los años a la fecha establecida. |
| ``` CalendarioColombia::date('2022-03-01')->reduceYears(10) ``` | Resta los años a la fecha establecida. |
| ``` CalendarioColombia::date('2022-03-01')->getWeekISO() ``` | Obtener el numero de la semana en el año en Formato ISO. |
| ``` CalendarioColombia::date('2022-03-01')->getTimeZone() ``` | Permite comprobar si la fecha esta trabajando con la zona de tiempo de Colombia. |
| ``` CalendarioColombia::date('2022-03-01')->getMonthES() ``` | Obtener el nombre del mes en Español. |
| ``` CalendarioColombia::date('2022-03-01')->getMonthEN() ``` | Obtener el nombre del mes en Ingles. |
| ``` CalendarioColombia::date('2022-03-01')->getMonthString() ``` | Obteber el mes en string con cero al inicio. |
| ``` CalendarioColombia::date('2022-03-01')->getMonthInt() ``` | Obteber el mes en Entero. |
| ``` CalendarioColombia::date('2022-03-01')->getYear() ``` | Obteber el número del año en Entero. |

## METODOS ADICIONALES

|       LLAMADO METODOS CLASE       |       DESCRIPCIÓN METODO       |
| ------ | ------ |
| ``` CalendarioColombia::getDaysMonth(2021,12) ``` | Retorna los dias del mes correspondiente al mes y año. |
| ``` CalendarioColombia::diff('2022-01-01','2022-08-01')->interval() ``` | Retorna los intervalos de Diferencia. |
| ``` CalendarioColombia::diff('2022-01-01','2022-08-01')->output() ``` | Retorna la diferencia entre dos fechas, en un array con la información detallada |
| ``` CalendarioColombia::diff('2022-01-01','2022-08-01')->notInclude('sabado',...)->output() ``` | Retorna la diferencia entre dos fechas sin tener en cuenta el dia o los dias ingresados en el metodo `->notInclude()` los dias pueden estar en español o ingles. |
| ``` CalendarioColombia::diff('2022-01-01','2022-08-01')->notInclude('sabado',...)->notIncludeHolidays()->output() ``` | Retorna la diferencia entre dos fechas sin tener en cuenta el dia o los dias ingresados en el metodo `->notInclude()` los dias pueden estar en español o ingles y sin tener en cuenta los dias festivos. |
| ``` CalendarioColombia::diff('2022-01-01','2022-08-01')->include('sabado',...)->includeHolidays()->output() ``` | Retorna la diferencia entre dos fechas teniendo en cuenta el dia o los dias ingresados en el metodo `->include()` los dias pueden estar en español o ingles y teniendo en cuenta los dias festivos. |

Ejemplo de Uso
```php
#Emplear este metodo para guardar datos en bases de datos, evitar usarlo en Bucles.
CalendarioColombia::diff('2023-02-01','2023-03-31')->output();
// array:5 [▼ // app/Http/Controllers/LandingController.php:14
//   "days" => array:7 [▼
//     "monday" => array:2 [▶]
//     "tuesday" => array:2 [▶]
//     "wednesday" => array:2 [▶]
//     "thursday" => array:2 [▶]
//     "friday" => array:2 [▶]
//     "saturday" => array:2 [▶]
//     "sunday" => array:2 [▶]
//   ]
//   "holidays" => array:2 [▼
//     "count" => 9
//     "dates" => array:9 [▶]
//   ]
//   "calendar_days" => 59
//   "working_days" => 50
//   "unconditionally_intervals" => array:3 [▼
//     "years" => 0
//     "months" => 1
//     "days" => 31
//   ]
// ]
```

## METODOS MIGRACIONES LARAVEL (NO USAR EN CONTROLADORES)

|       LLAMADO METODOS CLASE       |       DESCRIPCIÓN METODO       |
| ------ | ------ |
| ``` CalendarioColombia::schema()->create(); ``` | Crea la tabla colombian_calendar, donde se alojará la informacion del calendario de Colombia. |
| ``` CalendarioColombia::schema()->drop(); ``` | Elimina la tabla colombian_calendar, donde se alojará la informacion del calendario de Colombia. |
| ``` CalendarioColombia::schema()->seeder(); ``` | Llena la tabla colombian_calendar, con todo el calendario de colombia entre las fechas disponibles en la clase ***Este Seeder puede tomar bastante tiempo, por lo cual es aconsejable esperar y no parar el proceso de migraciones con seeder hasta que termine. ***. |

## Migraciones Y Seeders.
Esta funcionalidad permite que la librería se encargue de cargar los datos del Calendario a una tabla de la base de datos, al ser diversos años los que se deben cargar, el procesado de los Seeder puede tomar un tiempo considerable, úselo si lo requiere teniendo en cuenta que al correr el comando `php artisan migrate` se notara demoras en el proceso.

Código Migración Laravel
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Rmunate\Calendario\CalendarioColombia;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /*-----------------------------------*/
    public function up(){
        CalendarioColombia::schema()->create();
    }

    /*-----------------------------------*/
    public function down(){
        CalendarioColombia::schema()->drop();
    }
};
```

Codigo Seeder Laravel
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Rmunate\Calendario\CalendarioColombia;

class ColombianCalendarSeeder extends Seeder
{
    public function run(){
        CalendarioColombia::schema()->seeder();
    }
}
```


## Mantenedores
- Ingeniero, Raúl Mauricio Uñate Castro (raulmauriciounate@gmail.com)

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)