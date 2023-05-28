<?php

namespace src\data\api;
use Exception;

class ExchangeRateApi {
    protected $data;
    public function __construct()
    { 
        try {
            $this->data = (new \GuzzleHttp\Client())->request('GET', 'https://developers.paysera.com/tasks/api/currency-exchange-rates');
            if($this->data->getStatusCode() >= 400) {
                throw new Exception('something went wrong');
            }
        }
        catch(Exception $e){
            header($_SERVER['SERVER_PROTOCOL'], true, $e->getCode());
            echo json_encode(array("success" => false, "message" => $e->getMessage(), 'code' => $e->getCode()));
            return;
        }
    }
    
    /**
     * all()
     *
     * @return mixed
     */
    public function all(): mixed
    {
        return json_decode($this->data->getBody());
    }
}