<?php

namespace Owner\VasCare\model;

use mysqli;
use Owner\VasCare\dto\response\StatusResponse;

require_once __DIR__ . "/AppointmentModel.php";
require_once __DIR__ . '/../dto/response/StatusResponse.php';

class PatientModel{
    private mysqli $conn;
    private $appointmentModel;

    public function __construct(mysqli $conn) {
        $this->appointmentModel = new AppointmentModel($conn);
        $this->conn = $conn;
    }

    private function isPatientActive($patientId): StatusResponse {
        $patientId = (int) $patientId;
        $stmt = $this->conn->prepare("SELECT status FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $status = trim(strtolower($row['status']));
            if ($status === 'active') {
                return new StatusResponse("Active", true);
            } else {
                return new StatusResponse("Patient is deactivated", false);
            }
        }

        return new StatusResponse("Patient not found", false);
    }


    public function createAppointment($data): StatusResponse {
        $statusResponse = $this->isPatientActive($data['patient_id']);
        if (!$statusResponse->success) {
            return $statusResponse;
        }

        $success = $this->appointmentModel->create($data);
        if ($success) {
            return new StatusResponse("Appointment booked successfully", true);
        }
        return new StatusResponse("Failed to book appointment", false);
    }


}