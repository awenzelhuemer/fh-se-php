<?php

namespace Application\Commands;

use Application\Interfaces\UserRepository;

class RegisterCommand
{

    const Error_UsernameAlreadyExists = 0x01; // 1
    const Error_CreateUserFailed = 0x02; // 2

    public function __construct(
        private UserRepository $userRepository
    ) { }

    public function execute(string $username, string $password): int
    {
        $errors = 0;
        $username = trim($username);

        if($this->userRepository->getUserForUserName($username) !== null) {
            $errors |= self::Error_UsernameAlreadyExists;
        } else {
            $userId = $this->userRepository->createUser($username, $password);
            if($userId === null) {
                $errors |= self::Error_CreateUserFailed;
            }
        }

        return $errors;
    }
}
