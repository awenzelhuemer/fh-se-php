<?php

namespace Application\Commands;

class EditProductCommand
{
    const Error_NotAuthenticated = 0x01; // 1
    const Error_InvalidName = 0x02; // 2
    const Error_InvalidProducer = 0x04; // 4

    public function __construct(
        private \Application\Services\AuthenticationService $authenticationService,
        private \Application\Interfaces\ProductRepository $productRepository
    ) {

    }

    public function execute(int $id, string $producer, string $name): int
    {
        $errors = 0;
        $name = trim($name);
        $producer = trim($producer);

        $userId = $this->authenticationService->getUserId();

        // check for authenticated user
        if($userId === null  || $this->productRepository->canEditProduct($id, $userId) == 0) {
            $errors |= self::Error_NotAuthenticated;
        }

        if(strlen($name) == 0) {
            $errors |= self::Error_InvalidName;
        }

        if(strlen($producer) == 0) {
            $errors |= self::Error_InvalidProducer;
        }

        if(!$errors) {
            $this->productRepository->editProduct($id, $producer, $name);
        }

        return $errors;
    }
}