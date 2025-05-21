<?php

namespace Owner\VasCare\model;

use mysqli;
use Owner\VasCare\controller\UserController;
use Owner\VasCare\dto\response\StatusResponse;
use src\dto\response\RegisterResponse;

require_once __DIR__ . '/../controller/UserController.php';

class AdminModel {
    private mysqli $conn;
    private UserController $userController;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
        $this->userController = new UserController($conn);
    }


    public function viewAllUsers(): array{
        $result = $this->conn->query("SELECT * FROM users");
        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    public function addStaffMember(array $data, string $role): RegisterResponse {
        $data['role'] = $role;

        if ($response = $this->userController->register($data)) {
            $userId = $response->user_id;

            if (!$response->success) return new RegisterResponse(false, $response->message);

            if ($role === 'doctor') $this->insertIntoDoctor($userId, $data);
            elseif ($role === 'nurse') $this->insertIntoNurse($userId, $data);

            return new RegisterResponse(true, "Staff has been registered", $userId);
        }

        return new RegisterResponse(false, "Failed to register");
    }


    public function updateUserStatus(int $userId, string $status): StatusResponse{
        $stmt = $this->conn->prepare("UPDATE users SET status = ? WHERE user_id = ?");
        $stmt->bind_param("si", $status, $userId);

        if ($stmt->execute()) return new StatusResponse("User status has been updated",  true);

        return new StatusResponse("Failed to update status: " . $stmt->error, false);
    }


    private function insertIntoDoctor(int $userId, array $data): bool {
        $stmt = $this->conn->prepare("INSERT INTO doctors (user_id, specialization, availability) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $data['specialization'], $data['availability']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    private function insertIntoNurse(int $userId, array $data): bool {
        $stmt = $this->conn->prepare("INSERT INTO nurses (user_id, shift) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $data['shift']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function viewUsersByFilter(?string $role, ?string $status, ?string $search, int $page = 1, int $limit = 10): array {
        $offset = ($page - 1) * $limit;
        $conditions = [];
        $params = [];
        $types = '';

        if ($role) {
            $conditions[] = 'role = ?';
            $params[] = $role;
            $types .= 's';
        }

        if ($status) {
            $conditions[] = 'status = ?';
            $params[] = $status;
            $types .= 's';
        }

        if ($search) {
            $conditions[] = '(first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)';
            $searchTerm = "%$search%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= 'sss';
        }

        $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM users $where LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        // Get total count
        $totalResult = $this->conn->query("SELECT FOUND_ROWS() as total");
        $total = $totalResult->fetch_assoc()['total'];

        return ['users' => $users, 'total' => $total];
    }


    public function countAllUsers(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM users");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countAllDoctors(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'doctor'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countAllPatients(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'patient'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countAllNurses(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'nurse'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countActiveUsers(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE status = 'active'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countInactiveUsers(): int {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE status = 'inactive'");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countUsers(string $column = '', string $value = '') {
        $query = "SELECT COUNT(*) as total FROM users";

        if ($column && $value) {
            $query .= " WHERE $column = '$value'";
        }

        $result = $this->conn->query($query);
        return $result->fetch_assoc()['total'] ?? 0;
    }


}
