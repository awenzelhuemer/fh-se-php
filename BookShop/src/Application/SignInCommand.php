<?php

namespace Application;

class SignInCommand
{
    public function __construct(
        private \Application\Services\AuthenticationService $authenticationService,
        private \Application\Interfaces\UserRepository $userRepository
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
