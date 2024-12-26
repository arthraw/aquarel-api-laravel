<?php

namespace App\Interfaces\Profile;

use App\DTOs\Profile\UpdateProfileDTO;
use App\Models\Profile;

interface ProfileActionsInterface
{
    public function createProfile(array $data);

    public function getProfileByUserId(string $user_id);

    public function deleteProfileById(Profile $profile);

    public function getProfileById(string $profile_id);

    public function updateProfile(Profile $profile, array $data);
}
