<?php
namespace App\Utils;

class ResponseMaker {
    public function createResponse(string $name, array $data, int $status=0, string $err="") {
        $response = (object) [ 
        	"status"=> $status,
        	"error"=> $err,
        	"payload"=> [$name=> $data]];
        return $response;
    }

    public function createUnnamedResponse(array $data) {
        $response = (object) [ 
        	"payload"=> $data];
        return $response;
    }
}