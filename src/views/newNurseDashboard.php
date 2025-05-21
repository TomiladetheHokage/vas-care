<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;

if(isset($_SESSION['error'])) $error = $_SESSION['error'];


if ($user['role'] !== 'nurse') {
    header('Location: /vas-care/src/views/dashboard.php');
    exit();
}

$selectedDoctorId = $_SESSION['selectedDoctorId'] ?? null;


$pfp = $isLoggedIn && isset($user['profile_picture']) ? $user['profile_picture'] : '/vas-care/src/assests/3.jpg';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body >
<div class="min-h-screen bg-gray-100 p-6">

    <!-- Profile Section -->
    <div class="flex items-center justify-between bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex items-center space-x-4">
            <img  src="<?= '/vas-care/src/public/' . $pfp ?>" alt="Profile Picture" class="w-16 h-16 rounded-full object-cover"
            />
            <div>
                <p class="text-lg font-semibold text-gray-800">Welcome, <?= $user['first_name']?></p>
                <p class="text-sm text-gray-600"><?= $user['email']?></p>
            </div>
        </div>
        <a href="/vas-care/src/adminIndex.php?action=logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
            Logout
        </a>
    </div>

    <!-- Dashboard Summary Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <h3 class="text-sm font-medium text-gray-500">Total Appointments</h3>
            <p class="text-2xl font-bold text-gray-900 mt-2" id="totalAppointments"><?= $statistics['total_appointments'] ?? 0 ?></p>
        </div>
        <div class="bg-yellow-100 rounded-lg shadow p-4 text-center">
            <h3 class="text-sm font-medium text-yellow-700">Pending</h3>
            <p class="text-2xl font-bold text-yellow-700 mt-2" id="totalPending"><?= $statistics['total_pending_appointments'] ?? 0 ?></p>
        </div>
        <div class="bg-red-100 rounded-lg shadow p-4 text-center">
            <h3 class="text-sm font-medium text-red-700">Cancelled</h3>
            <p class="text-2xl font-bold text-red-700 mt-2" id="totalCancelled"><?= $statistics['total_cancelled_appointments'] ?? 0 ?></p>
        </div>
        <div class="bg-green-100 rounded-lg shadow p-4 text-center">
            <h3 class="text-sm font-medium text-green-700">Confirmed</h3>
            <p class="text-2xl font-bold text-green-700 mt-2" id="totalCompleted"><?= $statistics['total_confirmed_appointments'] ?? 0 ?></p>
        </div>
        <div class="bg-gray-200 rounded-lg shadow p-4 text-center">
            <h3 class="text-sm font-medium text-gray-700">Denied</h3>
            <p class="text-2xl font-bold text-gray-700 mt-2" id="totalDenied"><?= $statistics['total_denied_appointments'] ?? 0 ?></p>
        </div>
    </div>

    <form method="GET" action="nurseIndex.php" class="flex flex-wrap gap-4 mb-6">
        <input type="hidden" name="action" value="viewAllAppointments" />
        <input
                type="text"
                name="search"
                placeholder="Search appointments..."
                class="flex-grow border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        />

        <select
                name="status"
                class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
            <option value="">Filter by Status</option>
            <option value="pending" <?= (($_GET['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
            <option value="confirmed" <?= (($_GET['status'] ?? '') === 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
            <option value="cancelled" <?= (($_GET['status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
            <option value="denied" <?= (($_GET['status'] ?? '') === 'denied') ? 'selected' : '' ?>>Denied</option>
        </select>

        <button
                type="submit"
                class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition"
        >
            Search
        </button>
    </form>


    <?php if (isset($appointments['error'])): ?>
    <p class="text-red-600"><?= htmlspecialchars($appointments['error']) ?></p>
    <?php endif; ?>


    <?php if (empty($appointments)): ?>
        <div class="text-center text-gray-500 text-lg">
            No Appointments found.
        </div>
    <?php else: ?>
    <!-- Appointments Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slot start</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slot end</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ailment</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medical History</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Medication</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Doctor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Update Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assign Doctor</th>

            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            <?php foreach ($appointments as $appointment): ?>
                <?php
                if (!is_array($appointment)) continue;
                $status = strtolower($appointment['status']);

//                $appointmentId = $appointment['appointment_id'];
//                echo $appointmentId;

                [$colorClass, $iconClass] = match ($status) {
                    'confirmed' => ['text-green-600', 'fa-solid fa-circle-check'],
                    'pending' => ['text-yellow-600', 'fa-solid fa-hourglass-half'],
                    'cancelled' => ['text-red-600', 'fa-solid fa-circle-xmark'],
                    'denied' => ['text-gray-500', 'fa-solid fa-ban'],
                    default => ['text-black', 'fa-solid fa-question-circle'],
                };
                ?>
                <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['patient_first_name']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['slot_start']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['slot_end']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['ailment']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['medical_history']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['current_medication']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?php
                        if (!empty($appointment['doctor_first_name'])) {
                            echo 'Dr. ' . htmlspecialchars($appointment['doctor_first_name']);
                        } else {
                            echo 'Not Assigned';
                        }
                        ?>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold <?= $colorClass ?>">
                        <i class="<?= $iconClass ?> mr-1"></i>
                        <?= ucfirst($appointment['status']) ?>
                    </td>
                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900">
                        <form action="/vas-care/src/nurseIndex.php?action=updateStatus" method="POST">
                            <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                            <select name="status" class="border rounded px-2 py-1" onchange="this.form.submit()">
                                <?php
                                $statuses = ['cancelled', 'completed', 'denied'];
                                foreach ($statuses as $status):
                                    ?>
                                    <option value="<?= $status ?>" <?= $appointment['status'] === $status ? 'selected' : '' ?>>
                                        <?= ucfirst($status) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <form method="POST" action="/vas-care/src/nurseIndex.php?action=assignDoctor">
                            <select name="doctor_id" class="border border-gray-300 rounded-md p-1 w-full" onchange="this.form.submit()">
                                <?php foreach ($doctors as $doctor): ?>
                                    <option value="<?= $doctor['user_id'] ?>" <?= ($selectedDoctorId == $doctor['user_id']) ? 'selected' : '' ?>>
                                        Dr. <?= htmlspecialchars($doctor['first_name']) ?> <?= htmlspecialchars($doctor['last_name']) ?> (<?= htmlspecialchars($doctor['specialization']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                            <input type="hidden" name="nurse_id" value="<?= $user['user_id'] ?>"> <!-- Or use session -->
                        </form>
                    </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php if (isset($_SESSION['AssignError'])): ?>
    <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 mx-4">
            <h2 class="text-red-600 text-xl font-semibold mb-4">Error</h2>
            <p class="mb-6 text-gray-800"><?= htmlspecialchars($_SESSION['AssignError']) ?></p>
            <button id="closeErrorModal" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                Close
            </button>
        </div>
    </div>
    <script>
        document.getElementById('closeErrorModal').addEventListener('click', () => {
            document.getElementById('errorModal').style.display = 'none';
        });
        document.getElementById('errorModal').addEventListener('click', (e) => {
            if (e.target.id === 'errorModal') {
                document.getElementById('errorModal').style.display = 'none';
            }
        });
    </script>
    <?php unset($_SESSION['AssignError']); endif; ?>
<script>
    document.querySelector("select[name='doctor_id']").addEventListener("change", function() {
        this.form.submit(); // Auto-submit form when selection changes
    });
</script>



<script>
    function logout() {
        alert('Logging out...');
        window.location.href = 'logout.php';
    }
</script>



</body>

</html>