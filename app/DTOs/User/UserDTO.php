<?php

namespace App\DTOs\User;

class UserDTO
{
    public string $username;

    public string $password;

    public string $email;

    public function __construct($username, $password, $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public static function fromRequest(array $data) : self
    {
        return new self(
            $data['username'],
            $data['password'],
            $data['email']
        );
    }

}
