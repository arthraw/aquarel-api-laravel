<?php

namespace App\Repository\Like;

use App\Exceptions\Like\LikeException;
use App\Interfaces\Like\LikesActionsInterface;
use App\Models\Like;
use Throwable;

class LikeRepository implements LikesActionsInterface
{

    public function insertLike(array $data)
    {
        try {
            return Like::create($data);
        } catch (\Throwable $e) {
            throw new LikeException('Something went wrong while creating the like');
        }
    }

    public function getLikesCount(array $data)
    {
        try {
            return Like::where([
                'likeable_id' => $data['likeable_id'],
                'likeable_type' => $data['likeable_type'] ?? 'post'
            ])->count();
        } catch (Throwable $e) {
            throw new LikeException('Error trying get number of likes');
        }
    }

    public function deleteLike(Like $like)
    {
        try {
            return $like->delete();
        } catch (Throwable $e) {
            throw new LikeException('Something went wrong on like delete');
        }
    }

    public function getLikesByProfileId(array $data)
    {
        try {
            return Like::where([
                'profile_id' => $data['profile_id'],
                'likeable_id' => $data['likeable_id'],
            ])->count();
        } catch (Throwable $e) {
            throw new LikeException('Error trying get number of likes');
        }
    }

    public function getLikeById(string $id)
    {
        try {
            return Like::where('like_id', $id)->first();
        } catch (LikeException $e) {
            throw new LikeException('No likes found for the provided like_id.');
        }
    }


}
