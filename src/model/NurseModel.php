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



    public function cancelAppointment(int $appointmentId): AppointmentResponse {
        // Check if appointment exists
        $stmt = $this->conn->prepare("SELECT status FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return new AppointmentResponse("Appointment not found", false);
        }

        $appointment = $result->fetch_assoc();

        if ($appointment['status'] === 'cancelled') {
            return new AppointmentResponse("Appointment already cancelled", false);
        }

        // Update appointment to cancelled and remove assigned doctor and nurse
        $stmt = $this->conn->prepare("
        UPDATE appointments
        SET status = 'cancelled', doctor_id = NULL, assigned_by = NULL
        WHERE appointment_id = ?
    ");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return new AppointmentResponse("Appointment cancelled and doctor unassigned", true);
        }

        return new AppointmentResponse("Failed to cancel appointment", false);
    }


//    EDIT TIME AND ASSIGN TIME BOTH GIVE THE USER APPOINTMENT TIME FIX THAT

    public function editTimeSlotOfAppointment(int $appointmentId, ?string $appointmentDate, string $slotStart, string $slotEnd): AppointmentResponse {
        // Check if the appointment exists
        $stmt = $this->conn->prepare("SELECT appointment_id FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return new AppointmentResponse("Appointment not found", false);
        }

        if ($appointmentDate !== null && $appointmentDate !== '') {
            // Update appointment_date along with slot times
            $stmt = $this->conn->prepare("
            UPDATE appointments 
            SET appointment_date = ?, slot_start = ?, slot_end = ? 
            WHERE appointment_id = ?
        ");
            $stmt->bind_param("sssi", $appointmentDate, $slotStart, $slotEnd, $appointmentId);
        } else {
            // Update only the slot times
            $stmt = $this->conn->prepare("
            UPDATE appointments 
            SET slot_start = ?, slot_end = ? 
            WHERE appointment_id = ?
        ");
            $stmt->bind_param("ssi", $slotStart, $slotEnd, $appointmentId);
        }

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return new AppointmentResponse("Time slot updated successfully", true);
        }

        return new AppointmentResponse("Failed to update time slot", false);
    }


    public function assignTimeSlotToAppointment(int $appointmentId, ?string $appointmentDate, string $slotStart, string $slotEnd): AppointmentResponse {
        // Check if the appointment exists
        $stmt = $this->conn->prepare("SELECT appointment_id, slot_start, slot_end FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return new AppointmentResponse("Appointment not found", false);
        }

        $appointment = $result->fetch_assoc();

        // If a valid time slot is already set, prevent reassignment
        if (
            $appointment['slot_start'] !== null && $appointment['slot_start'] !== '00:00:00' &&
            $appointment['slot_end'] !== null && $appointment['slot_end'] !== '00:00:00'
        ) {
            return new AppointmentResponse("Time slot already assigned", false);
        }

        if ($appointmentDate !== null && $appointmentDate !== '') {
            // Update appointment_date along with slot times
            $stmt = $this->conn->prepare("
            UPDATE appointments 
            SET appointment_date = ?, slot_start = ?, slot_end = ? 
            WHERE appointment_id = ?
        ");
            $stmt->bind_param("sssi", $appointmentDate, $slotStart, $slotEnd, $appointmentId);
        } else {
            // Update only the slot times
            $stmt = $this->conn->prepare("
            UPDATE appointments 
            SET slot_start = ?, slot_end = ? 
            WHERE appointment_id = ?
        ");
            $stmt->bind_param("ssi", $slotStart, $slotEnd, $appointmentId);
        }

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return new AppointmentResponse("Time slot assigned successfully", true);
        }

        return new AppointmentResponse("Failed to assign time slot", false);
    }



    public function rescheduleAppointment($appointmentId, $doctorId, $nurseId, $newDate, $newStart, $newEnd): AppointmentResponse {
        if (!$this->isNurseActive($nurseId)) return new AppointmentResponse('Nurse is not active', false);

        if (!$this->isDoctorAvailable($doctorId)) return new AppointmentResponse('Doctor not available', false);


        if ($this->isDoctorBookedAtSlot($doctorId, $newDate, $newStart, $newEnd)) return new AppointmentResponse('Doctor already has an appointment at that time', false);

        if ($this->updateSchedule($appointmentId, $doctorId, $nurseId, $newDate, $newStart, $newEnd)) return new AppointmentResponse('Appointment rescheduled successfully', true);

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


    public function assignDoctorToAppointment($doctorId, $appointmentId, $nurseId): AppointmentResponse|StatusResponse {
        $stmt = $this->conn->prepare("SELECT appointment_date, slot_start, slot_end, status FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return new AppointmentResponse('Appointment ' . $appointmentId . ' not found', false);
        }

        $appointment = $result->fetch_assoc();

        if ($appointment['status'] === 'cancelled') {
            return new AppointmentResponse('Cannot assign doctor to a cancelled appointment', false);
        }

        if (!$this->hasTimeSlotAssigned($appointmentId)) {
            return new AppointmentResponse('Cannot assign doctor: time slot not allotted', false);
        }

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

        if ($this->isDoctorBookedAtSlot($doctorId, $appointmentDate, $slotStart, $slotEnd)) {
            return new AppointmentResponse('Doctor already has an appointment at that time', false);
        }

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


    public function countAppointments(string $status = null): int {
        if ($status) {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE status = ?");
            $stmt->bind_param("s", $status);
        } else {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM appointments");
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc()['total'] ?? 0;
        $stmt->close();

        return $count;
    }

    private function hasTimeSlotAssigned($appointmentId): bool {
        $stmt = $this->conn->prepare("SELECT slot_start, slot_end FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) return false;

        $appointment = $result->fetch_assoc();
        return !empty($appointment['slot_start']) && !empty($appointment['slot_end']);
    }





}
