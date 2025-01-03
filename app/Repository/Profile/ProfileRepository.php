<?php

namespace App\Repository\Profile;

use App\DTOs\Profile\UpdateProfileDTO;
use App\Exceptions\Profile\ProfileException;
use App\Interfaces\Profile\ProfileActionsInterface;
use App\Models\Profile;

class ProfileRepository implements ProfileActionsInterface
{

    public function createProfile(array $data)
    {
        try {
            $profile = Profile::create($data);
            return $profile->profile_id;
        } catch (ProfileException $e) {
            throw new ProfileException('Error in profile creation, try again later... '.$e);
        }
    }

    public function deleteProfileById(Profile $profile)
    {
        return $profile->deleteOrFail();
    }

    public function getProfileById(string $profile_id)
    {
        return Profile::find($profile_id);
    }

    public function updateProfile(Profile $profile, array $data)
    {
        try {
            $profile->update($data);
            return $profile;
        } catch (ProfileException $e) {
            throw new ProfileException('Error in profile data update, try again later... '.$e);
        }
    }

    public function getProfileByUserId(string $user_id)
    {
        return Profile::where('user_id', $user_id)->first();
    }
}
