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

    public function getUserStatistics(): array {
        return [
            'total_appointments' => $this->nurseModel->countAllAppointments(),
            'total_cancelled_appointments' => $this->nurseModel->countAllCancelledAppointments(),
            'total_completed_appointments' => $this->nurseModel->countAllCompletedAppointments(),
            'total_confirmed_appointments' => $this->nurseModel->countAllConfirmedAppointments(),
            'total_denied_appointments' => $this->nurseModel->countAllDeniedAppointments(),
            'total_pending_appointments' => $this->nurseModel->countAllPendingAppointments(),
        ];
    }


}