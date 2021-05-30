<?php

namespace Application\Commands;

use Application\Interfaces\RatingRepository;
use Application\Services\AuthenticationService;

class AddRatingCommand {

    const Error_NotAuthenticated = 0x01; // 1
    const Error_CreateRatingFailed = 0x2; // 2

    public function __construct(
        private AuthenticationService $authenticationService,
        private RatingRepository $ratingRepository
    ) { }

    public function execute(int $productId, int $rating, ?string $comment): int
    {
        $userId = $this->authenticationService->getUserId();
        $errors = 0;

        $comment = trim($comment);
        $comment = $comment === "" ? null : $comment;

        // check for authenticated user
        if($userId === null) {
            $errors |= self::Error_NotAuthenticated;
        }

        if(!$errors) {
            // try to create new rating
            $ratingId = $this->ratingRepository->addRating(
                $userId,
                $productId,
                $rating,
                $comment
            );

            if($ratingId === null) {
                $errors |= self::Error_CreateRatingFailed;
            }
        }

        return $errors;
    }
}
