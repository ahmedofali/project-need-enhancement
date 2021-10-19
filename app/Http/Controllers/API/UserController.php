<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateUserAction;
use App\DataTransferObjects\UserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class UserController extends Controller
{

    public function signup(SignUpRequest $request)
    {
        $data = new UserData($request->all());

        $user = (new CreateUserAction())($data);

        return UserResource::make($user);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => __('lang.invalid_credientials'),
            ]);
        }

        return response()->json([
            'auth_token' =>  $user->createToken('auth-token')->plainTextToken
        ]);
    }


    public function follow(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                Rule::in(User::pluck('id'))
            ]
        ]);

        $currentUser = $request->user();
        $followingUser = User::find($request->user_id);

        $followings = $currentUser->followings();
        if ($followings->where('follower_id', $currentUser->id)->where('user_id', $request->user_id)->exists()) {
            return response()->json([
                'message' => __('lang.followed_already', ['name' => $followingUser->name])
            ],404);
        }

        $followings->attach($followingUser);

        return response()->json([
            'message' =>  __('lang.followed_successfully', ['name' => $followingUser->name])
        ]);
    }
}
