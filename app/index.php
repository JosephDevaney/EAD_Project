<?php
require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();
// Test
$app = new \Slim\Slim (); // slim run-time object

require_once "conf/config.inc.php";

function authenticate(\Slim\Route $route) {
	$app = \Slim\Slim::getInstance();

    $httpMethod = $app->request->getMethod ();
	
	$header = $app->request->headers();

	$action = ACTION_AUTHENTICATE_USER;

	$mvc = new loadRunMVCComponents ( "UserModel", "UserController", "noOutputView", $action, $app, $header );

	if ($app->response->headers->get('Authenticated'))
		return true;


	$app->halt(401);
}

function responseFormat($app){
    $headers = $app->request->headers();
    $responseFormat  = "jsonView";
    if($headers['Accept'] == 'application/xml')
        $responseFormat = "xmlView";
    return $responseFormat;
}

$app->map ( "/users(/:id)", function ($userID = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $userID; // prepare parameters to be passed to the controller (example: ID)
	
	if (($userID == null) or is_numeric ( $userID )) {
        $action = ACTION_CREATE_USER;
	}

    $responseFormat = responseFormat($app);

	return new loadRunMVCComponents ( "UserModel", "UserController", $responseFormat, $action, $app, $parameters );
} )->via ( "POST");

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
            case "PUT" :
                $action = ACTION_UPDATE_USER;
                break;
            case "DELETE" :
                $action = ACTION_DELETE_USER;
                break;
            case "PURGE" :
                $action = ACTION_PURGE_USERS;
            default :
        }
    }

    $responseFormat = responseFormat($app);

    return new loadRunMVCComponents ( "UserModel", "UserController", $responseFormat, $action, $app, $parameters );
} )->via ( "GET", "PUT", "DELETE", "PURGE");

$app->map ( "/search/:entity/:searchString", function ($entity = null,$searchString = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["SearchingString"] = $searchString; // prepare parameters to be passed to the controller (example: ID)

	if ($httpMethod == "GET" && is_string( $searchString ) && is_string( $entity )) {
        switch ($entity) {
            case "pokemon" :
                $action = ACTION_SEARCH_POKEMON;
                break;
            case "move" :
                $action = ACTION_SEARCH_MOVES;
                break;
            default :
		}
	}

    $responseFormat = responseFormat($app);

	return new loadRunMVCComponents ( "UserModel", "UserController", $responseFormat, $action, $app, $parameters );
} )->via ( "GET" );

$app->map ( "/pokemon(/:id)", function ($pokemonID = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $pokemonID; // prepare parameters to be passed to the controller (example: ID)

	if (($pokemonID == null) or is_numeric ( $pokemonID )) {
        if ($pokemonID != null)
            $action = ACTION_GET_POKEMON;
        else
            $action = ACTION_GET_ALL_POKEMON;
	}

    $responseFormat = responseFormat($app);

	return new loadRunMVCComponents ( "PokemonModel", "PokemonController", $responseFormat, $action, $app, $parameters );
} )->via ( "GET");

$app->map ( "/pokemon(/:id)", "authenticate", function ($pokemonID = null) use($app) {
    $httpMethod = $app->request->getMethod ();
    $action = null;
    $parameters ["id"] = $pokemonID; // prepare parameters to be passed to the controller (example: ID)

    if (($pokemonID == null) or is_numeric ( $pokemonID )) {
        switch ($httpMethod) {
            case "POST" :
                $action = ACTION_CREATE_POKEMON;
                break;
            case "PUT" :
                $action = ACTION_UPDATE_POKEMON;
                break;
            case "DELETE" :
                $action = ACTION_DELETE_POKEMON;
                break;
            case "PURGE" :
                $action = ACTION_PURGE_POKEMON;
                break;
            default :
        }
    }

    $responseFormat = responseFormat($app);

    return new loadRunMVCComponents ( "PokemonModel", "PokemonController", "jsonView", $action, $app, $parameters );
} )->via ( "POST", "PUT", "DELETE", "PURGE" );

$app->map ( "/moves(/:id)", function ($moveID = null) use($app) {
    $httpMethod = $app->request->getMethod ();
    $action = null;
    $parameters ["id"] = $moveID; // prepare parameters to be passed to the controller (example: ID)

    if (($moveID == null) or is_numeric ( $moveID )) {
        if ($moveID != null)
            $action = ACTION_GET_MOVE;
        else
            $action = ACTION_GET_MOVES;
    }

    $responseFormat = responseFormat($app);

    return new loadRunMVCComponents ( "MoveModel", "MoveController", $responseFormat, $action, $app, $parameters );
} )->via ( "GET" );

$app->map ( "/moves(/:id)", "authenticate", function ($moveID = null) use($app) {
    $httpMethod = $app->request->getMethod ();
    $action = null;
    $parameters ["id"] = $moveID; // prepare parameters to be passed to the controller (example: ID)

    if (($moveID == null) or is_numeric ( $moveID )) {
        switch ($httpMethod) {
            case "POST" :
                $action = ACTION_CREATE_MOVE;
                break;
            case "PUT" :
                $action = ACTION_UPDATE_MOVE;
                break;
            case "DELETE" :
                $action = ACTION_DELETE_MOVE;
                break;
            case "PURGE" :
                $action = ACTION_PURGE_MOVES;
                break;
            default :
        }
    }

    $responseFormat = responseFormat($app);

    return new loadRunMVCComponents ( "MoveModel", "MoveController", $responseFormat, $action, $app, $parameters );
} )->via ( "POST", "PUT", "DELETE", "PURGE" );

$app->run ();
class loadRunMVCComponents {
	public $model, $controller, $view;
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) {
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$this->model = new $modelName (); // common model
		$this->controller = new $controllerName ( $this->model, $action, $app, $parameters );
		$this->view = new $viewName ( $this->controller, $this->model, $app, $app->headers ); // common view
		$this->view->output (); // this returns the response to the requesting client
	}
}

?>