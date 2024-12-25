<?php

namespace App\Exceptions\User;

use Exception;

class UserException extends Exception
{
    public static function missingUserData(): self
    {
        return new self('Missing user data in request.');
    }

    public static function userAlreadyExists(): self
    {
        return new self('An account already exists with the email provided.');
    }

    public static function notPossibleUpdateUserData(): self
    {
        return new self('Not possible to update user data.');
    }

}
