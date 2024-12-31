<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\User\UserAuthDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Repository\Profile\ProfileRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected UserRepository $repository;
    protected ProfileRepository $profile;

    public function __construct(UserRepository $repository, ProfileRepository $profile)
    {
        $this->repository = $repository;
        $this->profile = $profile;
    }

    public function login(LoginUserRequest $request)
    {
        try{
            $userData = UserAuthDTO::fromLoginRequest($request->validated());
            $email = $userData->email;
            $user = $this->repository->getUserByEmail($email);
            if (is_null($user)) {
                return response()->json([
                    'message' => 'No users found with provided email'
                ], 404);
            }
            if (Hash::check($userData->password, $user->password)) {
                $profile = $this->profile->getProfileByUserId($user->user_id);
                return response()->json([
                    'token' => 'teste', // alterar pra gerar token
                    'profile_id' => $profile->profile_id,
                ], 200);

            } else {
                return response()->json([
                    'message' => 'Failed to auth user with provided credentials',
                ], 404);
            }
        } catch (\Exception $e) {
            Log::critical($e->getMessage());
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

}


