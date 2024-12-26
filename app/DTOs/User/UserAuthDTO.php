<?php

namespace App\DTOs\User;

class UserAuthDTO
{
    public string $email;
    public string $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromLoginRequest(array $data): self
    {
        return new self(
            $data['email'],
            $data['password']
        );
    }
}
