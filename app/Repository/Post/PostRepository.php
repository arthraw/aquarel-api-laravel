<?php

namespace App\Repository\Post;

use App\Exceptions\Post\PostException;
use App\Interfaces\Post\PostActionsInterface;
use App\Models\Post;
use App\Models\Profile;
use Throwable;

class PostRepository implements PostActionsInterface
{

    public function getAllPosts()
    {
        try {
            return Post::all();
        } catch (PostException $e) {
            throw new PostException('None posts returns from database');
        }
    }

    public function getPostById(string $post_id)
    {
        try {
            return Post::where('post_id', $post_id)->first();
        }  catch (PostException $e) {
            throw new PostException('No post found for the provided post_id.');
        }
    }

    public function deletePost(Post $post)
    {
        try {
            return $post->delete();
        } catch (Throwable $e) {
            throw new PostException('Something went wrong on post delete');
        }
    }

    public function createPost(array $data)
    {
        try {
            return Post::create($data);
        } catch (Throwable $e) {
            throw new PostException('Something went wrong while creating the post');
        }
    }

    public function updatePost(Post $post, array $data)
    {
        try {
            return $post->update($data);
        } catch (PostException $e) {
            throw new PostException('Something went wrong while updating the post');
        }
    }
}
