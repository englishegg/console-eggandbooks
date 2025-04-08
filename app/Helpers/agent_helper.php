<?php

use Config\Services;

if (!function_exists('getPlatformInfo')) {
    function getPlatformInfo(): string
    {
        $agent = Services::request()->getUserAgent();
        return $agent->getPlatform() ?? '';
    }
}

if (!function_exists('getBrowserInfo')) {
    function getBrowserInfo(): string
    {
        $agent = Services::request()->getUserAgent();
        return $agent->getBrowser() ?? '';
    }
}

