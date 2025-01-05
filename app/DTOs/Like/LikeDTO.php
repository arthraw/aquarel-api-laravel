<?php

namespace App\DTOs\Like;

class LikeDTO
{
    public string $profile_id;

    public string $likeable_id;

    public string $likeable_type;

    public function __construct(string $profile_id, string $likeable_id, string $likeable_type)
    {
        $this->profile_id = $profile_id;
        $this->likeable_id = $likeable_id;
        $this->likeable_type = $likeable_type;
    }

    public static function fromLikeRequest(array $data): self
    {
        return new self(
            $data['profile_id'],
            $data['likeable_id'],
            $data['likeable_type']
        );
    }
}
