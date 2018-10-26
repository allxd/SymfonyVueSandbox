<?php
namespace App\Utils;

class JsonErrorResponseModel extends JsonSuccessResponseModel{
    
    public function __construct($payload=[], string $message=null, int $status=-1) {
        parent::__construct($payload);
        $this->message = $message;
        $this->status = $status;

    }
}