<?php

namespace model;

use dto\response\AppointmentResponse;
use mysqli;
use PHPUnit\Framework\TestCase;
//use Owner\VasCare\model\NurseModel;
//use Owner\VasCare\dto\response\AppointmentResponse;
use Owner\VasCare\dto\response\StatusResponse;

require_once __DIR__ . "/../../src/model/NurseModel.php";
require_once __DIR__ . "/../../src/dto/response/AppointmentResponse.php";
require_once __DIR__ . "/../../src/dto/response/StatusResponse.php";

class NurseModelTest extends TestCase {
    private $conn;
    private $nurseModel;
    private $doctorId;
    private $nurseId;
    private $appointmentId;

    protected function setUp(): void {
        $this->conn = new \mysqli("localhost", "root", "", "vas-care-test");

//        $this->conn->query("DELETE FROM appointments");
//        $this->conn->query("DELETE FROM doctors");
//        $this->conn->query("DELETE FROM users");

        $this->conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES ('Patient', 'Test', 'patien4t@example.com', 'pass')");
        $this->patientId = $this->conn->insert_id;

        $this->conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES ('Nurse', 'Test', 'nurs4e@example.com', 'pass')");
        $this->nurseId = $this->conn->insert_id;
        $this->conn->query("INSERT INTO nurses (user_id) VALUES ($this->nurseId)");
        //
        $this->conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES ('Doc', 'Test', 'do3c@example.com', 'pass')");
        $this->doctorId = $this->conn->insert_id;
        $this->conn->query("INSERT INTO doctors (user_id, specialization, availability) VALUES ($this->doctorId, 'Cardiology', 'available')");

        $this->conn->query("INSERT INTO appointments (patient_id, date, ailment, medical_history, current_medication)
        VALUES ($this->patientId, '2025-05-12', 'Cough', 'None', 'None')");
        $this->appointmentId = $this->conn->insert_id;

        $this->nurseModel = new NurseModel($this->conn);
    }


    public function testAssignDoctorToAppointment_Successful() {
        $response = $this->nurseModel->assignDoctorToAppointment($this->doctorId, 258, $this->nurseId);

        var_dump($response);
        $this->assertInstanceOf(AppointmentResponse::class, $response);
        $this->assertEquals('Appointment assigned', $response->message);
    }

    public function testAssignDoctorToAppointment_FailsIfDoctorUnavailable() {
        $this->conn->query("UPDATE doctors SET availability = 'unavailable' WHERE user_id = $this->doctorId");

        $response = $this->nurseModel->assignDoctorToAppointment($this->doctorId, $this->appointmentId, $this->nurseId, '2025-05-12');

        $this->assertInstanceOf(AppointmentResponse::class, $response);
        $this->assertFalse($response->success);
        $this->assertEquals('Doctor not available', $response->message);
    }

    public function testAssignDoctorToAppointment_FailsIfNurseDeactivated() {
        $this->conn->query("UPDATE users SET status = 'inactive' WHERE user_id = $this->nurseId");

        $response = $this->nurseModel->assignDoctorToAppointment($this->doctorId, $this->appointmentId, $this->nurseId, '2025-05-12');

        $this->assertInstanceOf(StatusResponse::class, $response);
        $this->assertFalse($response->success);
        $this->assertEquals('Nurse is deactivated', $response->message);
    }

    public function testAssignDoctorToAppointment_FailsIfDoctorAlreadyBooked() {
        // Pre-assign doctor to a different appointment on the same date
        $this->conn->query("INSERT INTO appointments (patient_id, doctor_id, date, ailment, medical_history, current_medication) 
            VALUES ($this->patientId, $this->doctorId, '2025-05-12', 'Fever', 'None', 'Paracetamol')");

        $response = $this->nurseModel->assignDoctorToAppointment($this->doctorId, $this->appointmentId, $this->nurseId, '2025-05-12');

        $this->assertInstanceOf(AppointmentResponse::class, $response);
        $this->assertFalse($response->success);
        $this->assertEquals('Doctor already has an appointment at that time', $response->message);
    }

//    protected function tearDown(): void {
//        $this->conn->query("DELETE FROM appointments");
//        $this->conn->query("DELETE FROM doctors");
//        $this->conn->query("DELETE FROM users");
//        $this->conn->close();
//    }
}
