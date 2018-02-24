<?php

namespace App\Models;

class Model
{
    protected static function query($query, array $params, \PDO $connection)
    {
        $sth = $connection->prepare($query);

        foreach ($params as $key => $value) {
            $sth->bindValue($key, $value);
        }

        $sth->execute();

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }
}