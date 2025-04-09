<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/swagger', 'Swagger::generate'); //public에 swagger.json 파일 생성
$routes->get('/swagger-api', 'Swagger::index'); //public에 swagger.json 파일 생성
