<?php

namespace App\Models\Shard;

use App\Config\Config;

class ShardStrategy
{
    protected static $instance = null;

    protected $server1;
    protected $server2;

    protected function __construct()
    {
        $this->server1 = new \PDO(
           Config::get('database.connections.server1.dsn'),
           Config::get('database.connections.server1.user'),
           Config::get('database.connections.server1.password')
        );

        $this->server2 = new \PDO(
           Config::get('database.connections.server2.dsn'),
           Config::get('database.connections.server2.user'),
           Config::get('database.connections.server2.password')
        );
    }

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function getConnectionByUserID($userID)
    {
        $server = $this->server1;

        if ($userID % 2 == 0) {
            $server = $this->server2;
        }

        return $server;
    }

    public function getConnections()
    {
        return [
            $this->server1,
            $this->server2,
        ];
    }

}