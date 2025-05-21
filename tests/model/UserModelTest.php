<?php

namespace model;

use mysqli;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/model/UserModel.php";
require_once __DIR__ . "/../../src/dto/response/RegisterResponse.php";
require_once __DIR__ . "/../../src/dto/response/LoginResponse.php";

class UserModelTest extends TestCase
{

    private $conn;
    private $userModel;

    protected function setUp(): void{
        $this->conn = new  mysqli('localhost', 'root', '', 'vas-care-test');
        $this->userModel = new \Owner\VasCare\model\UserModel($this->conn);
    }

    private function getPatientData()
    {
        return [
            'first_name' => 'Tomilade',
            'last_name' => 'Yemi',
            'email' => 'tomilade@test.com',
            'phone_number' => '09012345678',
            'gender' => 'male',
            'password' => 'securepassword123',
            'role' => 'patient',
            'date_of_birth' => '1990-01-01',
            'blood_type' => 'O+',
            'emergency_contact' => 'Mum: 09099999999',
            'address' => 'lekki'
        ];
    }

    public function testRegister(){
        $data = $this->getPatientData();
        $response = $this->userModel->Register($data);

//        $this->assertTrue($response->success);
        $this->assertEquals("Patient created successfully", $response->message);

        $userId = $response->user_id;

        $result = $this->conn->query("SELECT * FROM users WHERE user_id = $userId");
        $this->assertEquals(1, $result->num_rows);

        $result = $this->conn->query("SELECT * FROM patients WHERE user_id = $userId");
        $this->assertEquals(1, $result->num_rows);
    }

    public function testLogin()
    {
//        $data = $this->getPatientData();
//        $response = $this->userModel->Register($data);
//        $data['email'], $data['password']
        $email = 'tomilade@gmail.com';
        $password = '12';
        $response = $this->userModel->Login($email, $password);
        var_dump($response);

        $this->assertEquals("User logged in successfully", $response->message);
    }

    public function testRegisterWithDuplicateEmail() {
        $data = $this->getPatientData();
        $this->userModel->Register($data);

        $response = $this->userModel->Register($data);

        $this->assertFalse($response->success);
        $this->assertEquals("Email already exists", $response->message);
    }

    public function testLoginWithWrongPassword() {
        $data = $this->getPatientData();
        $this->userModel->Register($data);

        $response = $this->userModel->Login($data['email'], 'wrongpassword');

        $this->assertFalse($response->success);
        $this->assertEquals("Wrong credentials", $response->message);
    }

    public function testLoginWithNonExistentEmail() {
        $response = $this->userModel->Login('notfound@test.com', 'irrelevant');

        $this->assertFalse($response->success);
        $this->assertEquals("Wrong credentials", $response->message);
    }


    protected function tearDown(): void {
        $result = $this->conn->query("SELECT user_id FROM users WHERE email = 'tomilade@test.com'");
        if ($result && $result->num_rows > 0) {
            $userId = $result->fetch_assoc()['user_id'];
            $this->conn->query("DELETE FROM patients WHERE user_id = $userId");
            $this->conn->query("DELETE FROM users WHERE user_id = $userId");
        }
    }
}
