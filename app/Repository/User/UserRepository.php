<?php

namespace App\Repository\User;

use App\Interfaces\User\UserActionsInterface;
use App\Models\User;

class UserRepository implements UserActionsInterface
{

    public function getUserById(string $id)
    {
        return Post::findOrFail($id);
    }

    public function createUser(User $user)
    {
        try {
            $user->save();
        } catch (\Exception $e) {
            throw new \Exception('Error in user creation, try again later... '.$e);
        }
        return $user->post_id;

    }

    public function deleteUser(User $user)
    {
        return $user->deleteOrFail();
    }

    public function updateUserName(User $user)
    {
        try {
            $user->fill($user->toArray());
            $user->save();
        } catch (Exception $e) {
            throw new \Exception('Error in user data update, try again later... '.$e);
        }
        return $user->post_id;    }
}
