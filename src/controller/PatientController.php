<?php

namespace Owner\VasCare\controller;

use dto\response\AppointmentResponse;
use Owner\VasCare\model\PatientModel;

require_once __DIR__ . '/AppointmentController.php';
require_once __DIR__ . '/../model/PatientModel.php';
require_once __DIR__ . '/../dto/response/StatusResponse.php';
class PatientController{

    private $conn;
    private $patientModel;

    public function __construct($conn){
        $this->conn = $conn;
        $this->patientModel = new PatientModel($conn);
    }

    public function createAppointment($data){
        return $this->patientModel->createAppointment($data);
    }

    public function getAppointments(int $patientId, ?string $status = null, ?string $search = null): array {
        return $this->patientModel->getAppointments($patientId, $status, $search);
    }

    public function getUserStatistics(int $patientId): array {
        return [
            'total_appointments' => $this->patientModel->countAppointmentsByStatus($patientId),
            'total_cancelled_appointments' => $this->patientModel->countAppointmentsByStatus($patientId, 'cancelled'),
            'total_completed_appointments' => $this->patientModel->countAppointmentsByStatus($patientId, 'completed'),
            'total_confirmed_appointments' => $this->patientModel->countAppointmentsByStatus($patientId, 'confirmed'),
            'total_denied_appointments' => $this->patientModel->countAppointmentsByStatus($patientId, 'denied'),
            'total_pending_appointments' => $this->patientModel->countAppointmentsByStatus($patientId, 'pending'),
        ];
    }

    public function editAppointment(array $data) {
        return $this->patientModel->editAppointment($data);
    }


}