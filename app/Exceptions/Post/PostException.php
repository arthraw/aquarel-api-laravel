<?php

namespace App\Exceptions\Post;

use Exception;
class PostException extends Exception
{
    public static function noPostsReturn(): self
    {
        return new self('Its not possible to return post data, no posts to return');
    }

    public static function postCreationError(): self
    {
        return new self('Error trying to create post');
    }
}
