<?php
namespace Application;

class CheckOutCommand {

    const Error_NotAuthenticated = 0x01; // 1
    const Error_CartEmpty = 0x02; // 2
    const Error_InvalidCreditCartName = 0x04; // 4
    const Error_InvalidCreditCartNumber = 0x08; // 8
    const Error_CreateOrderFailed = 0x10; // 16

    public function __construct(
        private \Application\Services\AuthenticationService $authenticationService,
        private \Application\Services\CartService $cartService,
        private \Application\Interfaces\OrderRepository $orderRepository
    ) {

    }

    public function execute(string $creditCardName, string $creditCardNumber, ?int &$orderId): int {
        
        $errors = 0;
        $creditCardName = trim($creditCardName);
        $creditCardNumber = str_replace(" ", "", $creditCardNumber);

        $userId = $this->authenticationService->getUserId();
        
        // check for authenticated user
        if($userId === null) {
            $errors |= self::Error_NotAuthenticated;
        }

        $cart = $this->cartService->getBooksWithCount();

        // check for items in cart 
        if(sizeof($cart) == 0) {
            $errors |= self::Error_CartEmpty;
        }

        // check data
        if(strlen($creditCardName) == 0) {
            $errors |= self::Error_InvalidCreditCartName;
        }

        if(strlen($creditCardNumber) != 16 | !ctype_digit(($creditCardNumber))) {
            $errors |= self::Error_InvalidCreditCartNumber;
        }
        
        if(!$errors) {
            // try to create new order
            $orderId = $this->orderRepository->createOrder($userId, $cart, $creditCardName, $creditCardNumber);
            if($orderId === null) {
                $errors |= self::Error_CreateOrderFailed;
            } else {
                // clear cart on success
                $this->cartService->clear();
            }
        }

        return $errors;
    }
}