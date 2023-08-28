<?php

namespace Rmunate\Calendario\Traits;

trait Translator
{
    /**
     * Translate a day name from Spanish to English.
     *
     * @param string $value The day name in Spanish.
     * @return string|null The translated day name in English, or null if not found.
     */
    private function spanishToEnglishDay($value)
    {
        // Convert the value to lowercase to ensure case-insensitive matching.
        $value = mb_strtolower($value, 'UTF-8');

        // Map Spanish day names to their English equivalents.
        $days = [
            'lunes' => 'Monday',
            'martes' => 'Tuesday',
            'miércoles' => 'Wednesday',
            'miercoles' => 'Wednesday',
            'jueves' => 'Thursday',
            'viernes' => 'Friday',
            'sábado' => 'Saturday',
            'sabado' => 'Saturday',
            'domingo' => 'Sunday'
        ];

        // Return the translated day name or null if not found.
        return (isset($days[$value])) ? $days[$value] : null;
    }

    /**
     * Translate a day name from English to Spanish.
     *
     * @param string $value The day name in English.
     * @return string|null The translated day name in Spanish, or null if not found.
     */
    private function englishToSpanishDay($value)
    {
        // Convert the value to lowercase to ensure case-insensitive matching.
        $value = mb_strtolower($value, 'UTF-8');

        // Map English day names to their Spanish equivalents.
        $days = [
            'monday' => 'Lunes',
            'tuesday' => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday' => 'Jueves',
            'friday' => 'Viernes',
            'saturday' => 'Sábado',
            'sunday' => 'Domingo'
        ];

        // Return the translated day name or null if not found.
        return (isset($days[$value])) ? $days[$value] : null;
    }

    /**
     * Translate a month name from English to Spanish.
     *
     * @param string $value The month name in English.
     * @return string|null The translated month name in Spanish, or null if not found.
     */
    private function englishToSpanishMonth($value)
    {
        // Convert the value to lowercase to ensure case-insensitive matching.
        $value = mb_strtolower($value, 'UTF-8');

        // Map English month names to their Spanish equivalents.
        $months = [
            'january' => 'Enero',
            'february' => 'Febrero',
            'march' => 'Marzo',
            'april' => 'Abril',
            'may' => 'Mayo',
            'june' => 'Junio',
            'july' => 'Julio',
            'august' => 'Agosto',
            'september' => 'Septiembre',
            'october' => 'Octubre',
            'november' => 'Noviembre',
            'december' => 'Diciembre'
        ];

        // Return the translated month name or null if not found.
        return (isset($months[$value])) ? $months[$value] : null;
    }

}

