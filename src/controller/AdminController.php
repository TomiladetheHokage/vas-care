<?php

namespace Owner\VasCare\controller;

use Owner\VasCare\model\AdminModel;
use Owner\VasCare\dto\response\StatusResponse;
use src\dto\response\RegisterResponse;

require_once __DIR__ . '/../model/AdminModel.php';
require_once __DIR__ . '/../dto/response/StatusResponse.php';

class AdminController
{
    private AdminModel $adminModel;

    public function __construct($conn){
        $this->adminModel = new AdminModel($conn);
    }

    public function addStaffMember(array $data, string $role): RegisterResponse{
        $requiredFields = ['first_name', 'last_name', 'email', 'password'];
        $validation = $this->validateFields($data, $requiredFields);

        if (!$validation['valid']) return new RegisterResponse(false, $validation['message']);

        $data = $this->sanitizeArray($data);

        return $this->adminModel->addStaffMember($data, $role);
    }


    public function updateUserStatus(int $userId, string $status): StatusResponse{
        return $this->adminModel->updateUserStatus($userId, $status);
    }

    public function getPaginatedUsers(array $filters, int $page = 1, int $limit = 10): array {
        return $this->adminModel->viewUsersByFilter($filters['role'] ?? null, $filters['status'] ?? null, $filters['search'] ?? null, $page, $limit);
    }


    private function validateFields(array $data, array $requiredFields): array{
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                return [
                    'valid' => false,
                    'message' => "Missing or empty required field: $field"
                ];
            }
        }
        return ['valid' => true];
    }

    private function sanitizeArray(array $data): array{
        foreach ($data as $key => $value) {
            if (is_string($value)) $data[$key] = htmlspecialchars(trim($value));
        }
        return $data;
    }

    public function getUserStatistics(): array {
        return [
            'total_users' => $this->adminModel->countAllUsers(),
            'total_doctors' => $this->adminModel->countAllDoctors(),
            'total_nurses' => $this->adminModel->countAllNurses(),
            'active_users' => $this->adminModel->countActiveUsers(),
            'inactive_users' => $this->adminModel->countInactiveUsers(),
        ];
    }

    public function getUserStatisticss(): array {
        return [
            'total_users' => $this->adminModel->countAllUsers(),
            'total_doctors' => $this->adminModel->countUsers('role', 'doctor'),
            'total_nurses' => $this->adminModel->countUsers('role', 'nurse'),
            'active_users' => $this->adminModel->countUsers('status', 'active'),
            'inactive_users' => $this->adminModel->countUsers('status', 'inactive'),
        ];
    }



}
