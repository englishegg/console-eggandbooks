<?php
if (!function_exists('setResponseFormat')) {
    function setResponseFormat($response, $code, $message, $data, $log = null)
    {
        if ($log) {
            log_message('error', 'setResponseFormat:::' . json_encode([
                    'data' => $data,
                    'code' => $code,
                    'messageCode' => $message,
                    'message' => empty($message) ? $message : getMessageByDomain($message)
                ]));
        }

        return $response->setJSON([
            'data' => $data,
            'code' => $code,
            'message' => empty($message) ? $message : getMessageByDomain($message)
        ]);
    }
}