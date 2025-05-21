<?php

namespace dto\response;

class LoginResponse{
    public $message;
    public $success;
    public $userData;

    public function __construct($message, $success, $userData = null) {
        $this->message = $message;
        $this->success = $success;
        $this->userData = $userData;
    }

}