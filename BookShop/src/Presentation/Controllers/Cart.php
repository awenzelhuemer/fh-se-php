<?php

namespace Presentation\Controllers;

use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Cart extends Controller {

    public function __construct(
        private \Application\AddBookToCartCommand $addBookToCartCommand,
        private \Application\RemoveBookFromCartCommand $removeBookFromCartCommand
    )
    { }

    public function POST_Add(): ActionResult {
        $this->addBookToCartCommand->execute($this->getParam("bid"));
        return $this->redirectToUri($this->getParam("ctx"));
    }

    public function POST_Remove(): ActionResult {
        $this->removeBookFromCartCommand->execute($this->getParam("bid"));
        return $this->redirectToUri($this->getParam("ctx"));
    }
}