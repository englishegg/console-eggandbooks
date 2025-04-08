<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Config\Database;
use Exception;

class HealthCheck extends ResourceController
{
    public function index(): ResponseInterface
    {
        $db = Database::connect();
        try {
            $db->connect();
            $db->query("SELECT 1");
        } catch (Exception $e) {
            return $this->fail("Database connection error", 500);
        }

        return $this->respond([
            'status' => 'ok',
            'timestamp' => time(),
        ]);
    }
}