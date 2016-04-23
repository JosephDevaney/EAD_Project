<?php
/**
 * Created by PhpStorm.
 * User: Journeyman
 * Date: 23/04/2016
 * Time: 19:23
 */

class PokemonController {
    private $slimApp;
    private $model;
    private $requestBody;
    public function __construct($model, $action = null, $slimApp, $parameters = null) {
        $this->model = $model;
        $this->slimApp = $slimApp;
        $this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); // this must contain the representation of the new user

        if (! empty ( $parameters ["id"] ))
            $id = $parameters ["id"];

        switch ($action) {
            case ACTION_GET_POKEMON :
                $this->getPokemon ( $id );
                break;
            case ACTION_GET_POKEMON :
                $this->getAllPokemon ();
                break;
            case ACTION_UPDATE_POKEMON :
                $this->updatePokemon ( $id, $this->requestBody );
                break;
            case ACTION_CREATE_POKEMON :
                $this->createNewPokemon ( $this->requestBody );
                break;
            case ACTION_DELETE_POKEMON :
                $this->deletePokemon ( $id );
                break;
            case ACTION_SEARCH_POKEMON :
                $string = $parameters ["SearchingString"];
                $this->searchPokemon ( $string );
                break;
            case null :
                $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
                $Message = array (
                    GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR
                );
                $this->model->apiResponse = $Message;
                break;
        }
    }
    private function getAllPokemon() {
        $answer = $this->model->getAllPokemon();
        if ($answer != null) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
            $this->model->apiResponse = $answer;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }

    private function getPokemon($pokemonID) {
        $answer = $this->model->getPokemon ( $pokemonID );
        if ($answer != null) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
            $this->model->apiResponse = $answer;
        } else {

            $this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }

    private function createNewPokemon($newPokemon) {
        if ($newID = $this->model->createNewPokemon( $newPokemon )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_CREATED,
                "id" => "$newID"
            );
            $this->model->apiResponse = $Message;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY
            );
            $this->model->apiResponse = $Message;
        }
    }
    private function deletePokemon($pokemonId) {
        //TODO
        if ($newID = $this->model->deletePokemon ( $pokemonId )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK);
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_DELETED,
                "id" => "$pokemonId"
            );
            $this->model->apiResponse = $Message;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY
            );
            $this->model->apiResponse = $Message;
        }
    }

    private function updatePokemon($pokemonID, $parameters) {
        //TODO
        if ($pokemonID = $this->model->updatePokemon ( $pokemonID, $parameters )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_UPDATED,
                "id" => "$pokemonID"
            );
            $this->model->apiResponse = $Message;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOTMODIFIED_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }
    private function searchPokemon($string) {
        //TODO
        if ($pokemon = $this->model->searchPokemon ( $string )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );

            $this->model->apiResponse = $pokemon;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }
    
}