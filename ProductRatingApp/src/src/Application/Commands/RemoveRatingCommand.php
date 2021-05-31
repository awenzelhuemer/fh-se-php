<?php

namespace Application\Commands;

use Application\Interfaces\RatingRepository;
use Application\Services\AuthenticationService;

class RemoveRatingCommand
{
    const Error_NotAuthenticated = 0x01; // 1

    public function __construct(
        private AuthenticationService $authenticationService,
        private RatingRepository $ratingRepository
    ) { }

    public function execute(int $ratingId): int
    {
        $userId = $this->authenticationService->getUserId();
        $errors = 0;

        // check for authenticated user
        if($userId === null || !$this->ratingRepository->canEditRating($ratingId, $userId)) {
            $errors |= self::Error_NotAuthenticated;
        }

        if(!$errors) {
            // try to remove rating
            $this->ratingRepository->removeRating($ratingId);
        }

        return $errors;
    }
}