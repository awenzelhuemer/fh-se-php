<?php

namespace Presentation\Controllers;

use Presentation\MVC\Controller;
use Presentation\MVC\ViewResult;

class Products extends Controller {

    public function __construct(
        private \Application\Queries\ProductsQuery $productsQuery,
        private \Application\Queries\ProductDetailQuery $productDetailQuery,
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

    public function GET_Detail(): ViewResult
    {
        $errors = [];
        $product = null;
        $idParam = "";
        if(!$this->tryGetParam("pid", $idParam)) {
            $errors[] = "Product could not be found!";
        } else {

            $id = intval($idParam);
            if(intval($idParam) != 0) {
                $product = $this->productDetailQuery->execute($id);
            }

            if($product === null) {
                $errors[] = "Product could not be found!";
            }
        }

        if(sizeof($errors) > 0) {
            // TODO maybe redirect to 404 page or index
            return $this->view("productDetail",
                [
                    "user" => $this->signedInUserQuery->execute(),
                    "product" => $product,
                    "errors" => $errors
                ]);
        } else {
            return $this->view("productDetail",
                [
                    "user" => $this->signedInUserQuery->execute(),
                    "product" => $product
                ]);
        }
    }
}