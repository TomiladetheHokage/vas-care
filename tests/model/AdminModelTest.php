<?php

namespace model;

use mysqli;
use Owner\VasCare\dto\response\StatusResponse;
use Owner\VasCare\model\AdminModel;
use PHPUnit\Framework\TestCase;
use src\dto\response\RegisterResponse;

require_once __DIR__ . "/../../src/model/AdminModel.php";
require_once __DIR__ . "/../../src/dto/response/StatusResponse.php";
require_once __DIR__ . "/../../src/dto/response/RegisterResponse.php";

class AdminModelTest extends TestCase
{
    private mysqli $conn;
    private AdminModel $adminModel;

    protected function setUp(): void
    {
        $this->conn = new mysqli('localhost', 'root', '', 'vas-care-test');
        $this->adminModel = new AdminModel($this->conn);
    }

    private function getDoctorData(): array {
        return [
            'first_name' => 'Gregory',
            'last_name' => 'House',
            'email' => 'greg.house@test.com',
            'phone_number' => '09011112222',
            'gender' => 'male',
            'password' => 'housepass',
            'specialization' => 'General medicine',
            'availability' => 'available'
        ];
    }

    private function getNurseData(): array {
        return [
            'first_name' => 'Nina',
            'last_name' => 'Brown',
            'email' => 'nina.brown@test.com',
            'phone_number' => '09099887766',
            'gender' => 'female',
            'password' => 'nursepass',
            'shift' => 'night'
        ];
    }



    public function testViewAllUsers(): void {
        $response = $this->adminModel->viewAllUsers();

        $this->assertIsArray($response);

        $this->assertNotEmpty($response);

        foreach ($response as $user) {
            $this->assertArrayHasKey('user_id', $user);
            $this->assertArrayHasKey('first_name', $user);
            $this->assertArrayHasKey('last_name', $user);
            $this->assertArrayHasKey('email', $user);
        }
    }


    public function testAddStaffMember(): void {
        $addDoctor = $this->adminModel->addStaffMember($this->getDoctorData(), 'doctor');
        $addNurse = $this->adminModel->addStaffMember($this->getNurseData(), 'nurse');
        $this->assertTrue($addDoctor->success);
        $this->assertTrue($addNurse->success);

    }


    public function testAddNurse(): void{
        $response = $this->adminModel->addStaffMember($this->getNurseData(), 'nurse');
        $this->assertTrue($response->success);
        $this->assertEquals("Staff has been registered", $response->message);
    }

    public function testActivateAndDeactivateUser(): void{
        $response = $this->adminModel->addStaffMember($this->getDoctorData(), 'doctor');
        $userId = $response->user_id;

        $deactivateUser = $this->adminModel->updateUserStatus($userId, 'inactivate');

        $this->assertTrue($deactivateUser->success);
        $this->assertEquals("User status has been updated", $deactivateUser->message);

        $activateUser = $this->adminModel->updateUserStatus($userId, 'active');

        $this->assertTrue($activateUser->success);
        $this->assertEquals("User status has been updated", $activateUser->message);

    }

    protected function tearDown(): void
    {
        $emails = [
            'greg.house@test.com',
            'nina.brown@test.com',
            'jane.doe@test.com'
        ];

        foreach ($emails as $email) {
            // First delete from nurses and doctors (child tables)
            $this->conn->query("DELETE FROM nurses WHERE user_id IN (SELECT user_id FROM users WHERE email = '$email')");
            $this->conn->query("DELETE FROM doctors WHERE user_id IN (SELECT user_id FROM users WHERE email = '$email')");

            // Then delete from users (parent table)
            $this->conn->query("DELETE FROM users WHERE email = '$email'");
        }

        $this->conn->close();
    }

}
