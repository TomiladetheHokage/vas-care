<?php

namespace Owner\VasCare\controller;

use Owner\VasCare\model\AppointmentModel;
use dto\response\AppointmentResponse;
use mysqli_sql_exception;

require_once __DIR__ . '/../model/AppointmentModel.php';

class AppointmentController {
    private AppointmentModel $appointmentModel;

    public function __construct($dbConnection) {
        $this->appointmentModel = new AppointmentModel($dbConnection);
    }

    public function createAppointment($data): AppointmentResponse {
        $validation = $this->validateAppointmentData($data);
        if ($validation !== true) return new AppointmentResponse($validation, false);

        $success = $this->appointmentModel->create($data);
        return $success
            ? new AppointmentResponse('Appointment created successfully', true)
            : new AppointmentResponse('Failed to create appointment', false);
    }

    public function getAppointments($status = null, $search = null): array {
        if (empty($status)) $status = null;

        if ($status !== null && !in_array($status, ['pending', 'approved', 'cancelled', 'completed', 'confirmed'])) {
            return ['error' => 'Invalid status value'];
        }

        return $this->appointmentModel->getAppointmentsByStatus($status, $search);
    }


    private function validateAppointmentData($data): string|bool {
        $requiredFields = ['patient_id', 'date', 'ailment', 'medical_history', 'current_medication'];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) return "Missing required field: $field";
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date'])) return "Invalid date format. Use YYYY-MM-DD.";
        return true;
    }

    public function updateAppointment($appointmentId, $status){
        return $this->appointmentModel->updateStatus($appointmentId, $status);
    }
}
