<?php

namespace App\Interfaces\User;

use App\Models\User;

interface UserActionsInterface
{
    public function getUserById(string $id);
    public function createUser(User $user);
    public function deleteUser(User $user);
    public function updateUserName(User $user);
}
