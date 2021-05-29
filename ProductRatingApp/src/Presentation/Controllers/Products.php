<?php

namespace Presentation\Controllers;

use Presentation\MVC\Controller;
use Presentation\MVC\ViewResult;

class Products extends Controller {

    public function __construct(
        private \Application\Queries\ProductsQuery $productsQuery,
        private \Application\Queries\SignedInUserQuery $signedInUserQuery
    ) {
    }

    public function GET_Index(): ViewResult
    {
        return $this->view("productList",
            [
                "user" => $this->signedInUserQuery->execute(),
                "products" => $this->productsQuery->execute()
            ]);
    }

}