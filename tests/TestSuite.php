<?php
require_once ("../SimpleTest/autorun.php");
class RequestTestSuite extends TestSuite {
    function __construct() {
        parent::__construct ();
        $this->addFile ( "MoveRequestTests.php" );
        $this->addFile ( "PokemonRequestTests.php" );
        $this->addFile ( "UserRequestTests.php" );
        $this->addFile ( "ValidationTests.php" );

    }
}

