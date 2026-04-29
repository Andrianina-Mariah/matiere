<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Livre::index');

$routes->get('livre', 'Livre::index');
$routes->get('livre/(:num)', 'Livre::show/$1');
$routes->get('livre/create', 'Livre::create');
$routes->post('livre/store', 'Livre::store');
$routes->post('livre/delete/(:num)', 'Livre::delete/$1');

// POST pour les actions metier qui modifient l'etat (pret/retour), en coherence avec CSRF.
$routes->post('livre/pret/(:num)', 'Emprunt::pret/$1');
$routes->post('livre/retour/(:num)', 'Emprunt::retour/$1');

// Alias de compatibilite (anciens chemins)
$routes->get('livres', 'Livre::index');
$routes->get('livres/(:num)', 'Livre::show/$1');
$routes->get('livres/nouveau', 'Livre::create');
$routes->post('livres', 'Livre::store');
$routes->post('livres/(:num)/supprimer', 'Livre::delete/$1');
$routes->post('livres/(:num)/emprunter', 'Emprunt::pret/$1');
$routes->post('livres/(:num)/retourner', 'Emprunt::retour/$1');
