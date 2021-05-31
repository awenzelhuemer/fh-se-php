<?php

namespace Application\Commands;

use Application\Interfaces\UserRepository;
use Application\Services\AuthenticationService;

class SignInCommand
{
    public function __construct(
        private AuthenticationService $authenticationService,
        private UserRepository $userRepository
        ) {
    }

    public function execute(string $username, string $password): bool
    {
        $this->authenticationService->signOut();
        $user = $this->userRepository->getUserForUserNameAndPassword($username, $password);
        if($user != null) {
            $this->authenticationService->signIn($user->getId());
            return true;
        }

        return false;
    }
}
