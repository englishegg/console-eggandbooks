<?php

namespace App\Controllers;

use App\Controllers\BaseController;

/**
 * @package App\Controllers
 * @OA\Info(title="API", version="1.0.0")
 */
class Swagger extends BaseController
{
    public function index()
    {
        if (ENVIRONMENT === 'production') {
            exit;
        }
        return view('swagger');
    }
    public function generate()
    {
        header('Content-Type: application/json');
        $openApi = \OpenApi\Generator::scan([APPPATH . 'Controllers']);
        file_put_contents( FCPATH.'swagger.json', $openApi->toJson());
        return $this->response->setJSON($openApi); //화면 보기용
    }
}