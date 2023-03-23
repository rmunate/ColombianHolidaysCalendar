<?php

namespace Rmunate\Calendario;

use DateTime;
use Rmunate\Calendario\Holidays;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CalendarioColombia
{

#--------------------------╔═════════════════════════════════╗--------------------------#
#--------------------------║      ATRIBUTOS DEL OBJETO       ║--------------------------#
#--------------------------╚═════════════════════════════════╝--------------------------#

    /* Datos Globales de la Clase */
    protected $assignedTimeZone;
    protected $yearsAvailable;
    protected $timeZone;
    /* Atributos Para Manejo de Festivos */
    private $descriptions;
    private $typeQuery;
    private $holidays;
    public  $response;
    private $query;
    /* Atributos para manejo de Fecha */
    private static $date;
    private static $diff;

#--------------------------╔═════════════════════════════════╗--------------------------#
#--------------------------║      CONSTRUCTOR DE LA CLASE    ║--------------------------#
#--------------------------╚═════════════════════════════════╝--------------------------#

    public function __construct(string $timeZone = 'America/Bogota'){
        /* ---- GESTION PARA FESTIVOS  */
        $this->timeZone = $timeZone;
        $this->assignedTimeZone = date_default_timezone_set($timeZone);
        $this->holidays = Holidays::dates();
        $this->descriptions = Holidays::descriptions();
        /* ---- GESTION POR DIAS  */
        $this->query['date'] = Self::$date ?? null;
        $this->query['diff'] = Self::$diff ?? null;
        /* ---- AÑOS DISPONIBLES  */
        $this->yearsAvailable = array_key_first($this->holidays) . " - " . array_key_last($this->holidays) . " Availables";
    }

#--------------------------╔═════════════════════════════════╗--------------------------#
#--------------------------║       SETEO ZONA HORARIA        ║--------------------------#
#--------------------------╚═════════════════════════════════╝--------------------------#

    public static function timezone(string $timeZone = 'America/Bogota'){
        return date_default_timezone_set($timeZone);
    }

#--------------------------╔═════════════════════════════════╗--------------------------#
#--------------------------║             FESTIVOS            ║--------------------------#
#--------------------------╚═════════════════════════════════╝--------------------------#

    /* Iniciar Filtrado por Festivos */
    public static function holidays(){
        return new static();
    }

    /* Creacion Coleccion de Fechas */
    public function arrayHolidays(){
        /* Dar Formato de Salida a los Festivos */
        $data = [];
        foreach ($this->holidays as $year => $arrayDates) {
            foreach ($arrayDates as $key => $date) {
                $netsData['year'] = intval(date('Y', strtotime($date)));
                $netsData['month'] = intval(date('n', strtotime($date)));
                $netsData['day'] = intval(date('j', strtotime($date)));
                $netsData['name'] = date('l', strtotime($date));
                $netsData['full_date'] = date('Y-m-d', strtotime($date));
                array_push($data, $netsData);
            }
        }
        return $data;
    }

    /* Retornar Todos los Festivos organizados por años y meses */
    public function all(){
        $this->typeQuery = 'all';
        $this->response = collect($this->arrayHolidays());
        return $this->response;
    }

    /* Filtrado Por Año */
    public function year(int $valor){
        $this->typeQuery = 'filter';
        $this->query['year'] = $valor;
        return $this;
    }

    /* Filtrado Por Años */
    public function years(array $valores){
        $this->typeQuery = 'filter';
        $this->query['years'] = $valores;
        return $this;
    }

    /* Revisar Redundancia de Consulta */
    public function yearFilterUnification(){
        /* Valores Finales de Consulta */
        $finalData = [];
        if (!empty($this->query['year'])) {
            array_push($finalData, $this->query['year']);
            unset($this->query['year']);
        }
        if (!empty($this->query['years'])) {
            foreach ($this->query['years'] as $key => $value) {
                array_push($finalData, $value);
            }
            /* Eliminacion de los Filtros por separado, unificacion de valores */
            unset($this->query['years']);
        }
        /* Guardar Valor en Objeto */
        $this->query['years'] = $finalData;
    }

    /* Filtrado por Mes */
    public function month(int $valor){
        $this->typeQuery = 'filter';
        $this->query['month'] = $valor;
        return $this;
    }

    /* Filtrado Por Meses */
    public function months(array $valores){
        $this->typeQuery = 'filter';
        $this->query['months'] = $valores;
        return $this;
    }

    /* Revisar Redundancia de Consulta */
    public function monthFilterUnification(){
        /* Valores Finales de Consulta */
        $finalData = [];
        if (!empty($this->query['month'])) {
            array_push($finalData, $this->query['month']);
            unset($this->query['month']);
        }
        if (!empty($this->query['months'])) {
            foreach ($this->query['months'] as $key => $value) {
                array_push($finalData, $value);
            }
            /* Eliminacion de los Filtros por separado, unificacion de valores */
            unset($this->query['months']);
        }
        /* Guardar Valor en Objeto */
        $this->query['months'] = $finalData;
    }

    /* Retorna un Arreglo con las fechas de dias festivos entre dos fechas. */
    public function between(array $dates){
        $this->typeQuery = 'between';
        $between['start'] = date('Y-m-d', strtotime($dates[0]));
        $between['end'] = date('Y-m-d', strtotime($dates[1]));
        $this->query['between'] = $between;
        return $this;
    }

    /* Definir Dias a no incluir */
    public function notInclude(){
        if(count(func_get_args()) > 0){
            $notInclude = [];
            foreach (func_get_args() as $key => $value) {
                $day = strtolower($value);
                if ($day == 'lunes' || $day == 'monday') {
                    array_push($notInclude, 'Monday');
                } else if ($day == 'martes' || $day == 'tuesday') {
                    array_push($notInclude, 'Tuesday');
                } else if ($day == 'miercoles' || $day == 'wednesday') {
                    array_push($notInclude, 'Wednesday');
                } else if ($day == 'jueves' || $day == 'thursday') {
                    array_push($notInclude, 'Thursday');
                } else if ($day == 'viernes' || $day == 'friday') {
                    array_push($notInclude, 'Friday');
                } else if ($day == 'sabado' || $day == 'saturday') {
                    array_push($notInclude, 'Saturday');
                } else if ($day == 'domingo' || $day == 'sunday') {
                    array_push($notInclude, 'Sunday');
                }

            }
        }
        $this->query['not_include'] = $notInclude;
        return $this;
    }

    /* Definir Dias a  incluir */
    public function include(){
        if(count(func_get_args()) > 0){
            $include = [];
            foreach (func_get_args() as $key => $value) {
                $day = strtolower($value);
                if ($day == 'lunes' || $day == 'monday') {
                    array_push($include, 'Monday');
                } else if ($day == 'martes' || $day == 'tuesday') {
                    array_push($include, 'Tuesday');
                } else if ($day == 'miercoles' || $day == 'wednesday') {
                    array_push($include, 'Wednesday');
                } else if ($day == 'jueves' || $day == 'thursday') {
                    array_push($include, 'Thursday');
                } else if ($day == 'viernes' || $day == 'friday') {
                    array_push($include, 'Friday');
                } else if ($day == 'sabado' || $day == 'saturday') {
                    array_push($include, 'Saturday');
                } else if ($day == 'domingo' || $day == 'sunday') {
                    array_push($include, 'Sunday');
                }

            }
        }
        $this->query['include'] = $include;
        return $this;
    }

    /* Retorno de Respuesta */
    public function get(string $type = null){

        if ($this->typeQuery == 'filter') {

            /* Unificacion de valores para consulta */
            $this->yearFilterUnification();
            $this->monthFilterUnification();


            /* Filtrar por Año si existe el valor */
            if ((count($this->query['months']) > 0) || (count($this->query['years']) > 0)) {
                if ((count($this->query['years']) > 0) && (count($this->query['months']) > 0)) {
                    /* Filtrar Por Años y Meses */
                    $this->response = $this->all()->whereIn('year', $this->query['years'])->whereIn('month', $this->query['months']);
                } else if ((count($this->query['years']) > 0)) {
                    /* Filtrar solo por año */
                    $this->response = $this->all()->whereIn('year', $this->query['years']);
                } else if ((count($this->query['months']) > 0)){
                    /* Filtrar solo por meses */
                    $this->response = $this->all()->whereIn('month', $this->query['months']);
                }
            } else {
                /* Retornarlo Todo */
                $this->response = $this->all();
            }

        } else if ($this->typeQuery == 'all'){

            /* Retornar el total de dias festivos */
            $this->response = collect($this->arrayHolidays());

        } else if($this->typeQuery == 'between'){

            /* Retorno de las fechas entre las establecidas por el arreglo */
            $this->response = $this->all()->whereBetween('full_date', [
                $this->query['between']['start'],$this->query['between']['end']
            ]);

        }

        /* Revisar si se define los dias a No incluir */
        if(isset($this->query['not_include'])){
            $this->response = $this->response->whereNotIn('name',$this->query['not_include']);
        }

        /* Revisar si se define los unicos dias a incluir */
        if(isset($this->query['include'])){
            $this->response = $this->response->whereIn('name',$this->query['include']);
        }

        /* Determinar el Tipo de Retorno */
        if (empty($type) || $type == 'all') {
            return $this->response;
        } else if($type == 'year'){
            return $this->response->pluck('year');
        } else if($type == 'month'){
            return $this->response->pluck('month');
        } else if($type == 'day'){
            return $this->response->pluck('day');
        } else if($type == 'full_date'){
            return $this->response->pluck('full_date');
        } else if($type == 'name'){
            return $this->response->pluck('name');
        } else {
            return collect([]);
        }

    }



#--------------------------╔═════════════════════════════════╗--------------------------#
#--------------------------║          GESTION DIA            ║--------------------------#
#--------------------------╚═════════════════════════════════╝--------------------------#

    /* Acciones Por Dias */
    public static function date(string $date){
        Self::$date = date('Y-m-d', strtotime($date));
        return new static();
    }

    /* Valida si un dia es festivo (Domingo o Feriado) */
    public function isHoliday(){
        if (!empty($this->query['date'])) {
            $statament = $this->response = $this->all()->whereIn('full_date', $this->query['date']);
            $this->response = ($statament->count() > 0) ? true : false;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna la Observacion del Motivo de Ser Festivo */
    public function description(){
        if (!empty($this->query['date'])) {
            if(isset($this->descriptions[$this->query['date']])){
                $this->response = trim($this->descriptions[$this->query['date']]);
            } else {
                $this->response = null;
            }
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Valida si es un Lunes */
    public function isMonday(){
        if (!empty($this->query['date'])) {
            $this->response = (date('N', strtotime($this->query['date'])) == 1) ? true : false;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Valida si un dia es Martes */
    public function isTuesday(){
        if (!empty($this->query['date'])) {
            $this->response = (date('N', strtotime($this->query['date'])) == 2) ? true : false;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Valida si un dia es Miercoles */
    public function isWednesday(){
        if (!empty($this->query['date'])) {
            $this->response = (date('N', strtotime($this->query['date'])) == 3) ? true : false;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Valida si un dia es Jueves */
    public function isThursday(){
        if (!empty($this->query['date'])) {
            $this->response = (date('N', strtotime($this->query['date'])) == 4) ? true : false;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Valida si un dia es Viernes */
    public function isFriday(){
        if (!empty($this->query['date'])) {
            $this->response = (date('N', strtotime($this->query['date'])) == 5) ? true : false;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Valida si un dia es Sabado */
    public function isSaturday(){
        if (!empty($this->query['date'])) {
            $this->response = (date('N', strtotime($this->query['date'])) == 6) ? true : false;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Valida si un dia es Domingo */
    public function isSunday(){
        if (!empty($this->query['date'])) {
            $this->response = (date('N', strtotime($this->query['date'])) == 7) ? true : false;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna el numero del dia en string conservando el cero al inicio */
    public function getDayString(){
        if (!empty($this->query['date'])) {
            $this->response = date('d', strtotime($this->query['date']));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna el numero del dia en formato numero. */
    public function getDayInt(){
        if (!empty($this->query['date'])) {
            $this->response = intval(date('j', strtotime($this->query['date'])));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna el numero del dia en formato ISO. */
    public function getDayNumberISO(){
        if (!empty($this->query['date'])) {
            $this->response = date('N', strtotime($this->query['date']));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Extrae el numero del año en formato entero */
    public function getDayYear(){
        if (!empty($this->query['date'])) {
            $this->response = intval(date('z', strtotime($this->query['date'])));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna el nombre del dia en Español */
    public function getDayES(){
        if (!empty($this->query['date'])) {
            $day = date('w', strtotime($this->query['date']));
            switch ($day){
                case 0:
                    $this->response = "Domingo";
                    break;
                case 1:
                    $this->response = "Lunes";
                    break;
                case 2:
                    $this->response = "Martes";
                    break;
                case 3:
                    $this->response = "Miércoles";
                    break;
                case 4:
                    $this->response = "Jueves";
                    break;
                case 5:
                    $this->response = "Viernes";
                    break;
                case 6:
                    $this->response = "Sábado";
                    break;
            }
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna el nombre del dia en Ingles */
    public function getDayEN(){
        if (!empty($this->query['date'])) {
            $this->response = date('l', strtotime($this->query['date']));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna la fecha de hoy separo el dia el mes y el año. */
    public function toArray(){
        if (!empty($this->query['date'])) {
            /* Fecha */
            $now = date('d-m-Y', strtotime($this->query['date']));
            //Extrayendo los datos por separado.
            $todayArr['day']    =   substr($now, -10, 2);
            $todayArr['month']  =   substr($now, -7, 2);
            $todayArr['year']   =   substr($now, -4, 4);
            $this->response = $todayArr;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna un Arreglo con los dias hacia adelante */
    public function fixUp(int $amount = 0){
        if (!empty($this->query['date'])) {
            $date = $this->query['date'];
            if ($amount >= 0) {
                $response = [$this->query['date']];
                for ($dayP = 1; $dayP <= $amount; $dayP++) {
                    $date = date("Y-m-d", strtotime($date . " + 1 days"));
                    array_push($response, $date);
                }
            }
            $this->response = $response;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna un Arreglo con los dias hacia atras */
    public function fixDown(int $amount = 0){
        if (!empty($this->query['date'])) {
            $date = $this->query['date'];
            if ($amount >= 0) {
                $response = [$this->query['date']];
                for ($dayP = 1; $dayP <= $amount; $dayP++) {
                    $date = date("Y-m-d", strtotime($date . " - 1 days"));
                    array_push($response, $date);
                }
            }
            $this->response = $response;
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Suma los dias a la fecha establecida */
    public function addDays(int $amount = 0){
        if (!empty($this->query['date'])) {
            $this->response = date("Y-m-d", strtotime($this->query['date'] . " + " . $amount ." days"));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Resta los dias a la fecha establecida */
    public function reduceDays(int $amount = 0){
        if (!empty($this->query['date'])) {
            $this->response = date("Y-m-d", strtotime($this->query['date'] . " - " . $amount ." days"));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Suma los meses a la fecha establecida */
    public function addMonths(int $amount = 0){
        if (!empty($this->query['date'])) {
            $this->response = date("Y-m-d", strtotime($this->query['date'] . " + " . $amount ." month"));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Resta los meses a la fecha establecida */
    public function reduceMonths(int $amount = 0){
        if (!empty($this->query['date'])) {
            $this->response = date("Y-m-d", strtotime($this->query['date'] . " - " . $amount ." month"));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Suma los años a la fecha establecida */
    public function addYears(int $amount = 0){
        if (!empty($this->query['date'])) {
            $this->response = date("Y-m-d", strtotime($this->query['date'] . " + " . $amount ." year"));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Resta los años a la fecha establecida */
    public function reduceYears(int $amount = 0){
        if (!empty($this->query['date'])) {
            $this->response = date("Y-m-d", strtotime($this->query['date'] . " - " . $amount ." year"));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Obtener el numero de la semana en el año en Formato ISO */
    public function getWeekISO(){
        if (!empty($this->query['date'])) {
            $this->response = intval(date("W", strtotime($this->query['date'])));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Permite comprobar si la fecha esta trabajando con la zona de tiempo de Colombia */
    public function getTimeZone(){
        if (!empty($this->query['date'])) {
            $this->response = date("e", strtotime($this->query['date']));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Obtener el nombre del mes en Español */
    public function getMonthES(){

        if (!empty($this->query['date'])) {
            $date = intval(date("n", strtotime($this->query['date'])));
            switch ($date){
                case 1:
                    $this->response = "Enero";
                    break;
                case 2:
                    $this->response = "Febrero";
                    break;
                case 3:
                    $this->response = "Marzo";
                    break;
                case 4:
                    $this->response = "Abril";
                    break;
                case 5:
                    $this->response = "Mayo";
                    break;
                case 6:
                    $this->response = "Junio";
                    break;
                case 7:
                    $this->response = "Julio";
                    break;
                case 8:
                    $this->response = "Agosto";
                    break;
                case 9:
                    $this->response = "Septiembre";
                    break;
                case 10:
                    $this->response = "Octubre";
                    break;
                case 11:
                    $this->response = "Noviembre";
                    break;
                case 12:
                    $this->response = "Diciembre";
                    break;
            }

        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Obtener el nombre del mes en Ingles */
    public function getMonthEN(){
        if (!empty($this->query['date'])) {
            $this->response = date("F", strtotime($this->query['date']));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Obteber el mes en string con cero al inicio. */
    public function getMonthString(){
        if (!empty($this->query['date'])) {
            $this->response = date("m", strtotime($this->query['date']));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Obteber el mes en INT */
    public function getMonthInt(){
        if (!empty($this->query['date'])) {
            $this->response = intval(date("n", strtotime($this->query['date'])));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

    /* Retorna el año en entero. */
    public function getYear(){
        if (!empty($this->query['date'])) {
            $this->response = intval(date("Y", strtotime($this->query['date'])));
        } else {
            $this->response = null;
        }
        return $this->response;
    }

#--------------------------╔═════════════════════════════════╗--------------------------#
#--------------------------║            MISELANIOS           ║--------------------------#
#--------------------------╚═════════════════════════════════╝--------------------------#

    /* Retorna los dias del mes correspondiente al mes y año. */
    public static function getDaysMonth(int $year, int $month){

        /* Si el mes es superior a 12 */
        if ($month > 12) {
            return null;
        }

        /* Mes */
        $lg = strlen($month);
        if ($lg >= 3) {
            return null;
        } elseif ($lg == 2) {
            $month = strval($month);
        } elseif ($lg == 1) {
            $month = "0" . strval($month);
        }

        /* Calculo */
        return intval(date('t',strtotime($year.'-'.$month.'-01')));

    }

    /* Diferencia en fechas. */
    public static function diff(string $date1, string $date2){
        $dates[0] = date('Y-m-d', strtotime($date1));
        $dates[1] = date('Y-m-d', strtotime($date2));
        Self::$diff = $dates;
        return new static();
    }

    /* Formato Diferencia */
    public function output(string $format = null){

        if (isset($this->query['diff'][0]) && $this->query['diff'][1]) {

            /* Validacion Diferencia */
            $datetime1 = date_create($this->query['diff'][0]);
            $datetime2 = date_create($this->query['diff'][1]);
            $contador = date_diff($datetime1, $datetime2);
            $this->response = $contador;

            $this->response = (object) [
                'interval' => (object) [
                                'years' => $this->response->y,
                                'months' => $this->response->m,
                                'days' => $this->response->d,
                                'hours' => $this->response->h,
                                'minutes' => $this->response->i,
                                'seconds' => $this->response->s
                            ],
                'total_days' => $this->response->days,
                'total_days_real' => $this->response->days + 1
            ];

            if ($format == 'interval_years') {
                $this->response = $this->response->interval->years;
            } else if ($format == 'interval_months'){
                $this->response = $this->response->interval->months;
            } else if ($format == 'interval_days'){
                $this->response = $this->response->interval->days;
            } else if ($format == 'interval_hours'){
                $this->response = $this->response->interval->hours;
            } else if ($format == 'interval_minutes'){
                $this->response = $this->response->interval->minutes;
            } else if ($format == 'interval_seconds'){
                $this->response = $this->response->interval->seconds;
            } else if ($format == 'total_days'){
                $this->response = $this->response->total_days;
            } else if ($format == 'total_days_real'){
                $this->response = $this->response->total_days_real;
            } else {
                $this->response = $this->response;
            }

            return $this->response;
        }
    }

#--------------------------╔═════════════════════════════════╗--------------------------#
#--------------------------║           MIGRACIONES           ║--------------------------#
#--------------------------╚═════════════════════════════════╝--------------------------#

    public static function schema(){
        return new static();
    }

    /* Retorna los datos para la migracion de Laravel. */
    public function create(){
        return Schema::create('colombian_calendar', function (Blueprint $table) {
            /* LLave Primaria */
            $table->id();
            /* Datos Objeto */
            $table->integer('year');
            $table->integer('month');
            $table->string('name_month');
            $table->integer('day');
            $table->string('name_day');
            $table->date('full_date');
            /* Adicionales */
            $table->integer('day_year');
            $table->integer('week_iso');
            $table->integer('day_number_iso');
            $table->integer('hollyday')->default(0);
        });
    }

    /* Retorna los datos para la migracion de Laravel. */
    public function drop(){
        return Schema::dropIfExists('colombian_calendar');
    }

    /* Retorna los datos para el Seeder de Laravel. */
    public function seeder(){

        /* Invocación Clase DataTime */
        $start = new DateTime((date('Y', strtotime($this->all()->first()['full_date'])) . "-01-01"));
        $end = new DateTime((date('Y', strtotime($this->all()->last()['full_date'])) . "-12-31"));

        for($i = $start; $i <= $end; $i->modify('+1 day')){

            $dateIteracion = $i->format("Y-m-d");

            DB::table('colombian_calendar')->insert([
                "id" => null,
                "year" => intval(date('Y', strtotime($dateIteracion))),
                "month" => intval(date('n', strtotime($dateIteracion))),
                "name_month" => intval(date('F', strtotime($dateIteracion))),
                "day" => intval(date('j', strtotime($dateIteracion))),
                "name_day" => intval(date('l', strtotime($dateIteracion))),
                "full_date" => $dateIteracion,
                "day_year" => intval(date('z', strtotime($dateIteracion))),
                "week_iso" => intval(date('W', strtotime($dateIteracion))),
                "day_number_iso" => intval(date('N', strtotime($dateIteracion))),
                "hollyday" => ($this->all()->where('full_date', $dateIteracion)->count() > 0) ? 1 : 0
            ]);

        }

    }

}
?>
