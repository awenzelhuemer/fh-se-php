<?php

namespace Presentation\Controllers;

use Presentation\MVC\ViewResult;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class User extends Controller {
    public function __construct(
        private \Application\Commands\SignInCommand $signInCommand,
        private \Application\Commands\SignOutCommand $signOutCommand,
        private \Application\Queries\SignedInUserQuery $signedInUserQuery
    ) {

    }

    public function GET_LogIn() : ActionResult {
        // only show login view when there is no authenticated user

        $user = $this->signedInUserQuery->execute();
        if($user != null) {
            return $this->redirect("Home", "Index");
        }
        return $this->view("login", [
            "userName" => "",
            "user" => $user
        ]);
    }

    public function POST_LogIn(): ActionResult {
        $ok = $this->signInCommand->execute(
            $this->getParam("un"),
            $this->getParam("pwd"));

        if(!$ok) {
            return $this->view("login", [
                "user" => $this->signedInUserQuery->execute(),
                "userName" => $this->getParam("un"),
                "errors" => ["Invalid user name or password."]
            ]);
        }

        return $this->redirect("Home", "Index"); // TODO: make this nicer
    }

    public function POST_LogOut(): ActionResult {
        $this->signOutCommand->execute();
        return $this->redirect("Home", "Index");
    }
}