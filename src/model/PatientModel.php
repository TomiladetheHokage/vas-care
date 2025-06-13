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
            if ($status === 'active') return new StatusResponse("Active", true);
            else return new StatusResponse("Patient is deactivated", false);
        }

        return new StatusResponse("Patient not found", false);
    }


    public function createAppointment($data): StatusResponse {
        $statusResponse = $this->isPatientActive($data['patient_id']);
        if (!$statusResponse->success) return $statusResponse;

        $success = $this->appointmentModel->create($data);
        if ($success) return new StatusResponse("Appointment booked successfully", true);

        return new StatusResponse("Failed to book appointment", false);
    }

    public function getAppointments(int $patientId, ?string $status = null, ?string $search = null): array {
        $query = "
        SELECT 
            a.appointment_id,
            a.status,
            a.appointment_date,
            a.slot_start,
            a.slot_end,
            a.ailment,
            a.medical_history,
            a.current_medication,
            a.doctor_id,
            a.assigned_by,
            a.requested_date, 
            a.comments,
            doc.first_name AS doctor_first_name,
            doc.last_name AS doctor_last_name,
            nurse.first_name AS nurse_first_name,
            nurse.last_name AS nurse_last_name
        FROM appointments a
        LEFT JOIN users doc ON a.doctor_id = doc.user_id
        LEFT JOIN users nurse ON a.assigned_by = nurse.user_id
        WHERE a.patient_id = ?
    ";

        $types = 'i';
        $params = [$patientId];

        if (!empty($status)) {
            $query .= " AND a.status = ?";
            $types .= 's';
            $params[] = $status;
        }

        if (!empty($search)) {
            $query .= " AND (a.ailment LIKE ? OR a.medical_history LIKE ? OR a.current_medication LIKE ?)";
            $types .= 'sss';
            $searchTerm = '%' . $search . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $query .= " ORDER BY a.appointment_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }

        return $appointments;
    }



    public function countAppointmentsByStatus(int $patientId, ?string $status = null): int {
        if ($status) {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE patient_id = ? AND status = ?");
            $stmt->bind_param("is", $patientId, $status);
        } else {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE patient_id = ?");
            $stmt->bind_param("i", $patientId);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }

        return 0;
    }

    public function editAppointment(array $data): StatusResponse {
        $appointmentId = (int) $data['appointment_id'];
        $patientId = (int) $data['patient_id'];

        $checkExistStmt = $this->conn->prepare("SELECT * FROM appointments WHERE appointment_id = ?");
        $checkExistStmt->bind_param("i", $appointmentId);
        $checkExistStmt->execute();
        $existResult = $checkExistStmt->get_result();


        $appointment = $existResult->fetch_assoc();

        if (strtolower($appointment['status']) !== 'pending') {
            return new StatusResponse("Appointment is not pending (current status: {$appointment['status']}).", false);
        }

        $stmt = $this->conn->prepare("
        UPDATE appointments SET 
            requested_date = ?, 
            ailment = ?, 
            medical_history = ?, 
            current_medication = ? 
        WHERE appointment_id = ?
    ");

        $stmt->bind_param(
            "ssssi", $data['requested_date'], $data['ailment'], $data['medical_history'], $data['current_medication'], $appointmentId);

        if ($stmt->execute()) {
            return new StatusResponse("Appointment updated successfully", true);
        }

        return new StatusResponse("Failed to update appointment", false);
    }





}