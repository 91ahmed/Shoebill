<?php

	$route = new \Core\Modules\Routes\Route();

	// Remove specific words from the URL
	$route->remove([DIR]);

	$route->middleware(['app'])->get('/', 'HomeController@index');

	$route->get('{lang}/home', function () {
		echo 'Lang';
	});

	// Start Group Middlewares
	$route->middlewareGroup(['app']);

		$route->middleware(['auth'])
			  ->regex(['id' => '^[a-z0-9{}?\/]+$'])
			  ->get('/home/en/{id}/{email}', 'HomeController@index');

		$route->get('/home/ar/{username}', function ($username) {
			var_dump(ROUTE_URL_PARAMS);
			echo 'username = '.$username;
		});

	// End Group Middlewares
	$route->middlewareEnd();


	$route->get('/hello/world', function () {
		echo 'Hello World';
	});

	// 404 Not Found Error
	$route->error404(function () {
		exit('404 - Page Not Found.');
	});
?>