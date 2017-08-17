<?php

ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use model\system\SaveUser;
use model\system\GetUser;
use model\exceptions\ValidationException;

require 'vendor/autoload.php';

$app = new \Slim\App();

/**
 * @global $app
 */

$container = $app->getContainer();

$container['renderer'] = new \Slim\Views\PhpRenderer( "./templates" );

$app->get( "/registration", function ( Request $request, Response $response ) {
	if ( isset( $request->getCookieParams()['token'] ) ) {
		return $response->withRedirect( 'profile' );
	} else {
		return $this->renderer->render( $response, "registration.php" );
	}
} );

$app->post( "/saveUser", 'saveUser' );

$app->get( '/profile', function ( Request $request, Response $response){

	$user = getUserProfile( $request, $response );

	return $this->renderer->render( $response, "userPage.php", array(
		'user' => $user
	) );
});

$app->run();

function saveUser( Request $request, Response $response ) {

	$saveUser = new SaveUser( $request->getParsedBody() );
	$response->getBody()->write( $saveUser->posted() );

	return $response->withRedirect( 'profile' );

}

function getUserProfile( Request $request, Response $response ) {
	if ( isset( $request->getCookieParams()['token'] ) ) {
		$token = $request->getCookieParams()['token'];

		$user = new GetUser();

		try {
			$user = $user->getUser( $token );

			return $user;

		} catch ( ValidationException $e ) {
			echo $e->getMessage();
			echo "<br /><h1>Nice try</h1>";

			return false;
		}
	} else {
		return $response->withRedirect( 'registration' );
	}
}
