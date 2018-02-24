<?php

namespace App\Config;

class Config
{
    private static $config;
    private static $instance;

    public function __construct()
    {
        self::$config = require_once CONFIG_PATH;
    }

    public static function get($key)
    {
        return self::getInstance()->getByArrayKeys(self::$config, explode('.', $key));
    }

    public function getByArrayKeys(array $config, array $arrayKeys)
    {
        $key = array_shift($arrayKeys);

        if (!isset($config[$key])) {
            return null;
        }

        if (isset($config[$key]) && $arrayKeys && is_array($config[$key])) {
            return $this->getByArrayKeys($config[$key], $arrayKeys);
        }

        return isset($config[$key]) ? $config[$key] : null;
    }

    protected static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Config();
        }

        return self::$instance;
    }
}