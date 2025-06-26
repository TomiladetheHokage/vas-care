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
$doctorDetails = $_SESSION['doctor'] ?? [];
$availability = $doctorDetails['availability'] ?? 'Unknown';

$doctorDetails = $_SESSION['doctor'] ?? null;

//echo "Current Status: $availability";
//print_r($doctorDetails);

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
<body class="bg-gray-100">
<div class="flex flex-col md:flex-row min-h-screen">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-white shadow-md p-6 space-y-6 sticky top-0 z-50">
        <div class="text-xl font-bold text-indigo-600">
            Welcome Dr, <?php echo $firstName ?>
        </div>

        <!-- Change Status Section -->
        <div class="mt-4 md:mt-10">
            <h2 class="text-sm font-semibold text-gray-600 mb-1">Current Status: <?php echo $availability ?></h2>
            <h2 class="text-sm font-semibold text-gray-600 mb-2">Change Status</h2>
            <form action="<?php echo BASE_URL; ?>/doctorIndex.php?action=updateDoctorStatus" method="POST" class="space-y-2">
                <input type="hidden" name="updateDoctorStatus" value="updateDoctorStatus">
                <select name="availability" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="available">Available</option>
                    <option value="not available">Not Available</option>
                    <option value="off duty">Off Duty</option>
                    <option value="on leave">On Leave</option>
                </select>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">
                    Update Status
                </button>
            </form>
        </div>

        <div class="mt-10">
            <a href="<?php echo BASE_URL; ?>/doctorIndex.php?action=logout"
               class="inline-block w-full bg-red-600 text-white py-3 rounded-xl hover:bg-red-700 transition duration-300 shadow-lg font-semibold text-center select-none">
                Logout
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-6 overflow-x-auto">

        <!-- Summary Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <h3 class="text-sm font-medium text-gray-500">Total Appointments</h3>
                <p class="text-2xl font-bold text-gray-900 mt-2" id="totalAppointments"><?= $statistics ?? 0 ?></p>
            </div>
        </div>

        <!-- Search & Filter -->
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

        <!-- Error Message -->
        <?php if (isset($appointments['error'])): ?>
            <p class="text-red-600"><?= htmlspecialchars($appointments['error']) ?></p>
        <?php endif; ?>

        <!-- Appointments Table -->
        <?php if (empty($appointments)): ?>
            <div class="text-center text-gray-500 text-lg">
                No Appointments found.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Appointment Date</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Timeframe</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Ailment</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Current Medication</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Patient Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Assigned By</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($appointment['slot_start']) ?> - <?= htmlspecialchars($appointment['slot_end']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($appointment['ailment']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($appointment['current_medication']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($appointment['patient_name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($appointment['nurse_name']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </main>
</div>
</body>




</html>