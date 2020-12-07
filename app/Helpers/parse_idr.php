<?php

if ( ! function_exists('parse_idr')){
    function parse_idr($idr = null){
        if (is_null($idr)){
            return 0;
        }
        $removePrevix = str_replace('Rp.', '', $idr);
        $number = str_replace('.', '', $removePrevix);
        $number = explode(',', $number)[0];
        return $number;
    }
}

if ( ! function_exists('format_idr')) {
    function format_idr($angka){
        $rupiah = "Rp." . number_format($angka, 2, ',', '.');
        return $rupiah;
    }
}

if ( !function_exists('parse_format_number')) {
    function parse_format_number($angka){
        $number = str_replace('.', '', $angka);
        $number = str_replace(',', '.', $number);
        return $number;
    }
}

if (!function_exists('format_report')) {
    function format_report($angka)
    {
        $rupiah =  number_format($angka, 2, ',', '.');
        return $rupiah;
    }
}