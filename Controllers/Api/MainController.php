<?php

class MainController
{
    public function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
        return $uri;
    }

    public function getQueryStringParams()
    {
        return $_GET;
    }

}