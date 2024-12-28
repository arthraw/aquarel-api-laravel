<?php

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

return [
    App\Providers\AppServiceProvider::class,
    ExceptionHandler::class,
//    Handler::class,
];
