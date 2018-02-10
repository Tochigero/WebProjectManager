<?php

namespace App\Service;

use App\Entity\Project;
use App\Entity\Token;
use Doctrine\Common\Persistence\ObjectManager;

class ClientService
{
    private $url;

    /**
     * Curl Init Var
     */
    private $varCurl;

    public function curl_init($url) {
        $this->varCurl = curl_init();

        curl_setopt($this->varCurl, CURLOPT_URL, "$url");
        curl_setopt($this->varCurl, CURLOPT_HEADER, 0);
        curl_setopt($this->varCurl, CURLOPT_RETURNTRANSFER, true);
    }

    public function curl_call() {
        return curl_exec($this->varCurl);
    }

    public function curl_close() {
        curl_close($this->varCurl);
    }
}