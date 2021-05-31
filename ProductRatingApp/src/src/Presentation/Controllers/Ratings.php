<?php

namespace Presentation\Controllers;

use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Ratings extends Controller {

    public function __construct(
        private \Application\Commands\AddRatingCommand $addRatingCommand,
        private \Application\Commands\EditRatingCommand $editRatingCommand,
        private \Application\Commands\RemoveRatingCommand $removeRatingCommand,
        private \Application\Queries\ProductDetailQuery $productDetailQuery,
        private \Application\Queries\SignedInUserQuery $signedInUserQuery,
    ) {
    }

    public function POST_Create(): ActionResult {
        $rating = $this->getParam("rt");
        $comment = $this->getParam("ct");
        $pid = $this->getParam("pid");

        $result = $this->addRatingCommand->execute($pid, $rating, $comment);

        if($result != 0) {
            $errors = [];
            if($result & \Application\Commands\AddRatingCommand::Error_NotAuthenticated) {
                $errors[] = "Rating can only be added when user is signed in.";
            }

            if($result & \Application\Commands\AddRatingCommand::Error_CreateRatingFailed) {
                $errors[] = "Creating of rating failed.";
            }

            return $this->view(
                "productDetail", [
                "user" => $this->signedInUserQuery->execute(),
                "product" => $this->productDetailQuery->execute($pid),
                "errors" => $errors
            ]);
        }

        return $this->redirect("Products", "Detail", ["pid" => $pid]);
    }

    public function POST_Edit(): ActionResult {
        $rating = $this->getParam("rt");
        $comment = $this->getParam("ct");
        $rid = $this->getParam("rid");
        $pid = $this->getParam("pid");

        $result = $this->editRatingCommand->execute($rid, $pid, $rating, $comment);
        if($result != 0) {
            $errors = [];
            if($result & \Application\Commands\EditRatingCommand::Error_NotAuthenticated) {
                $errors[] = "Rating can only be update when user is signed in.";
            }

            return $this->view(
                "productDetail", [
                     "user" => $this->signedInUserQuery->execute(),
                     "product" => $this->productDetailQuery->execute($pid),
                     "errors" => $errors
                ]);
        }

        return $this->redirect("Products", "Detail", ["pid" => $pid]);
    }

    public function POST_Remove(): ActionResult {
        $rid = $this->getParam("rid");
        $pid = $this->getParam("pid");

        $result = $this->removeRatingCommand->execute($rid);
        if($result != 0) {
            $errors = [];
            if($result & \Application\Commands\EditRatingCommand::Error_NotAuthenticated) {
                $errors[] = "Rating can only be removed when user is signed in.";
            }

            return $this->view(
                "productDetail", [
                "user" => $this->signedInUserQuery->execute(),
                "product" => $this->productDetailQuery->execute($pid),
                "errors" => $errors
            ]);
        }

        return $this->redirect("Products", "Detail", ["pid" => $pid]);
    }
}