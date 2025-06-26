<?php

//    UPDATES:
//SEE HOW MANY APPOINTMENTS DOC HAS COMPLETED TO TRACK WHERTHER HE IS WORKING
namespace Owner\VasCare\model;

use Owner\VasCare\dto\response\StatusResponse;

class DoctorModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getDoctorByUserId($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM doctors WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }



    public function updateAvailability($doctorId, $availability): StatusResponse|bool
    {
        if (!$this->isDoctorActive($doctorId)) {
            return new StatusResponse("Doctor is deactivated", false);
        }

        $stmt = $this->conn->prepare("UPDATE doctors SET availability = ? WHERE user_id = ?");
        $stmt->bind_param("si", $availability, $doctorId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    private function isDoctorActive($doctorId): bool {
        $stmt = $this->conn->prepare("SELECT status FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) return $row['status'] === 'active';
        return false;
    }

    public function getAllDoctors(): array
    {
        $sql = "
        SELECT
            d.user_id,
            u.first_name,
            u.last_name,
            d.availability,
            u.status,
            d.specialization
        FROM doctors d
        JOIN users u ON d.user_id = u.user_id
        WHERE d.availability = 'available'
    ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return array();

        $stmt->execute();
        $result = $stmt->get_result();

        $doctors = array();
        while ($row = $result->fetch_assoc()) {
            $doctors[] = array(
                'user_id'        => $row['user_id'],
                'first_name'     => $row['first_name'],
                'last_name'      => $row['last_name'],
                'availability'   => $row['availability'],
                'status'         => $row['status'],
                'specialization' => $row['specialization'],
            );
        }
        return $doctors;
    }


    public function countAppointmentsByStatus($doctorId, string $status): int {
        $stmt = $this->conn->prepare("
        SELECT COUNT(*) as total 
        FROM appointments 
        WHERE doctor_id = ? AND status = ?
    ");
        $stmt->bind_param("is", $doctorId, $status);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'] ?? 0;
    }



    public function getAssignedAppointments($doctorId): StatusResponse|array {
        $stmt = $this->conn->prepare("
       SELECT 
    a.appointment_id,
    a.appointment_date,
    a.slot_start,
    a.slot_end,
    a.ailment,
    a.medical_history,
    a.current_medication,
    a.comments,
    a.status,

    -- Patient info
    pu.first_name AS patient_first_name,
    pu.last_name AS patient_last_name,
    pu.email AS patient_email,
    pu.phone_number AS patient_phone,
    pu.gender AS patient_gender,
    pu.profile_picture AS patient_profile_picture,

    -- Nurse info
    nu.first_name AS nurse_first_name,
    nu.last_name AS nurse_last_name

        FROM appointments a
        JOIN users pu ON a.patient_id = pu.user_id
        JOIN users nu ON a.assigned_by = nu.user_id
        WHERE a.doctor_id = ?
    ");

        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();

        $appointments = [];

        while ($row = $result->fetch_assoc()) {
            $appointments[] = [
                'appointment_id'     => $row['appointment_id'],
                'appointment_date'   => $row['appointment_date'],
                'slot_start'         => $row['slot_start'],
                'slot_end'           => $row['slot_end'],
                'ailment'            => $row['ailment'],
                'medical_history'    => $row['medical_history'],
                'current_medication' => $row['current_medication'],
                'comments'           => $row['comments'],
                'status'             => $row['status'],

                'patient_name'       => $row['patient_first_name'] . ' ' . $row['patient_last_name'],
                'patient_email'      => $row['patient_email'],
                'patient_phone'      => $row['patient_phone'],
                'patient_gender'     => $row['patient_gender'],
                'patient_profile_picture' => $row['patient_profile_picture'],

                'nurse_name'         => $row['nurse_first_name'] . ' ' . $row['nurse_last_name']
            ];

        }

        return $appointments;
    }


}
?>