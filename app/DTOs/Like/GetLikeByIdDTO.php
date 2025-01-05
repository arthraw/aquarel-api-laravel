<?php

namespace App\DTOs\Like;

class GetLikeByIdDTO
{

    public string $like_id;


    public function __construct(string $like_id)
    {
        $this->like_id = $like_id;
    }

    public static function fromGetLikeRequest(array $data): self
    {
        return new self(
            $data['like_id'],
        );
    }
}
