<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

$routes->get('etudiants', 'Etudiant::index');
$routes->get('etudiants/(:num)', 'Etudiant::show/$1');

$routes->get('notes', 'Note::index');
$routes->get('notes/create', 'Note::create');
$routes->post('notes/store', 'Note::store');
$routes->post('notes/delete/(:num)', 'Note::delete/$1');
