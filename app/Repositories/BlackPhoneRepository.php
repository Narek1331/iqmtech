<?php

namespace App\Repositories;

use App\Models\BlackPhone;

class BlackPhoneRepository
{
    /**
     * Get all BlackPhones by user_id.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllByUserId(int $userId)
    {
        return BlackPhone::where('user_id', $userId)->get();
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
        return BlackPhone::where('user_id', $userId)->where('phone', $phone)->first();
    }
}
