<?php

if (!function_exists('rupiah')) {
    /**
     * Format number to rupiah
     * @param number $amount
     */
    function rupiah($amount): string
    {
        return number_format($amount, 0, ',' , '.');
    }
}

if (!function_exists('dateFormat')) {
    /**
     * Format date to Y-m-d
     * @param number $date
     */
    function dateFormat($date): string
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }
}

if (!function_exists('rupiahToInteger')) {
    /**
     * Format rupiah to integer
     * @param stringNumber $rupiah
     */
    function rupiahToInteger($rupiah)
    {
        return (int) str_replace('.', '', $rupiah);
    }
}