<?php

define('APP_PATH', __DIR__);
define('CONFIG_PATH', APP_PATH.'/config/config.php');

require APP_PATH.'/vendor/autoload.php';

require APP_PATH.'/routes/web.php';
