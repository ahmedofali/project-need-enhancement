<?php

use Illuminate\Http\UploadedFile;

if (!function_exists('storeAvatar')) {
    /**
     *
     * @param UploadedFile $image
     * @return string
     */
    function storeAvatar(UploadedFile $image): string
    {
        return $image->store('avatars');
    }
}
