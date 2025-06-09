<?php

namespace Owner\VasCare\controller;

use dto\response\AppointmentResponse;
use Owner\VasCare\model\DoctorModel;
use mysqli_sql_exception;
require_once __DIR__ . '/../model/DoctorModel.php';
class DoctorController{
    private $doctorModel;

    public function __construct($conn){
        $this->doctorModel =  new DoctorModel($conn);
    }

    public function updateAvailability($doctorId, $availability){
        return $this->doctorModel->updateAvailability($doctorId, $availability);
    }

    public function getAllDoctors(){
        return $this->doctorModel->getAllDoctors();
    }

    public function getAssignedAppointments($doctorId){
        return $this->doctorModel->getAssignedAppointments($doctorId);
    }

    public function getAppointmentCount($doctorId){
        return $this->doctorModel->countAllAppointments($doctorId);
    }




}