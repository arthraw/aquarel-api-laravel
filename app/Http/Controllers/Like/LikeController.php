<?php

namespace App\Http\Controllers\Like;

use App\DTOs\Like\GetLikeByIdDTO;
use App\DTOs\Like\LikeDTO;
use App\Enum\Like\LikeTypeEnum;
use App\Exceptions\Like\LikeException;
use App\Exceptions\Post\PostException;
use App\Exceptions\Profile\ProfileException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Like\CreateLikeRequest;
use App\Http\Requests\Like\GetLikeByIdRequest;
use App\Repository\Like\LikeRepository;
use App\Repository\Post\PostRepository;
use App\Repository\Profile\ProfileRepository;

class LikeController extends Controller
{
    protected LikeRepository $like;
    protected PostRepository $post;
    protected ProfileRepository $profile;

    public function __construct(LikeRepository $like, PostRepository $post, ProfileRepository $profile)
    {
        $this->like = $like;
        $this->post = $post;
        $this->profile = $profile;
    }

    protected function validateProvidedLikeableData(LikeDTO $likeDTO)
    {
        try {
            $profile = $this->profile->getProfileById($likeDTO->profile_id);
        } catch (ProfileException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        if (is_null($profile)) {
            return response()->json([
                'message' => 'Not existent profile provided'
            ], 404);
        }

        if ($likeDTO->likeable_type == LikeTypeEnum::POST->value) {
            try {
                $post = $this->post->getPostById($likeDTO->likeable_id);
            } catch (PostException $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 400);
            }
            if (is_null($post)) {
                return response()->json([
                    'message' => 'Not existent post provided'
                ], 404);
            }
        }
        return $likeDTO;
    }

    protected function verifyIfLikesAlreadyExists(array $data): bool
    {
        try {
            $likesCount = $this->like->getLikesByProfileId($data);
        } catch (LikeException $e) {
            return true;
        }
        if ($likesCount != 0) {
            return true;
        }

        return false;
    }
    public function addLike(CreateLikeRequest $request)
    {
        $likeDTO = LikeDTO::fromLikeRequest($request->validated());

        $likeDTO = $this->validateProvidedLikeableData($likeDTO);
        if (!$likeDTO instanceof LikeDTO) {
            return $likeDTO;
        }
        $likeToCreate = [
            'profile_id' => $likeDTO->profile_id,
            'likeable_id' => $likeDTO->likeable_id,
            'likeable_type' => $likeDTO->likeable_type,
        ];
        $likeExists = $this->verifyIfLikesAlreadyExists($likeToCreate);
        if ($likeExists) {
            return response()->json([
                'message' => 'This post is already liked by the provided profile'
            ], 400);
        }
        try {
            $like = $this->like->insertLike($likeToCreate);
        } catch (LikeException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
        if (!is_null($like)) {
            return response()->json([
                'message' => 'Like created successfully',
                'like' => $like->like_id
            ], 201);
        }
        return response()->json([
            'message' => 'Not possible add a like now, try later',
        ], 500);
    }

    public function checkLikesCount(CreateLikeRequest $request)
    {
        $likeDTO = LikeDTO::fromLikeRequest($request->validated());

        $likeDTO = $this->validateProvidedLikeableData($likeDTO);
        if (!$likeDTO instanceof LikeDTO) {
            return $likeDTO;
        }
        $getLikesData = [
            'likeable_id' => $likeDTO->likeable_id,
            'likeable_type' => $likeDTO->likeable_type
        ];

        try {
            $likesCount = $this->like->getLikesCount($getLikesData);
        } catch (LikeException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        if (!is_null($likesCount)) {
            return response()->json([
                'likes_count' => $likesCount,
                'likeable_id' => $likeDTO->likeable_id
            ], 200);
        }

        return response()->json([
            'message' => 'Not possible get the numbers of like now, try later',
        ], 500);
    }

    public function removeLike(GetLikeByIdRequest $request)
    {
        $likeDTO = GetLikeByIdDTO::fromGetLikeRequest($request->validated());

        try {
            $like = $this->like->getLikeById($likeDTO->like_id);
        } catch (LikeException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }

        if (!is_null($like)) {
            try {
                $isDeleted = $this->like->deleteLike($like);
            } catch (LikeException $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ]);
            }

            if ($isDeleted) {
                return response()->json([
                    'message' => 'Like deleted successfully'
                ], 200);
            }
        }
        return response()->json([
            'message' => 'Error trying to delete like of provided likeable'
        ], 404);
    }
}
