<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(function ($request, $response, $next) {
	
	//if(isset($_SESSION['USER'])){
		$response = $next($request, $response);
		return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET,POST')
            ->withHeader('Access-Control-Allow-Headers', '*');
	//} else {
	//	return $response->withJson(["status" => "Not Login"], 401);
	//}
});