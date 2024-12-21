<?php

namespace App\DTOs\Profile;

class ProfileDTO
{
    public string $name;

    public string $user_id;

    public function __construct($name, $user_id)
    {
        $this->name = $name;
        $this->user_id = $user_id;
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['name'],
            $data['user_id']
        );
    }
}
