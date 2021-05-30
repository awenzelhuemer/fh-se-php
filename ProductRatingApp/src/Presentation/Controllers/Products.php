<?php

namespace Presentation\Controllers;

use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;
use Presentation\MVC\ViewResult;

class Products extends Controller {

    public function __construct(
        private \Application\Queries\ProductsQuery $productsQuery,
        private \Application\Queries\ProductQuery $productQuery,
        private \Application\Queries\ProductDetailQuery $productDetailQuery,
        private \Application\Commands\AddProductCommand $addProductCommand,
        private \Application\Commands\EditProductCommand $editProductCommand,
        private \Application\Queries\SignedInUserQuery $signedInUserQuery
    ) {
    }

    public function GET_Index(): ViewResult
    {
        $filter = $this->tryGetParam('f', $filter) ? trim($filter) : null;

        return $this->view("productList",
            [
                "user" => $this->signedInUserQuery->execute(),
                "products" => $this->productsQuery->execute($filter),
                "filter" => $filter,
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

    public function GET_Create(): ViewResult {
        return $this->view("newProduct", [
            "user" => $this->signedInUserQuery->execute()
        ]);
    }

    public function Post_Create(): ActionResult {

        $name = $this->getParam("nm");
        $producer = $this->getParam("pd");

        $result = $this->addProductCommand->execute($producer, $name);

        if($result != 0) {
            $errors = [];
            if($result & \Application\Commands\AddProductCommand::Error_NotAuthenticated) {
                $errors[] = "Product can only be added when user is signed in.";
            }

            if($result & \Application\Commands\AddProductCommand::Error_InvalidName) {
                $errors[] = "Invalid product name.";
            }

            if($result & \Application\Commands\AddProductCommand::Error_InvalidProducer) {
                $errors[] = "Invalid brand name.";
            }

            if($result & \Application\Commands\AddProductCommand::Error_CreateProductFailed) {
                $errors[] = "Creating of product failed.";
            }

            return $this->view(
                "newProduct", [
                "user" => $this->signedInUserQuery->execute(),
                "errors" => $errors
            ]);
        }

        return $this->redirect("Products", "Index");
    }

    public function GET_Edit(): ViewResult {

        // check for valid id

        $errors = [];
        $product = null;
        if(!$this->tryGetParam("pid", $idParam)) {
            $errors[] = "Product could not be found!";
        } else {

            $id = intval($idParam);
            if(intval($idParam) != 0) {
                $product = $this->productQuery->execute($id);
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
            return $this->view("editProduct",
                [
                    "user" => $this->signedInUserQuery->execute(),
                    "product" => $product
                ]);
        }
    }

    public function Post_Edit(): ActionResult {

        $productId = $this->getParam("pid");
        $name = $this->getParam("nm");
        $producer = $this->getParam("pd");

        $result = $this->editProductCommand->execute($productId, $producer, $name);

        if($result != 0) {
            $errors = [];
            if($result & \Application\Commands\EditProductCommand::Error_NotAuthenticated) {
                $errors[] = "Product can only be updated when user is signed in.";
            }

            if($result & \Application\Commands\EditProductCommand::Error_InvalidName) {
                $errors[] = "Invalid product name.";
            }

            if($result & \Application\Commands\EditProductCommand::Error_InvalidProducer) {
                $errors[] = "Invalid brand name.";
            }

            return $this->view(
                "editProduct", [
                "user" => $this->signedInUserQuery->execute(),
                "product" => $this->productQuery->execute($productId),
                "errors" => $errors
            ]);
        }

        return $this->redirect("Products", "Index");
    }
}