<?php

namespace src\dto\response;

class RegisterResponse{
    public $success;
    public $message;
    public $user_id;

    public function __construct($success, $message, $user_id = null){
        $this->success = $success;
        $this->message = $message;
        $this->user_id = $user_id;
    }

}