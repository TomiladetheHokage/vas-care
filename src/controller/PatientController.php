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

}