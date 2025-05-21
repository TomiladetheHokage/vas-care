<?php

namespace dto\response;

class AppointmentResponse{
    public $message;
    public $success;

    public function __construct($message, $success){
        $this->message = $message;
        $this->success = $success;
    }
}