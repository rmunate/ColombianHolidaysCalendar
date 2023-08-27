<?php

namespace Rmunate\Calendario\Holidays;

use Rmunate\Calendario\Bases\BaseCountry;

class Country extends BaseCountry
{
    /**
     * Retorna un arreglo con los dias festivos de colombia
     * 
     * @return array
     */
    public function colombia()
    {
        return array_merge([
            $this->holidays2000(),
            $this->holidays2001(),
            $this->holidays2002(),
            $this->holidays2003(),
            $this->holidays2004(),
            $this->holidays2005(),
            $this->holidays2006(),
            $this->holidays2007(),
            $this->holidays2008(),
            $this->holidays2009(),
            $this->holidays2010(),
            $this->holidays2011(),
            $this->holidays2012(),
            $this->holidays2013(),
            $this->holidays2014(),
            $this->holidays2015(),
            $this->holidays2016(),
            $this->holidays2017(),
            $this->holidays2018(),
            $this->holidays2019(),
            $this->holidays2020(),
            $this->holidays2021(),
            $this->holidays2022(),
            $this->holidays2023(),
            $this->holidays2024(),
            $this->holidays2025(),
            $this->holidays2025(),
            $this->holidays2027(),
            $this->holidays2028(),
            $this->holidays2029(),
            $this->holidays2030(),
            $this->holidays2031(),
            $this->holidays2032(),
            $this->holidays2033(),
            $this->holidays2034(),
        ]);
    }

}