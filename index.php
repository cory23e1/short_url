<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'Controllers/Api/UrlController.php';

$url = new UrlController();
echo $url->catchShortUrl();
echo $url->makeShortUrl();
echo $url->showLastUrlsData();