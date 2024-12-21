<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Repository\User\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function addUser(CreateUserRequest $request)
    {
        $userData = UserDTO::fromRequest($request->validated());
        $user = new User();
        $userCreate = $user->fill((array)$userData);
        try {
            $this->userRepository->createUser($userCreate);
            return response()->json([
                'message' => 'Usuário criado com sucesso.',
                'user_id' => $userCreate->user_id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao tentar criar o usuário, verifique os dados passados.'
            ], 400);
        }
    }
}
