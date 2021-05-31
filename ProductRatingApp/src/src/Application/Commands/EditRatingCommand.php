<?php

namespace Application\Commands;

use Application\Interfaces\RatingRepository;
use Application\Services\AuthenticationService;

class EditRatingCommand {

    const Error_NotAuthenticated = 0x01; // 1

    public function __construct(
        private AuthenticationService $authenticationService,
        private RatingRepository $ratingRepository
    ) { }

    public function execute(int $ratingId, int $productId, int $rating, ?string $comment): int
    {
        $userId = $this->authenticationService->getUserId();
        $errors = 0;

        $comment = trim($comment);
        $comment = $comment === "" ? null : $comment;

        // check for authenticated user
        if($userId === null || $this->ratingRepository->canEditRating($ratingId, $userId) == 0) {
            $errors |= self::Error_NotAuthenticated;
        }

        if(!$errors) {
            // try to edit rating
            $this->ratingRepository->editRating(
                $ratingId,
                $productId,
                $rating,
                $comment
            );
        }

        return $errors;
    }
}
