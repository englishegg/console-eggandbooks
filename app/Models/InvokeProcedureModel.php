<?php

namespace Models;

use CodeIgniter\Model;
use Config\Database;
use Exception;

class InvokeProcedureModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->db->query('USE egg');
    }

    public function executeSP($spName, $spParameterCount, $parameter, $log = false)
    {
        if (!$spParameterCount > 0 || empty($spName)) {
            throw new Exception('MISSING_DATA_REQUIRED', 500);
        }
        $spParameter = implode(', ', array_fill(0, $spParameterCount, '?'));
        $spParameter = "($spParameter)";

        $query = $this->db->query("CALL `" . $spName . "`" . $spParameter, $parameter);
        $result = json_decode(json_encode($query->getResult()), true);

        if ($log) {
            log_message('info', json_encode(['spName' => $spName, 'spParameter' => $spParameter, 'log' => $parameter, 'result' => $result]));
        }
        if (isset($result[0]['sp_status_code'])) {
            if ($result[0]['sp_status_code'] === '1') {
                throw new Exception($result[0]['sp_error_code'], 500);
            }
            if ($result[0]['sp_status_code'] === '2') {
                //sp_error_message
                throw new Exception('DEFAULT_MSG', 500);
            }
        }

        return $result;
    }
}