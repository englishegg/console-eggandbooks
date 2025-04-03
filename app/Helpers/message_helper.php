<?php

if (!function_exists('getMessageByDomain')) {
    //서버별 메세지 분류
    function getMessageByDomain($code): string
    {
        $errorMsg = config('ErrorMessages');
        $environment = env('CI_ENVIRONMENT') == 'local' ? 'development' : env('CI_ENVIRONMENT');
        return $errorMsg->messages[$code][$environment] ?? $errorMsg->messages['DEFAULT_MSG'][$environment];
    }
}
if (!function_exists('generateRandomCode')) {
    // length 만큼 랜덤 숫자 출력
    function generateRandomCode($length): string
    {
        $start = (int)str_pad('0', $length, '0', STR_PAD_RIGHT);
        $end = (int)str_repeat('9', $length);
        $randomNumber = rand($start, $end);

        return str_pad((string)$randomNumber, $length, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('generateRandomString')) {
    // 확장자를 포함하여 랜덤 문자열 28자 반환
    function generateRandomString($ext): string
    {
        $extLength = strlen($ext);
        $randomBytes = random_bytes(28 - $extLength) . time();
        $hash = md5($randomBytes);
        $base64 = str_replace('=', '_', strtr(base64_encode(hex2bin($hash)), '+/', '-_'));

        return substr($base64, 0, 28 - $extLength) . $ext;
    }
}

if (!function_exists('logException')) {
    function logException(Exception $exception): void
    {
        log_message('error', json_encode([
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ]));
    }

}