<?php

namespace App\Http\Controllers\Profile;

use App\DTOs\Profile\UpdateProfileDTO;
use App\Exceptions\Profile\ProfileException;
use App\Exceptions\User\UserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Repository\Profile\ProfileRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class ProfileController extends Controller
{

    protected ProfileRepository $profile;

    protected UserRepository $user;

    public function __construct(ProfileRepository $profile, UserRepository $user)
    {
        $this->profile = $profile;
        $this->user = $user;
    }

    public function updateUserProfile(UpdateUserRequest $request)
    {
        $profileRequest = UpdateProfileDTO::fromUpdateRequest($request->validated());
        $profile = $this->profile->getProfileById($profileRequest->profile_id);
        if (is_null($profile)) {
            return response()->json([
                'message' => 'The profile_id provided not exists'
            ], 404);
        }
        $user = $profile->user;
        if (array_key_exists('email',(array)$profileRequest) | array_key_exists('password', (array)$profileRequest)) {
            try {
                $this->updateUserData($user, $profileRequest);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Not possible update user data'
                ],404);
            }
        }

        $profileAttributes = [
            'name' => $profileRequest->name ?? null,
            'bio' => $profileRequest->bio ?? null,
            'banner_url' => $profileRequest->banner_url ?? null,
            'avatar_url' => $profileRequest->avatar_url ?? null,
            'instagram_profile_url' => $profileRequest->instagram_profile_url ?? null,
            'behance_profile_url' => $profileRequest->behance_profile_url ?? null,
            'category' => $profileRequest->category ?? null,
        ];
        $filteredAttributes = array_filter($profileAttributes, function ($value) {
            return !is_null($value);
        });
        try {
            if (empty($filteredAttributes) & !array_key_exists('email', (array)$profileRequest) | !array_key_exists('password', (array)$profileRequest)) {
                return response()->json([
                    'message' => ProfileException::notPossibleUpdateProfileData()->getMessage(),
                ],400);
            }
            $profileUpdated = $this->profile->updateProfile($profile, $filteredAttributes);
            return response()->json([
                'message' => 'User updated successfully',
                'profile_id' => $profileUpdated->profile_id
            ],200);
        } catch (ProfileException $e) {
            return response()->json([
                'message' => ProfileException::notPossibleUpdateProfileData()->getMessage(),
            ],400);
        }
    }

    private function updateUserData(User $user, UpdateProfileDTO $profileDTO)
    {
        $userAttributes = [
            'email' => $profileDTO->email ?? null,
            'password' => $profileDTO->password ?? null,
            'password_check' => $profileDTO->password_check ?? null
        ];
        $filteredAttributes = array_filter($userAttributes, function ($value) {
            return !is_null($value);
        });
        if (array_key_exists('password', $filteredAttributes)) {
            try {
                if (!Hash::check($filteredAttributes['password_check'], $user->password)) {
                    return response()->json([
                        'message' => 'Wrong password provided.'
                    ], 400);
                }
            } catch (\Exception $e) {
                throw new UserException('password_check not provided');
            }

        }

        $this->user->updateUser($user, $filteredAttributes);

    }

}
