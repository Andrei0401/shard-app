<?php

namespace App\Controllers;

class Controller
{
    protected function view($path, array $data = [])
    {
        $templatePath = __DIR__.'/../Views/frontend/'.str_replace('.', '/', $path).'.php';

        if (!file_exists($templatePath)) {
            throw new \Exception('Template not found: '.$templatePath);
        }

        extract($data);

        ob_start();
        require_once $templatePath;
        $html = ob_get_contents();
        ob_clean();

        echo $html;
    }

    protected function abort($code, $message = '')
    {
        http_response_code($code);

        $templatePath = __DIR__.'/../Views/errors/'.$code.'.php';

        if (!file_exists($templatePath)) {
            echo $message;
            exit;
        }

        ob_start();
        require_once $templatePath;
        $html = ob_get_contents();
        ob_clean();

        echo $html;
    }
}