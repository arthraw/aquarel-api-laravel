<?php

namespace App\DTOs\Post\PostImage;

class UpdatePostImageDTO
{
    public string $post_image_id;
    public string $post_image_url;
    public string $profile_id;
    public string $post_id;

    public function __construct(string $post_image_id, string $post_image_url, string $profile_id, string $post_id)
    {
        $this->post_image_id = $post_image_id;
        $this->post_image_url = $post_image_url;
        $this->profile_id = $profile_id;
        $this->post_id = $post_id;
    }


    public static function fromUpdatePostImageRequest(array $data): self
    {
        return new self(
            $data['post_image_id'],
            $data['post_image_url'],
            $data['profile_id'],
            $data['post_id'],
        );
    }

}
