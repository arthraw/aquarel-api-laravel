<?php

namespace App\Http\Controllers\Post;

use App\DTOs\Post\PostDTO;
use App\DTOs\Post\UpdatePostDTO;
use App\Exceptions\Profile\ProfileException;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Exceptions\Post\PostException;
use App\Repository\Post\PostRepository;
use App\Repository\Profile\ProfileRepository;

class PostController extends Controller
{
    protected PostRepository $post;
    protected ProfileRepository $profile;

    public function __construct(PostRepository $post, ProfileRepository $profile)
    {
        $this->post = $post;
        $this->profile = $profile;
    }

    public function getPosts(): JsonResponse
    {
        try {
            $posts = $this->post->getAllPosts();
        } catch (PostException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
        if (!is_null($posts)) {
            return response()->json([
                'posts' => $posts
            ], 200);
        } else {
            return response()->json([
                'message' => PostException::noPostsReturn()->getMessage()
            ], 404);
        }
    }

    public function getPostById(string $id): JsonResponse
    {
        try {
            $post = $this->post->getPostById($id);
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

    public function store(CreatePostRequest $request): JsonResponse
    {
        $postDTO = PostDTO::fromPostRequest($request->validated());
        $postAttributes = [
            'content' => $postDTO->content,
            'profile_id' => $postDTO->profile_id,
        ];
        try {
            $post = $this->post->createPost($postAttributes);
        } catch (PostException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
        if (!is_null($post)) {
            return response()->json([
                'post' => $post,
                'message' => 'Post created successfully'
            ],201);
        } else {
            return  response()->json([
                'message' => PostException::postCreationError()->getMessage()
            ], 400);
        }
    }

    public function update(UpdatePostRequest $request): JsonResponse
    {
        $postRequest = UpdatePostDTO::fromPostRequest($request->validated());

        $post = $this->validatePostData($postRequest);
        if ($post instanceof JsonResponse) {
            return $post;
        }
        $newPostContent = [
            'content' => $postRequest->content
        ];
        try {
            $postUpdated = $this->post->updatePost($post, $newPostContent);
            if ($postUpdated) {
                return response()->json([
                    'message' => 'Post updated successfully'
                ], 200);
            }
        } catch (PostException $e) {
            return response()->json([
                'message' => 'Its not possible to update the provided post, try later '.$e->getMessage()
            ], 500);
        }
        return response()->json([
            'alert' => 'Error trying to update a post'
        ], 500);
    }

    public function remove(UpdatePostRequest $request)
    {
        $postRequest = UpdatePostDTO::fromPostRequest($request->validated());
        $post = $this->validatePostData($postRequest);
        if ($post instanceof JsonResponse) {
            return $post;
        }
        try {
            $isPostDeleted = $this->post->deletePost($post);
            if ($isPostDeleted) {
                return response()->json([
                    'message' => 'Post deleted successfully'
                ]);
            } else {
                return response()->json([
                    'message' => 'Post delete failed'
                ], 400);
            }
        } catch (PostException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    protected function validatePostData(UpdatePostDTO $postRequest)
    {
        try {
            $profile = $this->profile->getProfileById($postRequest->profile_id);
            $post = $this->post->getPostById($postRequest->post_id);
            if (is_null($profile) | is_null($post)) {
                return response()->json([
                    'message' => 'No profile or post founded with provided id'
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
