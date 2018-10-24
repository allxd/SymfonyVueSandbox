<?php
namespace App\Utils;

class JsonErrorResponseModel {
    public function createResponse(string $name, string $err="") {
        $response = (object) [ 
        	"status"=> 1,
        	"error"=> $err];
        return $response;
    }
}