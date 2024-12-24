<?php

namespace App\Exceptions;

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

}
