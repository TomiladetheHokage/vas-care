<?php

namespace model;

use mysqli;
use Owner\VasCare\model\AppointmentModel;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/model/AppointmentModel.php";

class AppointmentModelTest extends TestCase{
    private $conn;
    private $appointmentModel;

    protected function setUp(): void{
        $this->conn = new mysqli("localhost", "root", "", "vas-care-test");

//        $this->conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES ('Patient', 'Test', 'patient6@example.com', 'pass')");
//        $this->patientUserId = $this->conn->insert_id;
//        $this->conn->query("INSERT INTO patients (user_id, address, date_of_birth, blood_type, emergency_contact)
//                            VALUES ($this->patientUserId, 'Lagos', '2000-05-07', 'O+', '911')");

        $this->appointmentModel = new AppointmentModel($this->conn);

//        $this->appointmentModel->create([
//            'patient_id' => $this->patientUserId,
//            'date' => '2025-05-07',
//            'ailment' => 'Back pain',
//            'medical_history' => 'None',
//            'current_medication' => 'Paracetamol'
//        ]);
//        $this->appointmentId = $this->conn->insert_id;
    }

    public function testCreate()
    {
        $data = [
            'patient_id' => 854,
            'ailment' => 'Back pain not',
            'medical_history' => 'None',
            'current_medication' => 'Paracetamol',
            'requested_date' => '2025-05-07',
        ];

        $response = $this->appointmentModel->create($data);

        $this->assertTrue($response);

    }

    public function testAppointmentStatusCanUpdate()
    {
        $updated = $this->appointmentModel->updateStatus($this->appointmentId, 'confirmed');
        $this->assertTrue($updated);
    }

    public function testGetAppointmentsWithDetailsByStatus(){
        $results = $this->appointmentModel->getAppointmentsByStatus('pending');
        $this->assertIsArray($results);
        $this->assertNotEmpty($results);

        $appointment = $results[0];
        var_dump($appointment);

        $this->assertEquals('Back pain', $appointment['ailment']);
        $this->assertEquals('pending', $appointment['status']);
        $this->assertEquals('Patient', $appointment['patient_first_name']);
    }

    public function testGetAppointmentsWithDetails(){
        $results = $this->appointmentModel->getAppointmentsByStatus();
        $this->assertIsArray($results);
        $this->assertNotEmpty($results);
    }

    public function testUpdateStatusFailsForNonExistentAppointment() {
        $updated = $this->appointmentModel->updateStatus(9999, 'confirmed');
        $this->assertFalse($updated);
    }

    public function testUpdateStatusWithInjectionAttempt() {
        $maliciousStatus = "'; DROP TABLE appointments; --";
        $updated = $this->appointmentModel->updateStatus($this->appointmentId, $maliciousStatus);

        $this->assertTrue($updated); // it may pass if DB accepts the string, but shouldn't drop anything
        $results = $this->appointmentModel->getAppointmentsByStatus($maliciousStatus);
        $this->assertIsArray($results);
    }
}

?>