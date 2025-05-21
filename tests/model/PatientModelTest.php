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

    protected function setUp(): void
    {
        $this->conn = new mysqli("localhost", "root", "", "vas-care-test");
        $this->conn->query("DELETE FROM appointments");
        $this->conn->query("DELETE FROM patients");
        $this->conn->query("DELETE FROM users");

        // Create a user with status 'active'
        $this->conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES ('Patient', 'Test', 'patient@example.com', 'pass')");
        $this->patientUserId = $this->conn->insert_id;
        $this->conn->query("INSERT INTO patients (user_id, address, date_of_birth, blood_type, emergency_contact) 
                            VALUES ($this->patientUserId, 'Lagos', '2000-05-07', 'O+', '911')");

        $this->patientModel = new PatientModel($this->conn);
    }

    public function testPatientCanCreateAppointment(){
        var_dump($this->patientUserId);  // Output the patient ID for debugging

        $response = $this->patientModel->createAppointment([
            'patient_id' => $this->patientUserId,
            'date' => '2025-05-07',
            'ailment' => 'Back pain',
            'medical_history' => 'None',
            'current_medication' => 'Paracetamol'
        ]);
        var_dump($response);

        $this->assertEquals("Appointment booked successfully", $response->message);
    }



    public function testCreateAppointmentForInactivePatient() {
        $this->conn->query("UPDATE users SET status = 'inactive' WHERE user_id = $this->patientUserId");

        $response = $this->patientModel->createAppointment([
            'patient_id' => $this->patientUserId,
            'date' => '2025-06-01T10:00',
            'ailment' => 'Fever',
            'medical_history' => 'None',
            'current_medication' => 'Ibuprofen'
        ]);

        var_dump($this->patientUserId);
        $this->assertFalse($response->success);
        $this->assertEquals("Patient is deactivated", $response->message);
    }
}

?>
