<?php

namespace Owner\VasCare\model;

use dto\response\LoginResponse;
use src\dto\response\RegisterResponse;

class UserModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) return new LoginResponse("User logged in successfully", true, $user);

        return new LoginResponse("Wrong credentials", false);
    }

    public function checkEmailAlreadyExists($email){
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function Register($data) {
        if ($this->checkEmailAlreadyExists($data['email'])) return new RegisterResponse(false, "Email already exists");

        $stmt = $this->conn->prepare("INSERT INTO users (first_name, last_name, email, phone_number, gender, password,
        role, profile_picture)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);
        $profilePicture = isset($data['profile_picture']) ? $data['profile_picture'] : null;

        $stmt->bind_param("ssssssss", $data['first_name'], $data['last_name'], $data['email'],
            $data['phone_number'], $data['gender'], $hashedPassword, $data['role'], $profilePicture);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
//            if ($data['role'] === 'patient') {
//                $this->createPatient($user_id, $data['address'], $data['date_of_birth'], $data['blood_type'],
//                    $data['emergency_contact']);
//                return new RegisterResponse(true, "Patient created successfully", $user_id);
//            }
            return new RegisterResponse(true, "User created successfully", $user_id);
        }
        return new RegisterResponse(false, "Execute failed: " . $stmt->error);
    }


    private function createPatient($user_id, $address, $dob, $blood_type, $emergency_contact): void{
        $stmt = $this->conn->prepare("INSERT INTO patients (user_id, address, date_of_birth, blood_type, emergency_contact) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $address, $dob, $blood_type, $emergency_contact);
        $stmt->execute();
    }
}