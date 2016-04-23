<?php
require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();
// Test
$app = new \Slim\Slim (); // slim run-time object

require_once "conf/config.inc.php";

function authenticate(\Slim\Route $route) {
	$app = \Slim\Slim::getInstance();
	require_once "models/UserModel.php";
	
	$header = $app->request->headers();
	$name = $header["username"];
	$pwd = $header["password"];

	$model = new UserModel();
	$user = $model->searchUsername($name);
	
	if ($user != false && $user != null) {
		foreach ($user as $u) {
			if ($u["password"] == $pwd) {
				return true;
			}
		}
	}
	$app->halt(401);
}

$app->map ( "/users(/:id)", "authenticate", function ($userID = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $userID; // prepare parameters to be passed to the controller (example: ID)
	
	if (($userID == null) or is_numeric ( $userID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($userID != null)
					$action = ACTION_GET_USER;
				else
					$action = ACTION_GET_USERS;
				break;
			case "POST" :
				$action = ACTION_CREATE_USER;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_USER;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_USER;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );

$app->map ( "/search/:string", "authenticate", function ($string = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["SearchingString"] = $string; // prepare parameters to be passed to the controller (example: ID)

	if (is_string( $string )) {
		switch ($httpMethod) {
			case "GET" :
				$action = ACTION_SEARCH_USERS;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
} )->via ( "GET" );

$app->map ( "/pokemon(/:id)", "authenticate", function ($pokemonID = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $pokemonID; // prepare parameters to be passed to the controller (example: ID)

	if (($pokemonID == null) or is_numeric ( $pokemonID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($pokemonID != null)
					$action = ACTION_GET_POKEMON;
				else
					$action = ACTION_GET_ALL_POKEMON;
				break;
			case "POST" :
				$action = ACTION_CREATE_POKEMON;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_POKEMON;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_POKEMON;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "PokemonModel", "PokemonController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );

$app->map ( "/moves(/:id)", "authenticate", function ($moveID = null) use($app) {
    $httpMethod = $app->request->getMethod ();
    $action = null;
    $parameters ["id"] = $moveID; // prepare parameters to be passed to the controller (example: ID)

    if (($moveID == null) or is_numeric ( $moveID )) {
        switch ($httpMethod) {
            case "GET" :
                if ($moveID != null)
                    $action = ACTION_GET_MOVE;
                else
                    $action = ACTION_GET_MOVES;
                break;
            case "POST" :
                $action = ACTION_CREATE_MOVE;
                break;
            case "PUT" :
                $action = ACTION_UPDATE_MOVE;
                break;
            case "DELETE" :
                $action = ACTION_DELETE_MOVE;
                break;
            default :
        }
    }
    return new loadRunMVCComponents ( "MoveModel", "MoveController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );

$app->run ();
class loadRunMVCComponents {
	public $model, $controller, $view;
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) {
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$model = new $modelName (); // common model
		$controller = new $controllerName ( $model, $action, $app, $parameters );
		$view = new $viewName ( $controller, $model, $app, $app->headers ); // common view
		$view->output (); // this returns the response to the requesting client
	}
}

?>