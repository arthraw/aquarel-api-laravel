<?php

namespace App\Repository\Profile;

use App\DTOs\Profile\UpdateProfileDTO;
use App\Interfaces\Profile\ProfileActionsInterface;
use App\Models\Profile;

class ProfileRepository implements ProfileActionsInterface
{

    public function createProfile(Profile $profile)
    {
        // TODO: Implement createProfile() method.
    }

    public function deleteProfileById(string $profile_id)
    {
        // TODO: Implement deleteProfileById() method.
    }

    public function getProfileById(string $profile_id)
    {
        // TODO: Implement getProfileById() method.
    }

    public function updateProfile(UpdateProfileDTO $data)
    {
        // TODO: Implement updateProfile() method.
    }
}
