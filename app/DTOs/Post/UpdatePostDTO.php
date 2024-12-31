<?php

namespace App\DTOs\Post;

class UpdatePostDTO
{
    public string $post_id;
    public string $content;
    public string $profile_id;

    public function __construct($post_id, $content, $profile_id)
    {
        $this->post_id = $post_id;
        $this->content = $content;
        $this->profile_id = $profile_id;
    }

    public static function fromPostRequest(array $data): self
    {
        return new self(
            $data['post_id'],
            $data['content'],
            $data['profile_id'],
        );
    }
}
