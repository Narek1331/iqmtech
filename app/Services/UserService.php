<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    protected $userRepository;

    /**
     * Inject the UserRepository.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User
     */
    public function findById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
