<?php
	session_start();

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Cache-Control, Pragma, Authorization, Accept-Encoding");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
	header("Content-Type: application/json");

	date_default_timezone_set('America/Asuncion');

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	require __DIR__.'/../vendor/autoload.php';
	$settings = require __DIR__.'/../src/settings.php';

	$app = new \Slim\App($settings);
	require __DIR__.'/../src/dependencies.php';

	$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
		"secure"=> false,
		"users" => [
			"user_sfholox" => "ns3r_5fh0!0x"
		],
		"error" => function($response, $args) {
			header("Content-Type: application/json; charset=utf-8");

			$data			= [];
			$data['code']	= 401;
			$data['status'] = 'failure';
			$data['message']= 'Error NO AUTORIZADO';
	
			$body = $response->getBody();
			$body->write(json_encode($data, JSON_UNESCAPED_SLASHES));
	
			return $response->withBody($body);
		}
	]));

	//ROUTES
	require __DIR__.'/../src/routes.php';
	
	$app->run();