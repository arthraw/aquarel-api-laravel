<?php

namespace App\Interfaces\User;

use App\Models\User;

interface UserActionsInterface
{
    public function getUserById(string $id);
    public function getUserByEmail(string $email);
    public function createUser(array $data);
    public function deleteUser(User $user);
    public function updateUser(User $user, array $data);
}
