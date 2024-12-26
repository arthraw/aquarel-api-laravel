<?php

namespace App\Repository\User;

use App\Interfaces\User\UserActionsInterface;
use App\Models\User;
use Exception;

class UserRepository implements UserActionsInterface
{

    public function getUserById(string $id)
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data)
    {
        try {
            $user = User::create($data);
            return $user->user_id;
        } catch (Exception $e) {
            throw new Exception('Error in user creation, try again later... '.$e);
        }

    }

    public function deleteUser(User $user)
    {
        return $user->deleteOrFail();
    }

    public function updateUser(User $user, array $data)
    {
        try {
            $user->update($data);
            return $user;
        } catch (Exception $e) {
            throw new Exception('Error in user data update, try again later... '.$e);
        }
    }

    public function getUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
