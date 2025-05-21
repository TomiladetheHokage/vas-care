<?php

namespace Owner\VasCare\dto\response;

class StatusResponse{
    public $message;
    public $success;

    public function __construct($message, $success){
        $this->message = $message;
        $this->success = $success;
    }
}