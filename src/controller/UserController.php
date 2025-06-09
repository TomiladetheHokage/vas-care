<?php

namespace Owner\VasCare\controller;

use Owner\VasCare\model\UserModel;
use dto\response\LoginResponse;
use src\dto\response\RegisterResponse;
use Exception;
use mysqli_sql_exception;

require_once __DIR__ . '/../model/UserModel.php';

class UserController {
    private $userModel;

    public function __construct($conn) {
        $this->userModel = new UserModel($conn);
    }

    public function login($email, $password): LoginResponse{
        if (!$this->isValidEmail($email) || empty($password)) return new LoginResponse("Invalid email or password", false);

        $email = $this->sanitizeInput($email);
        return $this->userModel->login($email, $password);
    }

    public function register($data) {
        $requiredFields = ['first_name', 'last_name', 'email', 'password', 'role'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) return new RegisterResponse(false, "Missing required field: $field");
        }
        if (!$this->isValidEmail($data['email'])) return new RegisterResponse(false, "Invalid email format");

        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $uploadsDir = __DIR__ . '/../public/uploads/';
            if (!is_dir($uploadsDir)) mkdir($uploadsDir, 0777, true);

            $filename = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
            $targetPath = $uploadsDir . $filename;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
                $data['profile_picture'] = 'uploads/' . $filename;
            } else {
                return new RegisterResponse(false, "Failed to upload profile picture.");
            }
        } else {
            $data['profile_picture'] = null;
        }

        return $this->userModel->Register($data);
    }



    private function sanitizeInput($input): string{
        return htmlspecialchars(strip_tags(trim($input)));
    }

    private function isValidEmail($email): bool{
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
