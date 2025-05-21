<?php


namespace model;

use mysqli;
use Owner\VasCare\dto\response\StatusResponse;
use Owner\VasCare\model\AppointmentModel;
use Owner\VasCare\model\DoctorModel;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/model/AppointmentModel.php";
require_once __DIR__ . "/../../src/model/DoctorModel.php";
require_once __DIR__ . "/../../src/dto/response/StatusResponse.php";

class DoctorModelTest extends TestCase
{
    private $conn;
    private $doctorModel;
    private $appointmentModel;
    private $doctorUserId;
    private $doctorId;
    private $patientUserId;
    private $appointmentId;
    private $nurseUserId;

    protected function setUp(): void
    {
        $this->conn = new mysqli("localhost", "root", "", "vas-care-test");

        // Clean tables
        $this->conn->query("DELETE FROM assigned_appointments");
        $this->conn->query("DELETE FROM appointments");
        $this->conn->query("DELETE FROM nurses");
        $this->conn->query("DELETE FROM patients");
        $this->conn->query("DELETE FROM doctors");
        $this->conn->query("DELETE FROM users");

        // Create doctor
        $this->conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES ('Dr', 'Test', 'drtest@example.com', 'pass')");
        $this->doctorUserId = $this->conn->insert_id;
        $this->conn->query("INSERT INTO doctors (user_id, specialization, availability) VALUES ($this->doctorUserId, 'Cardiology', 'available')");
        $this->conn->query("UPDATE users SET status = 'active' WHERE user_id = $this->doctorUserId");


//        // Create patient
        $this->conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES ('Jane', 'Patient', 'patient@example.com', 'pass')");
        $this->patientUserId = $this->conn->insert_id;
        $this->conn->query("INSERT INTO patients (user_id, address, date_of_birth, blood_type, emergency_contact)
                            VALUES ($this->patientUserId, 'Lagos', '2000-05-07', 'O+', '911')");

        // Create nurse
        $this->conn->query("INSERT INTO users (first_name, last_name, role) VALUES ('Mary', 'Nurse', 'nurse')");
        $this->nurseUserId = $this->conn->insert_id;
        $this->conn->query("INSERT INTO nurses (user_id) VALUES ($this->nurseUserId)");

        // Create models
        $this->appointmentModel = new AppointmentModel($this->conn);
        $this->doctorModel = new DoctorModel($this->conn);

        // Create appointment
        $this->appointmentModel->create([
            'patient_id' => $this->patientUserId,
            'date' => '2025-05-07',
            'ailment' => 'Fever',
            'medical_history' => 'None',
            'current_medication' => 'Paracetamol'
        ]);
        $this->appointmentId = $this->conn->insert_id;
        $this->doctorId = $this->doctorUserId;
    }

    public function testUpdateAvailability_ChangesStatusSuccessfully()
    {
        $result = $this->doctorModel->updateAvailability($this->doctorId, 'not available');
        $this->assertTrue($result);

        $res = $this->conn->query("SELECT availability FROM doctors WHERE user_id = $this->doctorId");
        $row = $res->fetch_assoc();
        $this->assertEquals('not available', $row['availability']);
    }

    public function testViewAllAppointments_ReturnsCorrectData()
    {
        // Assign the doctor and nurse directly in the appointments table
        $this->conn->query("
        UPDATE appointments 
        SET doctor_id = $this->doctorUserId, 
            assigned_by = $this->nurseUserId 
        WHERE appointment_id = $this->appointmentId
    ");

        $appointments = $this->doctorModel->viewAllAppointments($this->doctorId);

        $this->assertIsArray($appointments);
        $this->assertCount(1, $appointments);
        $this->assertEquals('Fever', $appointments[0]['ailment']);
        $this->assertEquals('Jane Patient', $appointments[0]['patient_name']);
        $this->assertEquals('Mary Nurse', $appointments[0]['nurse_name']);
    }


    public function testViewAllAppointments_DoctorDeactivated_ReturnsStatusResponse()
    {
        // Deactivate the doctor
        $this->conn->query("UPDATE users SET status = 'deactivated' WHERE user_id = $this->doctorUserId");

        $response = $this->doctorModel->viewAllAppointments($this->doctorUserId);

        $this->assertInstanceOf(StatusResponse::class, $response);
        $this->assertFalse($response->success);
        $this->assertEquals("Doctor is deactivated", $response->message);
    }

    public function testUpdateAvailability_DoctorDeactivated_ReturnsStatusResponse()
    {
        // Deactivate the doctor
        $this->conn->query("UPDATE users SET status = 'deactivated' WHERE user_id = $this->doctorUserId");

        $response = $this->doctorModel->updateAvailability($this->doctorUserId, 'not available');

        $this->assertInstanceOf(StatusResponse::class, $response);
        $this->assertFalse($response->success);
        $this->assertEquals("Doctor is deactivated", $response->message);
    }


    // Uncomment if you want to clean up after each test
    // protected function tearDown(): void {
    //     $this->conn->query("DELETE FROM assigned_appointments");
    //     $this->conn->query("DELETE FROM appointments");
    //     $this->conn->query("DELETE FROM nurses");
    //     $this->conn->query("DELETE FROM patients");
    //     $this->conn->query("DELETE FROM doctors");
    //     $this->conn->query("DELETE FROM users");
    //     $this->conn->close();
    // }
}
