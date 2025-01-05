<?php

namespace App\Enum\Like;

use App\Models\Post;

enum LikeTypeEnum: string
{
    case POST = 'post';
//    case Event = Event::class
//    case work = Work::class
//    case comment = Comment::class
}
