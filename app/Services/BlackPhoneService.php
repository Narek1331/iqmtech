<?php

namespace App\Services;

use App\Repositories\BlackPhoneRepository;

class BlackPhoneService
{
    protected $blackPhoneRepository;

    /**
     * BlackPhoneService constructor.
     *
     * @param BlackPhoneRepository $blackPhoneRepository
     */
    public function __construct(BlackPhoneRepository $blackPhoneRepository)
    {
        $this->blackPhoneRepository = $blackPhoneRepository;
    }

    /**
     * Get all BlackPhones by user_id.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllByUserId(int $userId)
    {
        return $this->blackPhoneRepository->getAllByUserId($userId);
    }

    /**
     * Find a BlackPhone by user_id and phone.
     *
     * @param int $userId
     * @param string $phone
     * @return \App\Models\BlackPhone|null
     */
    public function findByUserIdAndPhone(int $userId, string $phone)
    {
        return $this->blackPhoneRepository->findByUserIdAndPhone($userId, $phone);
    }
}
