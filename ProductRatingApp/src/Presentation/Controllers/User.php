<?php

namespace Presentation\Controllers;

use Presentation\MVC\ViewResult;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class User extends Controller {
    public function __construct(
        private \Application\Commands\SignInCommand $signInCommand,
        private \Application\Commands\SignOutCommand $signOutCommand,
        private \Application\Queries\SignedInUserQuery $signedInUserQuery,
        private \Application\Commands\RegisterCommand $registerCommand
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

        return $this->redirect("Home", "Index");
    }

    public function POST_LogOut(): ActionResult {
        $this->signOutCommand->execute();
        return $this->redirect("Home", "Index");
    }

    public function GET_Register() : ActionResult {
        // only show register view when there is no authenticated user
        $user = $this->signedInUserQuery->execute();
        if($user != null) {
            return $this->redirect("Home", "Index");
        }
        return $this->view("register", [
            "userName" => "",
            "password" => "",
            "user" => null
        ]);
    }

    public function POST_Register(): ActionResult {
        $userName = $this->getParam("un");
        $password = $this->getParam("pwd");
        $result = $this->registerCommand->execute(
            $userName,
            $password
        );

        // Check for errors
        if($result != 0) {
            $errors = [];
            if($result & \Application\Commands\RegisterCommand::Error_UsernameAlreadyExists) {
                $errors[] = "User with username already exists.";
            }
            if($result & \Application\Commands\RegisterCommand::Error_CreateUserFailed) {
                $errors[] = "User creation failed.";
            }

            if(sizeof($errors) == 0) {
                $errors[] = "Something went wrong.";
            }

            return $this->view("register", [
                "userName" => $userName,
                "password" => $password,
                "user" => null,
                "errors" => $errors
            ]);
        }

        //sign in if successful
        $ok = $this->signInCommand->execute($userName, $password);

        if(!$ok) {
            return $this->view("register", [
                "userName" => $userName,
                "password" => $password,
                "user" => null,
                "errors" => ["Sign in after registration was unsuccessful!"]
            ]);
        }

//        return $this->view("register");
        return $this->redirect("Home", "Index");
    }
}