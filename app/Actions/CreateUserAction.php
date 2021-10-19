<?php

namespace App\Actions ;

use App\DataTransferObjects\UserData;
use App\Jobs\Customer\CustomerCreatedJob;
use App\Repositories\UserRepository;

class CreateUserAction
{
    public function __invoke(UserData $data)
    {
        $rawData = $data->except('avatar');

        $avatar = storeAvatar($data->avatar);

        $rawData['avatar'] = $avatar;

        $user = app(UserRepository::class)->create($rawData);

        // we can listen to model events "created" as well
        CustomerCreatedJob::dispatch($user->id);

        return $user;
    }
}
