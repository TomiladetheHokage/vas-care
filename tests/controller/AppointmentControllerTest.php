<?php

namespace controller;

use dto\response\AppointmentResponse;
use Owner\VasCare\model\AppointmentModel;
use mysqli;
use Owner\VasCare\controller\AppointmentController;
use PHPUnit\Framework\TestCase;
require_once __DIR__ . "/../../src/controller/AppointmentController.php";
require_once __DIR__ . "/../../src/model/AppointmentModel.php";
require_once __DIR__ . "/../../src/dto/response/AppointmentResponse.php";
class AppointmentControllerTest extends TestCase{

    private $appointmentController;

    protected function setUp(): void{
        $this->conn = new mysqli("localhost", "root", "", "vas-care-test");
        $this->appointmentController = new AppointmentController($this->conn);
    }

    public function testGetAllAppointments(){
        $result = $this->appointmentController->getAppointments();
        var_dump($result);
        $this->assertIsArray($result);

        $appointments = $result[0];

        $this->assertEquals("Headache", $appointments['ailment']);
    }

    public function testCreateAppointmentWithInvalidDoctorId() {
        $data = [
            'patient_id' => 2,
            'date' => '2025-05-10',
            'ailment' => 'Flu',
            'medical_history' => 'None',
            'current_medication' => 'Ibuprofen'
        ];

        $response = $this->appointmentController->createAppointment($data);

        $this->assertFalse($response->success);
        $this->assertEquals('Doctor ID and Patient ID must be numeric', $response->message);
    }

    public function testCreateAppointmentWithInvalidDateFormat() {
        $data = [
            'doctor_id' => 1,
            'patient_id' => 2,
            'date' => '10-05-2025',
            'ailment' => 'Cough',
            'medical_history' => 'None',
            'current_medication' => 'Cough syrup'
        ];

        $response = $this->appointmentController->createAppointment($data);

        $this->assertFalse($response->success);
        $this->assertEquals('Invalid date format. Use YYYY-MM-DD.', $response->message);
    }

    public function testCreateAppointmentWithMissingField() {
        $data = [
            'doctor_id' => 1,
            // 'patient_id' is missing
            'date' => '2025-05-10',
            'ailment' => 'Malaria',
            'medical_history' => 'N/A',
            'current_medication' => 'Artemisinin'
        ];

        $response = $this->appointmentController->createAppointment($data);

        $this->assertFalse($response->success);
        $this->assertStringContainsString('Missing required field', $response->message);
    }

    public function testUpdateNonexistentAppointmentStatus() {
        $nonExistentId = 9999;

        $response = $this->appointmentController->updateAppointmentStatus($nonExistentId, 'approved');

        $this->assertFalse($response->success);
        $this->assertEquals('Failed to update status', $response->message);
    }

    public function testUpdateStatusWithInvalidStatus() {
        $this->conn->query("INSERT INTO appointments (doctor_id, patient_id, date, ailment, medical_history, current_medication)
        VALUES ($this->doctorUserId, $this->patientUserId, '2025-05-12', 'Typhoid', 'N/A', 'Flagyl')");
        $appointmentId = $this->conn->insert_id;

        $response = $this->appointmentController->updateAppointmentStatus($appointmentId, 'unknown_status');

        $this->assertFalse($response->success);
        $this->assertEquals('Invalid status value', $response->message);
    }

    public function testCreateAppointmentSuccess() {
        $this->conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES ('Patient', 'Test', 'patient4@example.com', 'pass')");
        $this->patientUserId = $this->conn->insert_id;
        $this->conn->query("INSERT INTO patients (user_id, address, date_of_birth, blood_type, emergency_contact)
                            VALUES ($this->patientUserId, 'Lagos', '2000-05-07', 'O+', '911')");

        $data = [
            'patient_id' => $this->patientUserId,
            'date' => '2025-05-10',
            'ailment' => 'Headache',
            'medical_history' => 'None',
            'current_medication' => 'Paracetamol'
        ];

        $response = $this->appointmentController->createAppointment($data);
        $this->assertEquals('Appointment created successfully', $response->message);
        $this->assertTrue($response->success);
    }


}
