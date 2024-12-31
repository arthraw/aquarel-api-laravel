<?php

namespace App\DTOs\Post;

class PostDTO
{
    public string $content;
    public string $profile_id;

    public function __construct($profile_id, $content)
    {
        $this->profile_id = $profile_id;
        $this->content = $content;
    }

    public static function fromPostRequest(array $data): self
    {
        return new self(
            $data['profile_id'],
            $data['content'],
        );
    }

}
