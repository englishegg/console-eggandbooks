<?php

use Config\Services;

if (!function_exists('convertLineBreaks')) {
    function convertLineBreaks($textarea): array|string
    {
        return str_replace(["\r\n", "\r", "\n"], "\r\n", $textarea);
    }
}