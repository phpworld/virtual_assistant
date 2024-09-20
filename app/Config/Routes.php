<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Chatbot::index');
$routes->post('getResponse', 'Chatbot::getResponse');