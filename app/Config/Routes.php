<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/swagger', 'Swagger::generate'); //public에 swagger.json 파일 생성
$routes->get('/swagger-api', 'Swagger::index'); //public에 swagger.json 파일 생성

$routes->get('/api/v1/retail_eggtv', 'Products\EggTv\Ticket::readAllTickets');
$routes->post('/api/v1/retail_eggtv', 'Products\EggTv\Ticket::createTicket');
$routes->get('/api/v1/retail_eggtv/(:num)', 'Products\EggTv\Ticket::readOneTicket/$1');
$routes->delete('/api/v1/retail_eggtv/(:num)', 'Products\EggTv\Ticket::deleteTicket/$1');
$routes->get('/api/v1/retail_eggtv/(:num)/issues', 'Products\EggTv\Ticket::readAllTicketIssues/$1');
$routes->post('/api/v1/retail_eggtv/(:num)/issues', 'Products\EggTv\Ticket::createTicketIssue/$1');
$routes->get('/api/v1/retail_eggtv/(:num)/issues/(:num)', 'Products\EggTv\Ticket::readOneTicketIssue/$1/$2');
$routes->put('/api/v1/retail_eggtv/(:num)/issues/(:num)', 'Products\EggTv\Ticket::updateTicketIssue/$1/$2');
$routes->get('/api/v1/retail_eggtv/(:num)/issues/(:num)/codes', 'Products\EggTv\Ticket::readAllTicketCodes/$1/$2');
$routes->put('/api/v1/retail_eggtv/(:num)/issues/(:num)/codes', 'Products\EggTv\Ticket::updateTicketCode/$1/$2');
$routes->get('/api/v1/retail_eggtv/search', 'Products\EggTv\Ticket::searchTicketCode');
$routes->get('/api/v1/retail_eggtv/registered', 'Products\EggTv\Ticket::registeredTicket');
$routes->delete('/api/v1/retail_eggtv/registered', 'Products\EggTv\Ticket::retrieveRegisteredTicket');
$routes->get('/api/v1/retail_eggtv/used', 'Products\EggTv\Ticket::usedTicket');
$routes->delete('/api/v1/retail_eggtv/used', 'Products\EggTv\Ticket::retrieveUsedTicket');