<?php

use App\Controller\HomeController;
use App\Controller\PostsListController;

return 
[
    '/'             => [HomeController::class],
    '/postsList'    => [PostsListController::class],

];