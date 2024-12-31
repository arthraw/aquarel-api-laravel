<?php

namespace App\DTOs\Post;

class GetPostsDTO
{
    public string $profile_id;

    public function __construct($profile_id)
    {
        $this->profile_id = $profile_id;
    }

    public static function fromPostRequest(array $data): self
    {
        return new self(
            $data['profile_id']
        );
    }
}
