<?php

namespace App\Exceptions\Like;

use Exception;
class LikeException extends Exception
{
    public static function failedLikeSearch(): self
    {
        return new self('No likes founded for provided id');
    }

    public static function failedLikeCreate(): self
    {
        return new self('Fail in insert like');
    }
}
