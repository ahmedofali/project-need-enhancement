<?php

namespace App\Repositories;

use App\DataTransferObjects\UserData;
use App\Models\User;

class UserRepository
{
    public function create(UserData $data)
    {
        return User::create($data);
    }
}
