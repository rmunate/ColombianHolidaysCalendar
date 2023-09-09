# Colombian Holidays Calendar

This package allows you to work with Colombian holidays. With the use of two classes, you can achieve incredible results in your projects. It will be particularly useful for projects where you need to validate if a date is a holiday, check if a year is a leap year, count the number of holidays within a date range, and much more. The package currently supports years from 2000 to 2034, and our commitment is to always provide information for at least 10 years into the future.

⚙️ This library is compatible with Laravel versions 9.0 and above ⚙️

[![Laravel 9.0+](https://img.shields.io/badge/Laravel-9.0%2B-orange.svg)](https://laravel.com)
[![Laravel 10.0+](https://img.shields.io/badge/Laravel-10.0%2B-orange.svg)](https://laravel.com)

![CALENDARIO-COLOMBIA](https://github.com/rmunate/ColombianCalendar/assets/91748598/2704135f-f8ad-4875-a0d9-bfbaea90fed9)

📖 [**DOCUMENTATION IN SPANISH**](README.md) 📖

## Table of Contents

- [Introduction](#introduction)
- [Installation](#installation)
- [Using the **Calendar** Class](#using-the-calendar-class)
  - [Method `today()`](#method-today)
  - [Method `date()`](#method-date)
  - [Method `timeZone()`](#method-timezone)
  - [Chained Assignment Methods](#chained-assignment-methods)
  - [Date Handling Methods](#date-handling-methods)
  - [Direct Methods](#direct-methods)
  - [Date Difference Methods](#date-difference-methods)
- [Using the **Holidays** Class](#using-the-holidays-class)
  - [Available Methods for Working with Holidays](#available-methods-for-working-with-holidays)
- [Creator](#creator)
- [License](#license)

## Introduction

This package provides two classes for accessing methods: the `Calendar` class allows you to work with dates, performing tasks such as calculating date ranges, incrementing and decrementing dates, and more. The `Holidays` class allows you to work exclusively with holidays, and it currently supports Colombia only.

## Installation

To install this package via **Composer**, run the following command:

```shell
composer require rmunate/calendario-colombia
```

## Using the **Calendar** Class

To use the different methods available in the `Calendar` class, you can initialize it in one of the following three ways:

### Method `today()`

This method initializes the class with the current date according to the timezone configured in the Laravel framework or the one provided as an argument.

```php
use Rmunate\Calendario\Calendar;

// Initialize the class with the current date according to the timezone loaded in Laravel
$calendar = Calendar::today();

// Initialize the class with the current date in the provided timezone
$calendar = Calendar::today('America/Bogota');
```

### Method `date()`

This method allows you to provide a specific date to initialize the class.

```php
use Rmunate\Calendario\Calendar;

// Initialize the class with a specific date
$calendar = Calendar::date('2023-09-01');

// Initialize the class with a specific date and timezone
$calendar = Calendar::date('2023-09-01', 'America/Bogota');
```

### Method `timeZone()`

This method initializes the class with a specific timezone.

```php
use Rmunate\Calendario\Calendar;

$calendar = Calendar::timeZone('America/Bogota');
```

### Chained Assignment Methods

Next, we list the available methods within the class that you can chain together to configure the class initialization more clearly and structurally.

#### Method `setTimezone()`

Assign a timezone after using the `today()` or `date()` initialization methods.

```php
use Rmunate\Calendario\Calendar;

$calendar = Calendar::date('2023-09-10')->setTimezone('America/Bogota');
$calendar = Calendar::today()->setTimezone('America/Bogota');
```

#### Method `setDate()`

Assign a date when the initialization method is `timeZone()`.

```php
use Rmunate\Calendario\Calendar;

$calendar = Calendar::timeZone('America/Bogota')->setDate('2023-09-10');
```

### Date Handling Methods

Next, we will list the methods you can use in conjunction with any of the previous initialization methods. For the purposes of this manual, we will use the `date` initialization method, but you can use any of the previously mentioned methods.

```php
use Rmunate\Calendario\Calendar;

// Check if the date is a holiday in Colombia
$isHoliday = Calendar::date('2023-09-10')->isHoliday();

// Get the reason for the holiday or null if it's not a holiday
$descriptionIfHoliday = Calendar::date('2023-09-10')->getDescriptionIfHoliday();

// Validate if the date corresponds to a specific day of the week (returns true or false)
$isMonday = Calendar::date('2023-09-10')->isMonday();
$isTuesday = Calendar::date('2023-09-10')->isTuesday();
$isWednesday = Calendar::date('2023-09-10')->isWednesday();
$isThursday = Calendar::date('2023-09-10')->isThursday();
$isFriday = Calendar::date('2023-09-10')->isFriday();
$isSaturday = Calendar::date('2023-09-10')->isSaturday();
$isSunday = Calendar::date('2023-09-10')->isSunday();

// Get specific date values
$dayNumberString = Calendar::date('2023-09-01')->getDayNumberString(); // "01"
$dayNumberInteger = Calendar::date('2023-09-01')->getDayNumberInteger(); // 1
$monthNumberString = Calendar::date('2023-09-01')->getMonthNumberString(); // "09"
$monthNumberInteger = Calendar::date('2023-09-01')->getMonthNumberInteger(); // 9
$year = Calendar::date('2023-09-01')->getYear(); // 2023
$isoDate = Calendar::date('2023-09-10')->getDayNumberISO(); // 7 (1 for Monday - 7 for Sunday)
$isoWeek = Calendar::date('2023-09-10')->getWeekISO(); // 33
$nmerDayInYear = Calendar::date('2023-09-10')->getDayYear(); // 253
$nameEnglish = Calendar::date('2023-09-10')->getNameDayEnglish(); // "Sunday"
$nameSpanish = Calendar::date('2023-09-10')->getNameDaySpanish(); // "Domingo"
$nameEnglish = Calendar::date('2023-09-10')->getNameMonthEnglish(); // "September"
$nameSpanish = Calendar::date('2023-09-10')->getNameMonthSpanish(); // "Septiembre"
$dateInArray = Calendar::date('2023-09-10')->toArray(); // An array representation of the date
$dateInObject = Calendar::date('2023-09-10')->toObject(); // An object representation of the date
$fixUp = Calendar::date('2023-09-10')->fixUp(3); // An array of future dates
$fixDown = Calendar::date('2023-09-10')->fixDown(3); // An array of past dates
$addDays = Calendar::date('2023-09-10')->addDays(3); // "2023-09-13"
$reduceDays = Calendar::date('2023-09-10')->subDays(3); // "2023-09-07"
$addMonths = Calendar::date('2023-09-10')->addMonths(3); // "2023-12-10"
$subMonths = Calendar::date('2023-09-10')->subMonths(3); // "2023-06-10"
$addYears = Calendar::date('2023-09-10')->addYears(3); // "2026-09-10"
$subYears = Calendar::date('2023-09-10')->subYears(3); // "2020-09-10"
$isPast = Calendar::date('2023-09-10')->isPast(); // true or false
$isFuture = Calendar::date('2023-09-10')->isFuture(); // true or false
```

### Direct Methods

Here are the methods that do not require initialization through a date or timezone:

```php
use Rmunate\Calendario\Calendar;

// Get the number of days in a specific month
$numberOfDaysMonth = Calendar::getDaysInMonth(2023, 9); // 30

// Get the first day of a month
$firstDayOfMonth = Calendar::getFirstDayOfMonth(2023, 9); // "2023-09-01"

// Get the last day of a month
$lastDayOfMonth = Calendar::getLastDayOfMonth(2023, 9); // "2023-09-30"

// Check if it's a leap year (returns true or false)
$isLeapYear = Calendar::isLeapYear(2023); // false
```

### Date Difference Methods

```php
use Rmunate\Calendario\Calendar;

// Get the difference between two dates, including hours, minutes, and seconds
$diff = Calendar::diff(['2023-09-01 00:01:00', '2023-09-09 12:00:00'])->getDatetimeIntervals();

// Get the difference between two dates, excluding hours, minutes, and seconds
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->getDateIntervals();

// Get the difference in human-readable format
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans();
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans('es');
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans('en');
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans('fr');
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->forHumans(...);
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->inDays(); // Get the difference in days
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->excludingDays(); // Get the difference in days excluding the initial day
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->excludingDays('Saturday', 'Sunday'); // Get the difference in days excluding specific days
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->excludingHolidays(); // Get the difference in days excluding holidays
$diff = Calendar::diff(['2023-09-01', '2023-09-09'])->excludingHolidaysAndThisDays('Friday', 'Sunday'); // Get the difference in days excluding holidays and specific days
```

## Using the **Holidays** Class

With the `Holidays` class, you can perform various operations specifically with holidays in Colombia. You can initialize the class through the `Calendar` class or directly using `Holidays`.

Using Calendar:

```php
use Rmunate\Calendario\Calendar;

$holidays = Calendar::onlyHolidays();
```

Using Holidays:

```php
use Rmunate\Calendario\Holidays;

$holidays = Holidays::colombia();
```

### Available Methods for Working with Holidays

You can use any of the following methods by chaining them with the two possible ways to initialize the holiday dates query. For the purpose of this manual, we will use the `Holidays` class.

```php
use Rmunate\Calendario\Holidays;

// Get the currently available years for working with holidays
$holidays = Holidays::colombia()->yearsAvailable();

// Retrieve all holidays as a Laravel collection
$holidays = Holidays::colombia()->all();

// Get specific holidays for a year in a Laravel collection
$holidays = Holidays::colombia()->year(2023)->get();

// Get holidays for one or multiple years
$holidays = Holidays::colombia()->years(2022, 2023)->get();

// Get holidays for one or multiple months within a specific year
$holidays = Holidays::colombia()->year(2023)->month(8)->get();
$holidays = Holidays::colombia()->years(2022, 2023)->month(8)->get();
$holidays = Holidays::colombia()->year(2023)->months(8, 9)->get();
$holidays = Holidays::colombia()->years(2022, 2023)->months(8, 9)->get();

// Get holidays between two dates
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->get();

// Get holidays excluding specific days
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->notInclude('Sunday')->get();
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->except('Sunday')->get();

// Get holidays for specific days of the week
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->include('Monday')->get();
$holidays = Holidays::colombia()->between(['2023-08-01', '2023-09-09'])->only('Monday')->get();
```

### Other Methods

In addition to the `get()` method, you can use the following methods:

```php
$holidays = Holidays::colombia()->year(2023)->get(); // Returns a Laravel collection
$holidays = Holidays::colombia()->year(2023)->toCollect(); // Returns a Laravel collection
$holidays = Holidays::colombia()->year(2023)->toArray(); // Returns the response as an array
$holidays = Holidays::colombia()->year(2023)->toJson(); // Returns the response as JSON
$holidays = Holidays::colombia()->year(2023)->count(); // Returns the count of holidays
$holidays = Holidays::colombia()->year(2023)->first(); // Returns the first holiday
$holidays = Holidays::colombia()->year(2023)->last(); // Returns the last holiday
$holidays = Holidays::colombia()->year(2023)->pluck('holiday_reason', 'full_date'); // Returns an indexed array of dates and holiday reasons
$holidays = Holidays::colombia()->year(2023)->groupBy('month'); // Returns grouped data as requested.
```

## Creator
- 🇨🇴 Raúl Mauricio Uñate Castro
- Email: raulmauriciounate@gmail.com

## License
This project is under the [MIT License](https://choosealicense.com/licenses/mit/).

🌟 Support My Projects! 🚀

Make any contributions you see fit; the code is entirely yours. Together, we can do amazing things and improve the world of development. Your support is invaluable. ✨

If you have ideas, suggestions, or just want to collaborate, we are open to everything! Join our community and be part of our journey to success! 🌐👩‍💻👨‍💻
