<?php

namespace App\Helpers;

class Terbilang
{
    public static function make($number)
    {
        $number = abs($number);
        $words = array(
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas',
            'dua belas',
            'tiga belas',
            'empat belas',
            'lima belas',
            'enam belas',
            'tujuh belas',
            'delapan belas',
            'sembilan belas'
        );

        if ($number < 20) {
            return $words[$number];
        }

        if ($number < 100) {
            return $words[floor($number / 10)] . ' puluh ' . $words[$number % 10];
        }

        if ($number < 200) {
            return 'seratus ' . self::make($number - 100);
        }

        if ($number < 1000) {
            return $words[floor($number / 100)] . ' ratus ' . self::make($number % 100);
        }

        if ($number < 2000) {
            return 'seribu ' . self::make($number - 1000);
        }

        if ($number < 1000000) {
            return self::make(floor($number / 1000)) . ' ribu ' . self::make($number % 1000);
        }

        if ($number < 1000000000) {
            return self::make(floor($number / 1000000)) . ' juta ' . self::make($number % 1000000);
        }

        return self::make(floor($number / 1000000000)) . ' milyar ' . self::make($number % 1000000000);
    }
}
