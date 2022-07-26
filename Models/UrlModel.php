<?php

require_once 'Database.php';

class UrlModel extends Database
{
    public function getLastUrlData(){
        return $this->select("SELECT * FROM urls");
    }

    public function getOneUrlData($short_url){
        return $this->selectOne("SELECT id,url,count FROM urls WHERE short_url='".$short_url."'");
    }

    public function addShortUrl($data){
        $this->insert("INSERT INTO urls (url, short_url, count, create_date) VALUES (?,?,?,?)",$data);
    }

    public function updateShortUrlCount($count,$id){
        $data = [$count];
        $this->insert("UPDATE urls SET count = ? WHERE id = ".$id,$data);
    }
}