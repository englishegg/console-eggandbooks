<?php
use Firebase\JWT\JWT;

if (!function_exists('createAccessToken')) {
    function createAccessToken($memberId): string
    {
        return JWT::encode([
            'memberId' => $memberId,
            'iat' => time(), // 토큰 발급 시간
//            'exp' => time() + (30 * 24 * 60 * 60) // 30일 후 만료
//            'exp' => time() + (10 * 60) // 10분 후 만료
            'exp' => time() + (10) // 10초
        ], env('JWT_ACCESS_TOKEN_KEY'), env('JWT_ALGORITHM')); // key 값 확인
    }
}

if (!function_exists('createRefreshToken')) {
    function createRefreshToken($memberId): string
    {
        return JWT::encode([
            'memberId' => $memberId,
            'iat' => time(), // 토큰 발급 시간
            'exp' => time() + (30 * 24 * 60 * 60) // 30일 후 만료
        ], env('JWT_REFRESH_TOKEN_KEY'), env('JWT_ALGORITHM')); //key 값 확인
    }
}

if (!function_exists('setCookies')) {
    function setCookies($cookieName, $token, $cookieExpire): void
    {
        $tokenCookie = [
            'name'   => $cookieName, // 쿠키 이름
            'value'  => $token, // 쿠키 값
            'expire' => $cookieExpire, // 만료 시간: 'issue' => 60 * 5(5분) / 'expire' => 60 * 60 * 24 * 7(7일)
            'domain' => env('COOKIE_DOMAIN') ?? '', // 쿠키 도메인
            'path'   => '/', // 쿠키 경로
            'prefix' => '', // 접두사
            'secure' => filter_var(env('COOKIE_SECURE'), FILTER_VALIDATE_BOOLEAN), // HTTPS만 쿠키 사용 (true 또는 false) !! 바꿔야함
            'httponly' => filter_var(env('COOKIE_HTTPONLY'), FILTER_VALIDATE_BOOLEAN), // JavaScript에서 쿠키 접근 제한 (true 또는 false)
            'samesite' => env('COOKIE_SAMESITE'), // SameSite 속성 : 도메인이 달라서 none 처리해야하는데 이부분 확인
        ];
//        log_message('info', 'setCookies $tokenCookie ::: ' . json_encode($tokenCookie));
        set_cookie($tokenCookie);
    }
}

if (!function_exists('convertBase64UrlToBase64')) {
    function convertBase64UrlToBase64($input): string
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $paddle = 4 - $remainder;
            $input .= str_repeat('=', $paddle);
        }
        return strtr($input, '-_', '+/');
    }
}

if (!function_exists('getSignatureToken')) {
    function getSignatureToken($token): string
    {
        $token = explode('.', $token);
        return bin2hex(base64_decode(convertBase64UrlToBase64($token[2])));
    }
}

if (!function_exists('isUserLoggedIn')) {
    function isUserLoggedIn(): bool
    {
        return get_cookie('accessToken') !== null && get_cookie('refreshToken') !== null;
    }
}

if (!function_exists('clearCookiesAndSession')) {
    function clearCookiesAndSession(): void
    {
        setCookies('accessToken', null, -1); //accessToken clear
        setCookies('refreshToken', null, -1); //refreshToken clear
        if (session()->has('isLoggedIn')) {
            session()->destroy(); //session clear
        }
    }
}
