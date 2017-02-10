<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;


Router::scope('/', function (RouteBuilder $routes) {

	$routes->connect(
		'/', 
		['controller' => 'Pages', 'action' => 'index'],
		['_name' => 'home']
	);

	$routes->connect(
		'/contact',
		['controller' => 'Pages', 'action' => 'contact'],
		['_name' => 'contact']
	);



	//$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

	Router::prefix('admin', function ($routes) {

		$routes->connect('/', ['controller' => 'Pages', 'action' => 'index'], ['_name' => 'admin_home']);

		$routes->connect('/creations', ['controller' => 'Creations', 'action' => 'index'], ['_name' => 'admin_creations']);
		$routes->connect('/creations/:id', ['controller' => 'Creations', 'action' => 'view'],
			['id' => '\d+', 'pass' => ['id'], '_name' => 'admin_creations_view']);
		$routes->connect('/creations/edit/:id', ['controller' => 'Creations', 'action' => 'edit'],
			['id' => '\d+', 'pass' => ['id'], '_name' => 'admin_creations_edit']);
		$routes->connect('/creations/delete/:id', ['controller' => 'Creations', 'action' => 'delete'],
			['id' => '\d+', 'pass' => ['id'], '_name' => 'admin_creations_delete']);
		$routes->connect('/creations/add', ['controller' => 'Creations', 'action' => 'add'], ['_name' => 'admin_creations_new']);

		$routes->connect('/types', ['controller' => 'Types', 'action' => 'index'], ['_name' => 'admin_types']);
		$routes->connect('/types/add', ['controller' => 'Types', 'action' => 'add'], ['_name' => 'admin_types_new']);
		$routes->connect('/types/:id', ['controller' => 'Types', 'action' => 'view'],
			['id' => '\d+', 'pass' => ['id'], '_name' => 'admin_types_view']);
		$routes->connect('/types/edit/:id', ['controller' => 'Types', 'action' => 'edit'],
			['id' => '\d+', 'pass' => ['id'], '_name' => 'admin_types_edit']);
		$routes->connect('/types/delete/:id', ['controller' => 'Types', 'action' => 'delete'],
			['id' => '\d+', 'pass' => ['id'], '_name' => 'admin_types_delete']);
		$routes->connect('/medias', ['controller' => 'Medias', 'action' => 'index'],
			['_name' => 'admin_medias']
		);

		$routes->connect(
			'/login',
			['controller' => 'Users', 'action' => 'login'],
			['_name' => 'login']
		);

		$routes->connect(
			'/logout',
			['controller' => 'Users', 'action' => 'logout'],
			['_name' => 'logout']
		);

		//$routes->fallbacks(DashedRoute::class);
	});

});


Router::scope('/portfolio', function(RouteBuilder $routes){

	$routes->connect(
		'/',
		['controller' => 'Creations', 'action' => 'index'],
		['_name' => 'portfolio']
	);

	$routes->connect(
		'/type/:slug',
		['controller' => 'Types', 'action' => 'view'],
		['slug' => '[A-Za-z0-9-]+', 'pass' => ['slug'], '_name' => 'portfolio_type']
	);

	$routes->connect(
		'/:slug',
		['controller' => 'Creations', 'action' => 'view'],
		['slug' => '[A-Za-z0-9-]+', 'pass' => ['slug'], '_name' => 'portfolio_item']
	);



});

Plugin::routes();
