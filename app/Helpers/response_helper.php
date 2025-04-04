<?php
if (!function_exists('setResponseFormat')) {
    function setResponseFormat($response, $code, $data, $log = null)
    {
        if ($log) {
            log_message('error', 'setResponseFormat:::' . json_encode([
                    'data' => $data,
                    'code' => $code,
                    'messageCode' => $code,
                    'message' => empty($code) ? $code : getMessageByDomain($code)
                ]));
        }

        return $response->setJSON([
            'data' => $data,
            'code' => $code,
            'message' => empty($code) ? $code : getMessageByDomain($code)
        ]);
    }
}