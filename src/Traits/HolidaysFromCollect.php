<?php

namespace Rmunate\Calendario\Traits;

use Illuminate\Support\Collection;
use Rmunate\Calendario\Holidays\Country;

trait HolidaysFromCollect
{
    /**
     * Get a collection of holidays for the specified country.
     *
     * @return \Illuminate\Support\Collection
     */
    private function holidays()
    {
        // Use the Country class to retrieve holidays for the specified country.
        return Country::get($this->country);
    }

    /**
     * Validate if filters have already been applied to the library's response.
     *
     * @return \Illuminate\Support\Collection
     */
    private function query()
    {
        // Check if filters have been applied to the response or return the default holidays.
        return (!empty($this->response) && $this->response instanceof Collection) ? $this->response : $this->holidays();
    }

    /**
     * Validate if filters have already been applied to the library's response.
     *
     * @return \Illuminate\Support\Collection
     */
    private function response()
    {
        // Check if filters have been applied to the response or return collect empty.
        return (!empty($this->response) && $this->response instanceof Collection) ? $this->response : collect();
    }
}
