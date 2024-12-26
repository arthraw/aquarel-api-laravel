<?php

namespace App\DTOs\Profile;

class UpdateProfileDTO
{
    public string $profile_id;

    public ?string $email;

    public ?string $password;

    public ?string $password_check;

    public ?string $bio;

    public ?string $name;

    public ?string $avatar_url;

    public ?string $banner_url;

    public ?string $instagram_profile_url;

    public ?string $behance_profile_url;

    public ?string $category;

    public function __construct($profile_id, $email, $password, $password_check, $bio, $name, $avatar_url, $banner_url, $behance_profile_url, $instagram_profile_url, $category)
    {
        $this->profile_id = $profile_id;
        $this->email = $email;
        $this->password = $password;
        $this->password_check = $password_check;
        $this->name = $name;
        $this->bio = $bio;
        $this->avatar_url = $avatar_url;
        $this->banner_url = $banner_url;
        $this->instagram_profile_url = $instagram_profile_url;
        $this->behance_profile_url = $behance_profile_url;
        $this->category = $category;
    }

    public static function fromUpdateRequest(array $data): self
    {
        return new self(
            $data['profile_id'],
            $data['email'] ?? null,
            $data['password'] ?? null,
            $data['password_check'] ?? null,
            $data['bio'] ?? null,
            $data['name'] ?? null,
            $data['avatar_url'] ?? null,
            $data['banner_url'] ?? null,
            $data['behance_profile_url'] ?? null,
            $data['instagram_profile_url'] ?? null,
            $data['category'] ?? null
        );
    }
}
