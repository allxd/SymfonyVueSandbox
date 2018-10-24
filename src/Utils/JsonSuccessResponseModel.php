<?php
namespace App\Utils;

class JsonSuccessResponseModel {
    public function createResponse(string $name, $data) {
        $response = (object) [ 
        	"status"=> 0,
        	"payload"=> [$name=> $data]];
        return $response;
    }
}