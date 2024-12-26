<?php

namespace App\DTOs\Profile;

class GetProfileDTO
{
    public string $profile_id;

    public function __construct($profile_id)
    {
        $this->profile_id = $profile_id;
    }

    public static function fromGetProfileRequest(array $data): self
    {
        return new self(
            $data['profile_id']
        );
    }
}
