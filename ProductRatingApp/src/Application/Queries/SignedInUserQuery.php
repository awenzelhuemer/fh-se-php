<?php

namespace Application\Queries;

use Application\Interfaces\UserRepository;
use Application\Services\AuthenticationService;
use Application\Models\UserData;

class SignedInUserQuery
{
    public function __construct(
        private AuthenticationService $authenticationService,
        private UserRepository $userRepository
    ) {
    }
    
    public function execute(): ?UserData
    {
        $id = $this->authenticationService->getUserId();
        if ($id === null) {
          return null;
        }
        $user = $this->userRepository->getUser($id);
        if ($user === null) {
            return null;
        }
        return new UserData($user->getId(), $user->getUserName());
    }
}
