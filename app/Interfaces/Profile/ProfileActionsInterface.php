<?php

namespace App\Interfaces\Profile;

use App\DTOs\Profile\UpdateProfileDTO;
use App\Models\Profile;

interface ProfileActionsInterface
{
    public function createProfile(Profile $profile);

    public function deleteProfileById(string $profile_id);

    public function getProfileById(string $profile_id);

    public function updateProfile(UpdateProfileDTO $data);
}
