<?php

require_once 'MainController.php';
require_once 'Models/UrlModel.php';

class UrlController extends MainController
{
    const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private $requestMethod;
    private $arrQueryStringParams;

    public function __construct()
    {
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->arrQueryStringParams = $this->getQueryStringParams();
    }

    public function makeShortUrl()
    {
        if (strtoupper($this->requestMethod) == 'GET') {
            if (isset($this->arrQueryStringParams['url'])) {
                if(filter_var($this->arrQueryStringParams['url'], FILTER_VALIDATE_URL)){
                    $randomChars = substr(str_shuffle(UrlController::CHARS), 0, 4);
                    $shortUrl = $_SERVER['SERVER_NAME'] . '/' .$randomChars;

                    $values = [$this->arrQueryStringParams['url'],$randomChars,0,date("Y-m-d H:i:s")];
                    $urlModel = new UrlModel();
                    $urlModel->addShortUrl($values);

                    $shortUrlRes = json_encode(["short_url"=>$shortUrl],JSON_UNESCAPED_SLASHES);
                    return $shortUrlRes;
                }
                else{
                    return json_encode('Incorrect URL');
                }
            }
        }
    }

    public function showLastUrlsData(){
        if (strtoupper($this->requestMethod) == 'GET') {
            if (isset($this->arrQueryStringParams['last'])) {
                $urlModel = new UrlModel();
                return json_encode($urlModel->getLastUrlData(),JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function catchShortUrl(){
        if (strtoupper($this->requestMethod) == 'GET') {
            if(strlen($this->getUriSegments()[1])==4){
                $urlModel = new UrlModel();
                $urlInfo = $urlModel->getOneUrlData($this->getUriSegments()[1]);
                if(!empty($urlInfo)){
                    $id = $urlInfo['id'];
                    $count = $urlInfo['count']+1;
                    $urlModel->updateShortUrlCount($count,$id);
                    header('Location: '.$urlInfo['url']);
                }
            }
        }
    }
}