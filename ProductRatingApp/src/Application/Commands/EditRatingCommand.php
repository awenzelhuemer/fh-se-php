<?php

namespace Application\Commands;

use Application\Interfaces\RatingRepository;
use Application\Services\AuthenticationService;

class EditRatingCommand {

    const Error_NotAuthenticated = 0x01; // 1
    const Error_EditRatingFailed = 0x2; // 2

    public function __construct(
        private AuthenticationService $authenticationService,
        private RatingRepository $ratingRepository
    ) { }

    public function execute(int $ratingId, int $productId, int $rating, ?string $comment): int
    {
        $userId = $this->authenticationService->getUserId();
        $errors = 0;

        // check for authenticated user
        if($userId === null) {
            $errors |= self::Error_NotAuthenticated;
        }

        if(!$errors) {
            // try to create new rating
            $this->ratingRepository->editRating(
                $ratingId,
                $userId,
                $productId,
                $rating,
                $comment
            );
        }

        return $errors;
    }
}
