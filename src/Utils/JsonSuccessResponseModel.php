<?php
namespace App\Utils;

class JsonSuccessResponseModel {
	public $status;
	public $message;
	public $payload;
	public $redirect;

    /**
     * @param array|[] $payload
     * @param string|null $redirect
     */
    public function __construct($payload=[], ?string $redirect=null) {
        	$this->status = 0;
        	$this->message = '';
        	$this->payload = $payload;
        	$this->redirect = $redirect;
    }
}