<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function detail($userID)
    {
        //var_dump($userID);die;

        $currentUserInfo = User::getUserByID($userID);

        if (!$currentUserInfo) {
            return $this->abort(404);
        }

        return $this->view('user.detail', [
            'current_user_info' => User::getUserByID($userID),
            'user_list'         => User::getAllUserList(),
        ]);
    }
}