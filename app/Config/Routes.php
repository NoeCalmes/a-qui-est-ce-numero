<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->add('/numero/(:num)', 'PageNumero::getnumero/$1');
$routes->get('conditions-generales', 'Home::getCg');
$routes->get('politique-de-confidentialites', 'Home::getPc');
$routes->get('questions-frequemment-posees', 'Home::getFaq');
$routes->get('contact', 'Home::getContactc');



