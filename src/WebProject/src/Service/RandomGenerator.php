<?php

namespace App\Service;

use App\Entity\Project;
use App\Entity\Token;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\BrowserKit\Client;

class RandomGenerator
{
    /**
     * @var ClientService
     */
    private $cs;

    private $api_url = "http://api.wordnik.com/v4/words.json/randomWords?hasDictionaryDef=true&minCorpusCount=0&minLength=5&maxLength=15&limit=1&api_key=a2a73e7b926c924fad7001ca3111acd55af2ffabf50eb4ae5";

    public function __construct(ClientService $cs)
    {
        $this->cs = $cs;
        $this->cs->curl_init($this->api_url);
    }

    /**
     * Random three sized code
     */
    public function randomCode() {
        $code = "";
        $code .= json_decode($this->cs->curl_call())[0]->word . "-";
        $code .= json_decode($this->cs->curl_call())[0]->word . "-";
        $code .= json_decode($this->cs->curl_call())[0]->word ;
        return $code;
    }

    public function randomPassword() {
        return json_decode($this->cs->curl_call())[0]->word . rand(1000, 9999);
    }

    /**
     * @return string 5 random char
     */
    public function randomForgetKey() {
        return strtoupper(substr($this->randomHash(), 0, 5));
    }

    /**
     * @return string
     */
    public function randomHash() {
        return md5(rand(1, 9999));
    }

    /**
     * TODO
     * @param $option
     * $option['length'] Words size
     * $option['words'] Words array (empty = random)
     * $option['words'][0] First word (empty = random)
     */
    public function parameterizedCode($option) {

    }
}