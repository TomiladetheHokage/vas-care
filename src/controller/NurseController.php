<?php

namespace Owner\VasCare\controller;
use dto\response\AppointmentResponse;
use model\NurseModel;
use Owner\VasCare\model\AppointmentModel;
use mysqli_sql_exception;
require_once __DIR__ . '/../model/NurseModel.php';
require_once __DIR__ . '/../dto/response/AppointmentResponse.php';
class NurseController{
    private $nurseModel;

    public function __construct($conn) {
        $this->nurseModel = new NurseModel($conn);
    }

    public function assignDoctor($doctorId, $appointmentId, $nurseId) {
        return $this->nurseModel->assignDoctorToAppointment($doctorId, $appointmentId, $nurseId);
    }

    public function editTimeSlot(int $appointmentId, ?string $appointmentDate, string $slotStart, string $slotEnd): AppointmentResponse {
        return $this->nurseModel->editTimeSlotOfAppointment($appointmentId, $appointmentDate, $slotStart, $slotEnd);
    }


    public function assigntimeToAppointment($appointmentId, $appointmentDate, $slotStart, $slotEnd) {
        $response = $this->nurseModel->assignTimeSlotToAppointment($appointmentId, $appointmentDate, $slotStart, $slotEnd);
        if (!$response->success) {
            return new AppointmentResponse($response->message, false);
        }
        return new AppointmentResponse($response->message, true);
    }

    public function getUserStatistics(): array {
        return [
            'total_appointments' => $this->nurseModel->countAppointments(),
            'total_cancelled_appointments' => $this->nurseModel->countAppointments('cancelled'),
            'total_completed_appointments' => $this->nurseModel->countAppointments('completed'),
            'total_confirmed_appointments' => $this->nurseModel->countAppointments('confirmed'),
            'total_denied_appointments' => $this->nurseModel->countAppointments('denied'),
            'total_pending_appointments' => $this->nurseModel->countAppointments('pending'),
        ];
    }

    public function cancelAppointment(int $appointmentId): AppointmentResponse {
        return $this->nurseModel->cancelAppointment($appointmentId);
    }
}