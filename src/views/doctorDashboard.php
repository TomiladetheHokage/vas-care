<?php
require_once __DIR__ . '/../config/constants.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;

if(isset($_SESSION['error'])) $error = $_SESSION['error'];

if ($user['role'] !== 'doctor') {
    header('Location: ' . BASE_URL . '/views/patientDashboard.php');
    exit();
}

$firstName = $user['first_name'];
$pfp = $isLoggedIn && isset($user['profile_picture']) ? $user['profile_picture'] : BASE_URL . '/assets/3.jpg';
//echo $pfp;

//print_r($appointments);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body >
<div class="min-h-screen bg-gray-100 p-6">

    <!-- Profile Section -->
    <div class="flex items-center justify-between bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex items-center space-x-4">
            <img  src="<?php echo BASE_URL; ?>/public/<?php echo $pfp; ?>" alt="Profile Picture" class="w-16 h-16 rounded-full object-cover"
            />
            <div>
                <p class="text-lg font-semibold text-gray-800">Welcome, <?= $user['first_name']?></p>
                <p class="text-sm text-gray-600"><?= $user['email']?></p>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>/adminIndex.php?action=logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
            Logout
        </a>
    </div>

    <!-- Dashboard Summary Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <h3 class="text-sm font-medium text-gray-500">Total Appointments</h3>
            <p class="text-2xl font-bold text-gray-900 mt-2" id="totalAppointments"><?= $statistics ?? 0 ?></p>
        </div>
    </div>

    <form method="GET" action="doctorIndex.php" class="flex flex-wrap gap-4 mb-6">
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timeframe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ailment</th>
<!--                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medical History</th>-->
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Medication</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned By</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['slot_start']) ?> . <?= htmlspecialchars($appointment['slot_end']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['ailment']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['current_medication']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['patient_name']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($appointment['nurse_name']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>





</body>

</html>