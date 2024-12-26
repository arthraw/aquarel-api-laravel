<?php

namespace App\Http\Controllers\User;

use App\DTOs\Profile\ProfileDTO;
use App\DTOs\User\UserDTO;
use App\Exceptions\User\UserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
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
        if (!array_key_exists('password', (array)$userData) | !array_key_exists('username', (array)$userData) | !array_key_exists('email', (array)$userData)) {
            return response()->json([
                'message' => UserException::missingUserData()->getMessage()
            ], 400);
        }
        $user = [
            'username' => $userData->username,
            'email' => $userData->email,
            'password' => $userData->password
        ];
        $userExists = $this->userRepository->getUserByEmail($user['email']);
        if (!is_null($userExists)) {
            return response()->json([
                'message' => UserException::userAlreadyExists()->getMessage()
            ], 400);
        }
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
        } catch (UserException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

}
