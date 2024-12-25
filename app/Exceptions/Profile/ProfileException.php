<?php

namespace App\Exceptions\Profile;

use Exception;

class ProfileException extends Exception
{
    public static function notPossibleUpdateProfileData(): self
    {
        return new self('Cannot update user profile.');
    }

}
