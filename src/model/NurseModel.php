<?php

namespace model;

use dto\response\AppointmentResponse;
use Owner\VasCare\dto\response\StatusResponse;
use Owner\VasCare\model\AppointmentModel;

require_once __DIR__ . '/../model/AppointmentModel.php';

class NurseModel {
    private $conn;
    private $appointmentModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->appointmentModel = new AppointmentModel($conn);
    }

    public function rescheduleAppointment(
        $appointmentId,
        $doctorId,
        $nurseId,
        $newDate,
        $newStart,
        $newEnd
    ): AppointmentResponse {
        if (!$this->isNurseActive($nurseId)) {
            return new AppointmentResponse('Nurse is not active', false);
        }

        if (!$this->isDoctorAvailable($doctorId)) {
            return new AppointmentResponse('Doctor not available', false);
        }

        if ($this->isDoctorBookedAtSlot($doctorId, $newDate, $newStart, $newEnd)) {
            return new AppointmentResponse('Doctor already has an appointment at that time', false);
        }

        if ($this->updateSchedule($appointmentId, $doctorId, $nurseId, $newDate, $newStart, $newEnd)) {
            return new AppointmentResponse('Appointment rescheduled successfully', true);
        }

        return new AppointmentResponse('Failed to reschedule appointment', false);
    }


    private function updateSchedule($appointmentId, $doctorId, $nurseId, $newDate, $newStart, $newEnd): bool {
        $stmt = $this->conn->prepare("
        UPDATE appointments 
        SET doctor_id = ?, assigned_by = ?, appointment_date = ?, slot_start = ?, slot_end = ? 
        WHERE appointment_id = ?
    ");
        $stmt->bind_param("issssi", $doctorId, $nurseId, $newDate, $newStart, $newEnd, $appointmentId);

        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


//    Nurse should adjust appointment time
    public function assignDoctorToAppointment($doctorId, $appointmentId, $nurseId): AppointmentResponse| StatusResponse {
        // Get existing appointment time
        $stmt = $this->conn->prepare("SELECT appointment_date, slot_start, slot_end FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return new AppointmentResponse('Appointment ' . $appointmentId . ' not found', false);
        }

        $appointment = $result->fetch_assoc();
        $appointmentDate = $appointment['appointment_date'];
        $slotStart = $appointment['slot_start'];
        $slotEnd = $appointment['slot_end'];

        if (!$this->isNurseActive($nurseId)) {
            return new StatusResponse("Nurse is deactivated bro", false);
        }

        if (!$this->isDoctorAvailable($doctorId)) {
            return new AppointmentResponse('Doctor not available', false);
        }


        // Check doctor availability
        if ($this->isDoctorBookedAtSlot($doctorId, $appointmentDate, $slotStart, $slotEnd)) {
            return new AppointmentResponse('Doctor already has an appointment at that time', false);
        }

        // Perform assignment
        if ($this->assign($appointmentId, $doctorId, $nurseId, $appointmentDate, $slotStart, $slotEnd)) {
            return new AppointmentResponse('Appointment assigned and scheduled', true);
        }

        return new AppointmentResponse('Appointment not assigned', false);
    }




    private function isDoctorAvailable($doctorId): bool {
        $stmt = $this->conn->prepare("SELECT availability FROM doctors WHERE user_id = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) return false;

        $doctor = $result->fetch_assoc();
        return $doctor['availability'] === 'available';
    }


    private function isDoctorBookedAtSlot($doctorId, $appointmentDate, $slotStart, $slotEnd): bool {
        $stmt = $this->conn->prepare("
        SELECT * FROM appointments 
        WHERE doctor_id = ? 
          AND appointment_date = ?
          AND (
              (slot_start < ? AND slot_end > ?)  -- overlapping slot
          )
    ");
        $stmt->bind_param("isss", $doctorId, $appointmentDate, $slotEnd, $slotStart);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }




    private function assign($appointmentId, $doctorId, $nurseId, $appointmentDate, $slotStart, $slotEnd): bool {
        $stmt = $this->conn->prepare("
        UPDATE appointments 
        SET doctor_id = ?, assigned_by = ?, appointment_date = ?, slot_start = ?, slot_end = ?, status = 'confirmed' 
        WHERE appointment_id = ?
    ");
        $stmt->bind_param("iisssi", $doctorId, $nurseId, $appointmentDate, $slotStart, $slotEnd, $appointmentId);

        $stmt->execute();
        return $stmt->affected_rows > 0;
    }



    private function isNurseActive($nurseId): bool {
        $stmt = $this->conn->prepare("SELECT status FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $nurseId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row && $row['status'] === 'active';
    }

    public function countAllAppointments(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM appointments");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countAllPendingAppointments(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM appointments WHERE status = 'pending'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countAllConfirmedAppointments(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM appointments WHERE status = 'confirmed'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countAllCancelledAppointments(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM appointments WHERE status = 'cancelled'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countAllCompletedAppointments(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM appointments WHERE status = 'completed'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countAllDeniedAppointments(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM appointments WHERE status = 'denied'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

//    public function getAppointmentsWithDetailsByStatus(?string $status = null, ?string $search = null): array
//    {
//        $query = "
//        SELECT a.*,
//               d.user_id AS doctor_user_id, du.first_name AS doctor_first_name,
//               p.user_id AS patient_user_id, pu.first_name AS patient_first_name
//        FROM appointments a
//        LEFT JOIN doctors d ON a.doctor_id = d.user_id
//        LEFT JOIN users du ON d.user_id = du.user_id
//        JOIN patients p ON a.patient_id = p.user_id
//        JOIN users pu ON p.user_id = pu.user_id
//        WHERE 1=1
//    ";
//
//        $params = [];
//        $types = "";
//
//        if ($status) {
//            $query .= " AND a.status = ?";
//            $params[] = $status;
//            $types .= "s";
//        }
//
//        if ($search) {
//            $query .= " AND (a.ailment LIKE ? OR pu.first_name LIKE ? OR du.first_name LIKE ?)";
//            $like = "%$search%";
//            $params[] = $like;
//            $params[] = $like;
//            $params[] = $like;
//            $types .= "sss";
//        }
//
//        $stmt = $this->conn->prepare($query);
//
//        if (!empty($params)) {
//            $stmt->bind_param($types, ...$params);
//        }
//
//        $stmt->execute();
//        $result = $stmt->get_result();
//
//        return $this->appointmentModel->getAppointmentsWithDetailsByStatus(($result));
//    }


}
