<?php

namespace App\Repository\Post\PostImage;

use App\Exceptions\Post\PostException;
use App\Interfaces\Post\PostActionsInterface;
use App\Interfaces\Post\PostImage\PostImageActionsInterface;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Profile;
use Throwable;

class PostImageRepository implements PostImageActionsInterface
{
    public function getPostImageById(string $id)
    {
        try {
            return PostImage::where('post_image_id', $id)->first();
        }  catch (PostException $e) {
            throw new PostException('No post image found for the provided post_id.');
        }
    }

    public function createPostImage(array $data)
    {
        try {
            return PostImage::create($data);
        } catch (Throwable $e) {
            throw new PostException('Something went wrong while creating the post image');
        }
    }

    public function deletePostImage(PostImage $postImage)
    {
        try {
            return $postImage->delete();
        } catch (Throwable $e) {
            throw new PostException('Something went wrong on post image delete');
        }
    }

    public function updatePostImage(PostImage $post, array $data)
    {
        try {
            return $post->update($data);
        } catch (PostException $e) {
            throw new PostException('Something went wrong while updating the post image');
        }
    }

}
