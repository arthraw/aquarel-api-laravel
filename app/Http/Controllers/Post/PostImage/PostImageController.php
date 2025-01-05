<?php

namespace App\Http\Controllers\Post\PostImage;

use App\DTOs\Post\PostDTO;
use App\DTOs\Post\PostImage\PostImageDTO;
use App\DTOs\Post\PostImage\UpdatePostImageDTO;
use App\DTOs\Post\UpdatePostDTO;
use App\Exceptions\Profile\ProfileException;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\PostImage\CreatePostImageRequest;
use App\Http\Requests\Post\PostImage\UpdatePostImageRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Repository\Post\PostImage\PostImageRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Exceptions\Post\PostException;
use App\Repository\Post\PostRepository;
use App\Repository\Profile\ProfileRepository;

class PostImageController extends Controller
{
    protected PostImageRepository $post;
    protected ProfileRepository $profile;


    public function __construct(PostImageRepository $post, ProfileRepository $profile)
    {
        $this->post = $post;
        $this->profile = $profile;
    }

    public function getPostImageById(string $id): JsonResponse
    {
        try {
            $post = $this->post->getPostImageById($id);
        } catch (PostException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
        if (!is_null($post)) {
            return response()->json([
                'post' => $post
            ], 200);
        } else {
            return response()->json([
                'message' => PostException::noPostsReturn()->getMessage()
            ], 404);
        }
    }

    public function store(CreatePostImageRequest $request): JsonResponse
    {
        $postDTO = PostImageDTO::fromPostImageRequest($request->validated());
        $postAttributes = [
            'post_image_url' => $postDTO->post_image_url,
            'profile_id' => $postDTO->profile_id,
            'post_id' => $postDTO->post_id,
        ];
        try {
            $post = $this->post->createPostImage($postAttributes);
        } catch (PostException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
        if (!is_null($post)) {
            return response()->json([
                'post' => $post,
                'message' => 'Post image created successfully'
            ],201);
        } else {
            return  response()->json([
                'message' => PostException::postCreationError()->getMessage()
            ], 400);
        }
    }

    public function update(UpdatePostImageRequest $request): JsonResponse
    {
        $postRequest = UpdatePostImageDTO::fromUpdatePostImageRequest($request->validated());

        $post = $this->validatePostData($postRequest);
        if ($post instanceof JsonResponse) {
            return $post;
        }
        $newPostImage = [
            'post_image_url' => $postRequest->post_image_url
        ];
        try {
            $postUpdated = $this->post->updatePostImage($post, $newPostImage);
            if ($postUpdated) {
                return response()->json([
                    'message' => 'Post image updated successfully'
                ], 200);
            }
        } catch (PostException $e) {
            return response()->json([
                'message' => 'Its not possible to update the provided post image, try later '.$e->getMessage()
            ], 500);
        }
        return response()->json([
            'alert' => 'Error trying to update a post image'
        ], 500);
    }

    public function remove(UpdatePostImageRequest $request)
    {
        $postRequest = UpdatePostImageDTO::fromUpdatePostImageRequest($request->validated());
        $post = $this->validatePostData($postRequest);
        if ($post instanceof JsonResponse) {
            return $post;
        }
        try {
            $isPostDeleted = $this->post->deletePostImage($post);
            if ($isPostDeleted) {
                return response()->json([
                    'message' => 'Post image deleted successfully'
                ]);
            } else {
                return response()->json([
                    'message' => 'Post image delete failed'
                ], 400);
            }
        } catch (PostException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    protected function validatePostData(UpdatePostImageDTO $postRequest)
    {
        try {
            $profile = $this->profile->getProfileById($postRequest->profile_id);
            $post = $this->post->getPostImageById($postRequest->post_image_id);
            if (is_null($profile) | is_null($post)) {
                return response()->json([
                    'message' => 'No profile or post image founded with provided id'
                ], 404);
            }
        } catch (PostException | ProfileException $e) {
            return response()->json([
                'message' => 'Error in data validation: '.$e->getMessage()
            ],400);
        }

        if ($profile->profile_id != $postRequest->profile_id) {
            return response()->json([
                'message' => 'You must own the post to edit it'
            ],400);
        }

        return $post;
    }
}
