<?php

use Owner\VasCare\controller\DoctorController;
use Owner\VasCare\controller\NurseController;
use Owner\VasCare\controller\AppointmentController;

session_start();


require_once __DIR__ . '/config/database.php';
//require_once __DIR__ . '/controller/NurseController.php';
//require_once __DIR__ . '/controller/AppointmentController.php';
require_once __DIR__ . '/controller/DoctorController.php';
require_once __DIR__ . '/dto/response/StatusResponse.php';


$conn = getConnection();
//$nurse = new NurseController($conn);
//$appointment = new AppointmentController($conn);
$doctor = new DoctorController($conn);

$action = $_GET['action'] ?? 'index';


$doctorId = $_SESSION['user']['user_id'] ?? 0;

switch ($action) {
    case 'viewAllAppointments':
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;

        $statistics = $doctor->getAppointmentCount($doctorId);

        $appointments = $doctor->getAssignedAppointments($doctorId);
        $appointmentCount = count($appointments);

        $_SESSION['error'] = $appointments['error'] ?? null;
        $doctors = $doctor->getAllDoctors();
        include __DIR__ . '/views/doctorDashboard.php';
        break;
}