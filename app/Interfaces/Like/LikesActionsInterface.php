<?php

namespace App\Interfaces\Like;

use App\Models\Like;

interface LikesActionsInterface
{
    public function insertLike(array $data);
    public function getLikesCount(array $data);
    public function deleteLike(Like $like);
    public function getLikesByProfileId(array $data);
    public function getLikeById(string $id);

}
