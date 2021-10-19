<?php

namespace App\DataTransferObjects;

use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    public ?string $name;

    public ?array $email;

    public int $password;

    public UploadedFile $avatar;
}
