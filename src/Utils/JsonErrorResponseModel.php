<?php
namespace App\Utils;

class JsonErrorResponseModel {
    public function createResponse(string $err='') {
        $response = (object) [ 
        	"status"=> 1,
        	"error"=> $err];
        return $response;
    }
}