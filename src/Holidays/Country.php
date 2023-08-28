<?php

namespace Rmunate\Calendario\Holidays;

use Rmunate\Calendario\Bases\BaseCountry;

class Country extends BaseCountry
{
    /**
     * Returns an array with holidays for Colombia.
     *
     * @return array An array of holidays with detailed information.
     */
    public function colombia()
    {
        return array_merge([
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2000::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2001::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2002::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2003::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2004::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2005::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2006::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2007::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2008::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2009::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2010::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2011::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2012::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2013::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2014::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2015::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2016::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2017::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2018::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2019::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2020::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2021::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2022::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2023::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2024::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2025::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2026::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2027::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2028::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2029::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2030::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2031::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2032::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2033::all(),
            ...\Rmunate\Calendario\Holidays\Colombia\CO_2034::all(),
        ]);
    }
}