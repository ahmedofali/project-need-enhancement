<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        $token = $this->resource->createToken('auth-token');

        return [
            'auth_token' => $token->plainTextToken,
            'user'       => [
                'name'  => $this->name,
                'email' => $this->email,
                'image' => Storage::get($this->image),
            ]
        ];
    }
}
