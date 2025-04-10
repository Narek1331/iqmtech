<?php

namespace App\Repositories;
use App\Models\Data;
class DataRepository
{
    public function store(array $data)
    {
        return Data::create($data);
    }
}
