<?php

namespace Presentation\Controllers;

use Application\Queries\SignedInUserQuery;
use Presentation\MVC\Controller;
use Presentation\MVC\ViewResult;

class Error404 extends Controller
{

    public function __construct(
        private SignedInUserQuery $signedInUserQuery
    )
    {
    }

    public function GET_Index(): ViewResult
    {
        return $this->view("404",
            [
                "user" => $this->signedInUserQuery->execute()
            ]
        );
    }
}