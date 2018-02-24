<?php

namespace App\Models;

class User extends ShardModel
{
    public static function getUserByID($userID)
    {
        $results = self::select(
            'SELECT * FROM users WHERE id = :user_id',
            [':user_id' => $userID],
            $userID
        );

        return is_array($results) ? array_shift($results) : $results;
    }

    public static function getAllUserList()
    {
        return self::select('SELECT * FROM users');
    }

}