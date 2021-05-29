<?php

namespace Presentation\Controllers;

use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Ratings extends Controller {

    public function __construct(
        private \Application\Commands\AddRatingCommand $addRatingCommand,
        private \Application\Commands\EditRatingCommand $editRatingCommand
    ) {
    }

    public function POST_Create(): ActionResult {
        $rating = $this->getParam("rt");
        $comment = $this->getParam("ct");
        $pid = $this->getParam("pid");

        // Trim comment
        $comment = trim($comment);
        $comment = $comment === "" ? null : $comment;

        $this->addRatingCommand->execute($pid, $rating, $comment);


        return $this->redirect("Products", "Detail", ["pid" => $pid]);
    }

    public function POST_Edit(): ActionResult {
        $rating = $this->getParam("rt");
        $comment = $this->getParam("ct");
        $rid = $this->getParam("rid");
        $pid = $this->getParam("pid");

        // Trim comment
        $comment = trim($comment);
        $comment = $comment === "" ? null : $comment;

        $this->editRatingCommand->execute($rid, $pid, $rating, $comment);


        return $this->redirect("Products", "Detail", ["pid" => $pid]);
    }
}