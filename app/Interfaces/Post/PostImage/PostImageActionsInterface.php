<?php

namespace App\Interfaces\Post\PostImage;

use App\Models\PostImage;

interface PostImageActionsInterface
{
    public function getPostImageById(string $id);
    public function createPostImage(array $data);
    public function deletePostImage(PostImage $postImage);
    public function updatePostImage(PostImage $post, array $data);

}
