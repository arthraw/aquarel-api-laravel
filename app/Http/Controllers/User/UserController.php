<?php

namespace App\Http\Controllers\User;

use App\DTOs\Profile\ProfileDTO;
use App\DTOs\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Repository\Profile\ProfileRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected UserRepository $userRepository;
    protected ProfileRepository $profile;

    public function __construct(UserRepository $userRepository, ProfileRepository $profile)
    {
        $this->userRepository = $userRepository;
        $this->profile = $profile;
    }

    public function addUser(CreateUserRequest $request)
    {
        $userData = UserDTO::fromRequest($request->validated());
        $user = [
            'username' => $userData->username,
            'email' => $userData->email,
            'password' => $userData->password
        ];
        $user['password'] = Hash::make($user['password']);
        try {
            $user_id = $this->userRepository->createUser($user);
            $profileData = [
                'user_id' => $user_id,
                'name' => $user['username']
            ];
            $userDataProfile = ProfileDTO::fromRequest($profileData);
            $profile = [
                'user_id' => $userDataProfile->user_id,
                'name' => $userDataProfile->name
            ];
            $profile_id = $this->profile->createProfile($profile);

            return response()->json([
                'message' => 'Usuário criado com sucesso.',
                'profile_id' => $profile_id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao tentar criar o usuário, verifique os dados passados.'
            ], 400);
        }
    }

}
