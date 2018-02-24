<?php

use App\Routes\Route;

Route::get('user/{id}', 'App\Controllers\UserController@detail');

Route::notAllowed();