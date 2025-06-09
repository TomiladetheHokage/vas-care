<?php

namespace Owner\VasCare\model;

class AppointmentModel{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getCurrentStatus($appointment_id): ?string {
        $stmt = $this->conn->prepare("SELECT status FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();

        $status = null;
        $stmt->bind_result($status);

        if ($stmt->fetch()) {
            $stmt->close();
            return $status;
        }

        $stmt->close();
        return null;
    }


    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO appointments 
        (patient_id, appointment_date, slot_start, slot_end, ailment, status, medical_history, current_medication, requested_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $defaultStatus = 'pending';

        $stmt->bind_param(
            "issssssss",
            $data['patient_id'],
            $data['appointment_date'],
            $data['slot_start'],
            $data['slot_end'],
            $data['ailment'],
            $defaultStatus,
            $data['medical_history'],
            $data['current_medication'],
            $data['requested_date'],
        );
        return $stmt->execute();
    }


    public function updateStatus($appointment_id, $status): bool{
//        if ($this->isAssigned($appointment_id)) return false;

        $stmt = $this->conn->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
        $stmt->bind_param("si", $status, $appointment_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    private function isAssigned($appointment_id): bool {
        $assigned_by = null;
        $stmt = $this->conn->prepare("SELECT assigned_by FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $stmt->bind_result($assigned_by);
        $stmt->fetch();
        $stmt->close();

        return !is_null($assigned_by);
    }



    public function getAppointmentsByStatus($status = null, $search = null, $limit = null, $offset = null): array
    {
        $query = $this->buildAppointmentsQuery($status, $search, $limit, $offset);
        $stmt = $this->prepareAppointmentsStatement($query, $status, $search, $limit, $offset);

        $stmt->execute();
        $result = $stmt->get_result();

        return $this->fetchAppointments($result);
    }




    private function buildAppointmentsQuery($status, $search, $limit, $offset): string
    {
        $query = "
    SELECT a.*, 
           d.user_id AS doctor_user_id, du.first_name AS doctor_first_name,
           p.user_id AS patient_user_id, pu.first_name AS patient_first_name,
           a.requested_date  -- Include requested_date here
    FROM appointments a
    LEFT JOIN doctors d ON a.doctor_id = d.user_id
    LEFT JOIN users du ON d.user_id = du.user_id
    JOIN patients p ON a.patient_id = p.user_id
    JOIN users pu ON p.user_id = pu.user_id
    WHERE 1=1
";

        if ($status !== null) {
            $query .= " AND a.status = ?";
        }

        if ($search !== null) {
            $query .= " AND (pu.first_name LIKE ? OR du.first_name LIKE ? OR a.ailment LIKE ?)";
        }

        $query .= " ORDER BY a.appointment_date DESC";

        if ($limit !== null && $offset !== null) {
            $query .= " LIMIT ? OFFSET ?";
        }

        return $query;
    }


    private function prepareAppointmentsStatement($query, $status, $search, $limit, $offset)
    {
        $stmt = $this->conn->prepare($query);

        $types = "";
        $values = [];

        if ($status !== null) {
            $types .= "s";
            $values[] = $status;
        }

        if ($search !== null) {
            $types .= "sss";
            $likeSearch = '%' . $search . '%';
            $values[] = $likeSearch;
            $values[] = $likeSearch;
            $values[] = $likeSearch;
        }

        if ($limit !== null && $offset !== null) {
            $types .= "ii";
            $values[] = (int)$limit;
            $values[] = (int)$offset;
        }

        if (!empty($types)) {
            $stmt->bind_param($types, ...$values);
        }

        return $stmt;
    }

    private function fetchAppointments($result): array{
        $appointments = [];

        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        return $appointments;
    }

    public function countAppointments($status = null, $search = null): int
    {
        $query = "
        SELECT COUNT(*) as total
        FROM appointments a
        LEFT JOIN doctors d ON a.doctor_id = d.user_id
        LEFT JOIN users du ON d.user_id = du.user_id
        JOIN patients p ON a.patient_id = p.user_id
        JOIN users pu ON p.user_id = pu.user_id
        WHERE 1=1
    ";

        $types = "";
        $values = [];

        if ($status !== null) {
            $query .= " AND a.status = ?";
            $types .= "s";
            $values[] = $status;
        }

        if ($search !== null) {
            $query .= " AND (pu.first_name LIKE ? OR du.first_name LIKE ? OR a.ailment LIKE ?)";
            $types .= "sss";
            $likeSearch = '%' . $search . '%';
            $values[] = $likeSearch;
            $values[] = $likeSearch;
            $values[] = $likeSearch;
        }

        $stmt = $this->conn->prepare($query);
        if (!empty($types)) {
            $stmt->bind_param($types, ...$values);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return (int)($result->fetch_assoc()['total'] ?? 0);
    }

}


