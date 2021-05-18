<?php

namespace Presentation\Controllers;

use Presentation\MVC\Controller;
use Presentation\MVC\ViewResult;

class Home extends Controller {

    public function __construct() { }

    public function GET_Index(): ViewResult {
        return $this->view("home"
        // , [
        //     "user" => $this->signedInUserQuery->execute()
        // ]
    );
    }
}