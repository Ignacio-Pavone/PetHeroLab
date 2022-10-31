<?php
namespace Utils;

class DateFormat
{
    public static function formatDate($date)
    {
        $date = date_create($date);
        return date_format($date, 'd-m-Y');
    }
}