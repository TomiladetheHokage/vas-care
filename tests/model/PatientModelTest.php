<?php

namespace model;

use mysqli;
use Owner\VasCare\model\PatientModel;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/model/PatientModel.php";
require_once __DIR__ . "/../../src/model/AppointmentModel.php";

class PatientModelTest extends TestCase {
    private $conn;
    private $patientModel;
    private $patientUserId;

    protected function setUp(): void {
        $this->conn = new mysqli("localhost", "root", "", "vas-care-test");

        $this->conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES ('Patient', 'Test', 'patient@example.com', 'pass')");
        $this->patientUserId = $this->conn->insert_id;
        $this->conn->query("INSERT INTO patients (user_id, address, date_of_birth, blood_type, emergency_contact) 
                            VALUES ($this->patientUserId, 'Lagos', '2000-05-07', 'O+', '911')");

        $this->patientModel = new PatientModel($this->conn);
    }

    public function testPatientCanCreateAppointment(){
        $response = $this->patientModel->createAppointment([
            'patient_id' => $this->patientUserId,
            'date' => '2025-05-07',
            'ailment' => 'Back pain',
        ]);
        var_dump($response);

        $this->assertEquals("Appointment booked successfully", $response->message);
    }


    public function testCreateAppointmentForInactivePatient() {
        $this->conn->query("UPDATE users SET status = 'inactive' WHERE user_id = $this->patientUserId");

        $response = $this->patientModel->createAppointment([
            'patient_id' => $this->patientUserId,
            'date' => '2025-06-01T10:00',
        ]);
        $this->assertFalse($response->success);
        $this->assertEquals("Patient is deactivated", $response->message);
    }
}

?>
