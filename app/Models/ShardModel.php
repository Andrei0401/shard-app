<?php

namespace App\Models;

use App\Models\Shard\ShardStrategy;

class ShardModel extends Model
{
    protected static function select($query, array $params = [], $userID = null)
    {
        $shardInstance = ShardStrategy::getInstance();

        if (!is_null($userID)) {
            return parent::query($query, $params, $shardInstance->getConnectionByUserID($userID));
        }

        $results     = [];
        $connections = $shardInstance->getConnections();

        foreach ($connections as $connection) {
            $results = array_merge($results, parent::query($query, $params, $connection));
        }

        return $results;
    }
}