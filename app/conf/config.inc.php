<?php
/* database constants */
define("DB_HOST", "localhost" ); 		// set database host
define("DB_USER", "root" ); 			// set database user
define("DB_PASS", "" ); 				// set database password
define("DB_PORT", 3306);				// set database port
define("DB_NAME", "EAD_Project" ); 			// set database name
define("DB_CHARSET", "utf8" ); 			// set database charset
define("DB_DEBUGMODE", true ); 			// set database charset


/* request testing constants*/
define("BASE_URL", "http://localhost/phpstorm/EAD_Project/app/index.php/");
//define("BASE_URL", "http://localhost:1337/Workspace/EAD_Project/app/index.php/");

/* actions for the USERS REST resource */
define("ACTION_AUTHENTICATE_USER", 122);
define("ACTION_GET_USER", 133);
define("ACTION_GET_USERS", 144);
define("ACTION_CREATE_USER", 155);
define("ACTION_UPDATE_USER", 166);
define("ACTION_DELETE_USER", 177);
define("ACTION_SEARCH_USERS", 188);
define("ACTION_PURGE_USERS", 199);

/* actions for the POKEMON REST resource */
define("ACTION_GET_POKEMON", 233);
define("ACTION_GET_ALL_POKEMON", 244);
define("ACTION_CREATE_POKEMON", 255);
define("ACTION_UPDATE_POKEMON", 266);
define("ACTION_DELETE_POKEMON", 277);
define("ACTION_SEARCH_POKEMON", 288);
define("ACTION_PURGE_POKEMON", 299);

/* actions for the MOVES REST resource */
define("ACTION_GET_MOVE", 333);
define("ACTION_GET_MOVES", 344);
define("ACTION_CREATE_MOVE", 355);
define("ACTION_UPDATE_MOVE", 366);
define("ACTION_DELETE_MOVE", 377);
define("ACTION_SEARCH_MOVES", 388);
define("ACTION_PURGE_MOVES", 399);

/* HTTP status codes 2xx*/
define("HTTPSTATUS_OK", 200);
define("HTTPSTATUS_CREATED", 201);
define("HTTPSTATUS_NOCONTENT", 204);

/* HTTP status codes 3xx (with slim the output is not produced i.e. echo statements are not processed) */
define("HTTPSTATUS_NOTMODIFIED", 304);

/* HTTP status codes 4xx */
define("HTTPSTATUS_BADREQUEST", 400);
define("HTTPSTATUS_UNAUTHORIZED", 401);
define("HTTPSTATUS_FORBIDDEN", 403);
define("HTTPSTATUS_NOTFOUND", 404);
define("HTTPSTATUS_REQUESTTIMEOUT", 408);
define("HTTPSTATUS_TOKENREQUIRED", 499);

/* HTTP status codes 5xx */
define("HTTPSTATUS_INTSERVERERR", 500);

define("TIMEOUT_PERIOD", 120);

/* general message */
define("GENERAL_MESSAGE_LABEL", "message");
define("GENERAL_SUCCESS_MESSAGE", "success");
define("GENERAL_ERROR_MESSAGE", "error");
define("GENERAL_NOCONTENT_MESSAGE", "no-content");
define("GENERAL_NOTMODIFIED_MESSAGE", "not modified");
define("GENERAL_INTERNALAPPERROR_MESSAGE", "internal app error");
define("GENERAL_CLIENT_ERROR", "client error: modify the request");
define("GENERAL_INVALIDTOKEN_ERROR", "Invalid token");
define("GENERAL_APINOTEXISTING_ERROR", "Api is not existing");
define("GENERAL_RESOURCE_CREATED", "Resource has been created");
define("GENERAL_RESOURCE_UPDATED", "Resource has been updated");
define("GENERAL_RESOURCE_DELETED", "Resource has been deleted");

define("GENERAL_FORBIDDEN", "Request is ok but action is forbidden");
define("GENERAL_INVALIDBODY", "Request is ok but transmitted body is invalid");

define("GENERAL_WELCOME_MESSAGE", "Welcome to DIT web-services");
define("GENERAL_INVALIDROUTE", "Requested route does not exist");
define("GENERAL_AUTHORISED_MESSAGE", "User Authorised");
define("GENERAL_UNAUTHORISED_MESSAGE", "Provide valid credentials to perform this action");
define("GENERAL_PURGE_MESSAGE", "all entities deleted");


/* representation of a new user in the DB */
define("TABLE_USER_NAME_LENGTH", 25);
define("TABLE_USER_SURNAME_LENGTH", 25);
define("TABLE_USER_EMAIL_LENGTH", 50);
define("TABLE_USER_PASSWORD_LENGTH", 40);

/* representation of a new move in the DB */
define("TABLE_MOVE_NAME_LENGTH", 30);

/* Users database columns Types */
define("USERS_ID_TYPE", PDO::PARAM_INT);
define("USERS_USERNAME_TYPE", PDO::PARAM_STR);
define("USERS_NAME_TYPE", PDO::PARAM_STR);
define("USERS_SURNAME_TYPE", PDO::PARAM_STR);
define("USERS_EMAIL_TYPE", PDO::PARAM_STR);
define("USERS_PASSWORD_TYPE", PDO::PARAM_STR);

/* Pokemon database columns Types */
define("POKEMON_ID_TYPE", PDO::PARAM_INT);
define("POKEMON_NAME_TYPE", PDO::PARAM_STR);
define("POKEMON_HEIGHT_TYPE", PDO::PARAM_INT);
define("POKEMON_WEIGHT_TYPE", PDO::PARAM_INT);
define("POKEMON_HP_TYPE", PDO::PARAM_INT);
define("POKEMON_MOVE1_ID_TYPE", PDO::PARAM_INT);
define("POKEMON_MOVE2_ID_TYPE", PDO::PARAM_INT);
define("POKEMON_MOVE3_ID_TYPE", PDO::PARAM_INT);
define("POKEMON_MOVE4_ID_TYPE", PDO::PARAM_INT);

/* Moves database columns Types */
define("MOVES_MOVE_ID_TYPE", PDO::PARAM_INT);
define("MOVES_MOVE_NAME_TYPE", PDO::PARAM_STR);
define("MOVES_ACCURACY_TYPE", PDO::PARAM_STR);
define("MOVES_PP_TYPE", PDO::PARAM_STR);
define("MOVES_POWER_TYPE", PDO::PARAM_STR);

?>