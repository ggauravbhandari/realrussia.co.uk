<?php

class Request
{
    public function get($name, $default = null)
    {
        return ! empty($_GET[$name]) ? $_GET[$name] : $default;
    }

    public function post($name, $default = null)
    {
        return ! empty($_POST[$name]) ? $_POST[$name] : $default;
    }

    public function all($name, $default = null)
    {
        return $_GET[$name] ?? $_POST[$name] ?? $default;
    }
}