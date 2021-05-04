<?php

namespace Presentation\Controllers;

use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Order extends Controller {
    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\CartSizeQuery $cartSizeQuery,
        private \Application\CheckOutCommand $checkOutCommand
    ) {

    }

    public function GET_Create(): ActionResult {

        $user = $this->signedInUserQuery->execute();
        // show login when no user is logged in (for convenience only)
        if($user === null) {
            return $this->redirect("User", "LogIn");
        }

        $cartSize = $this->cartSizeQuery->execute();

        if($cartSize == 0) {
            return $this->view("orderFormEmptyCart", [
                "user" => $user
            ]);
        }

        return $this->view("orderForm", [
            "user" => $user,
            "cartSize" => $cartSize,
            "nameOnCard" => "",
            "cardNumber" => ""
            // TODO
        ]);
    }

    public function POST_Create(): ActionResult {
        $ccName = $this->getParam("noc");
        $ccNumber = $this->getParam("cn");
        $result = $this->checkOutCommand->execute($ccName, $ccNumber, $orderId);
        
        if($result != 0) {
            $errors = [];
            if($result & \Application\CheckOutCommand::Error_InvalidCreditCartName) {
                $errors[] = "Invalid name on card.";
            }
            if($result & \Application\CheckOutCommand::Error_InvalidCreditCartNumber) {
                $errors[] = "Invalid card number.";
            }
            // TODO handle different errors --> fill errors array

            if(sizeof($errors) == 0) {
                $errors[] = "Something went wrong.";
            }

            return $this->view("orderForm", [
                "user" => $this->signedInUserQuery->execute(),
                "cartSize" => $this->cartSizeQuery->execute(),
                "nameOnCard" => $ccName,
                "cardNumber" => $ccNumber,
                "errors" => $errors
            ]);
        } else {
            // redirect to order summary page on success
            return $this->redirect("Order", "ShowSummary", ["oid" => $orderId]);
        }
    }

    public function GET_ShowSummary(): ActionResult {
        return $this->view("orderSummary", [
            "user" => $this->signedInUserQuery->execute(),
            "orderId" => $this->getParam("oid")
        ]);
    }
}