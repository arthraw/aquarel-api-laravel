<?php

namespace App\DTOs\Profile;

class UpdateProfileDTO
{
    public ?string $bio;
    public ?string $name;
    public ?string $avatar_url;
    public ?string $banner_url;
    public ?string $instagram_profile_url;
    public ?string $behance_profile_url;
    public ?string $category;

    public function __construct($bio, $name, $avatar_url, $banner_url, $behance_profile_url, $instagram_profile_url, $category)
    {
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
            $data['name'],
            $data['bio'],
            $data['avatar_url'],
            $data['banner_url'],
            $data['instagram_profile_url'],
            $data['behance_profile_url'],
            $data['category']
        );
    }
}
