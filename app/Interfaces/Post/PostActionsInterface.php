<?php

namespace App\Interfaces\Post;
use App\Models\Post;

interface PostActionsInterface
{
    public function getAllPosts();
    public function getPostById(string $post_id);
    public function deletePost(Post $post);
    public function createPost(array $data);
    public function updatePost(Post $post, array $data);
}
