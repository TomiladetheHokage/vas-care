<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../config/constants.php';

$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;

$firstName = $isLoggedIn ? htmlspecialchars($user['first_name']) : '';
$email = $isLoggedIn ? htmlspecialchars($user['email']) : '';
$role = $isLoggedIn ? htmlspecialchars($user['role']) : '';
$profile_picture = !empty($user['profile_picture']) ? $user['profile_picture'] : '/vas-care/src/assets/3.jpg';
$error = $_SESSION['error'] ?? null;

if ($role !== 'patient') {
    include __DIR__ . '/../components/landingPage.php';
    exit();
}


if (!$isLoggedIn) {
    include '../components/landingPage.php';
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Patient Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Sidebar Toggle Button (Hamburger/Panel) -->
<button id="sidebarToggle" class="fixed top-4 left-4 z-50 bg-white p-2 rounded-full shadow-md border border-gray-200 md:hidden">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left-close-icon lucide-panel-left-close"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="m16 15-3-3 3-3"/></svg>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r shadow-lg flex flex-col transition-transform duration-300 transform -translate-x-full md:translate-x-0">
    <!-- Close Button (Panel) -->
    <button id="sidebarClose" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <!-- Logo -->
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-xl font-bold text-blue-600">Vascare</h2>
    </div>

    <!-- Profile Section -->
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-900">Welcome,</h3>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($firstName) ?></p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="<?= BASE_URL; ?>/index.php?action=viewAllAppointments" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>
<!--        <a href="/appointments" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="calendar-check" class="w-5 h-5"></i>-->
<!--            <span>My Appointments</span>-->
<!--        </a>-->
<!--        <a href="/medical-records" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="file-text" class="w-5 h-5"></i>-->
<!--            <span>Medical Records</span>-->
<!--        </a>-->
<!--        <a href="/billing" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="credit-card" class="w-5 h-5"></i>-->
<!--            <span>Billing</span>-->
<!--        </a>-->
<!--        <a href="/messages" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="message-square" class="w-5 h-5"></i>-->
<!--            <span>Messages</span>-->
<!--        </a>-->
        <button onclick="document.getElementById('editProfileModal').classList.remove('hidden')"
                class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="user-circle" class="w-5 h-5"></i>
            <span>Edit Profile</span>
        </button>
        <a href="/settings" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="settings" class="w-5 h-5"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- Logout Section -->
    <div class="px-4 py-4 border-t border-gray-100">
        <a href="<?php echo BASE_URL; ?>/index.php?action=logout" class="flex items-center gap-3 px-3 py-2 w-full rounded-md text-red-600 hover:bg-red-50">
            <i data-lucide="log-out" class="w-5 h-5"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="pt-20 md:pt-10 md:ml-64 px-4 sm:px-6 lg:px-8 w-full md:w-[calc(100%-16rem)] transition-all duration-300">
    <div class="w-full">
        <!-- Welcome Section -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white">
                <h2 class="text-2xl font-bold mb-2">Welcome back, <?= htmlspecialchars($firstName) ?></h2>
                <p class="text-blue-100">Here's an overview of your health journey with us.</p>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6 mb-10 max-w-full">
            <!-- First Card: Always Visible -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 truncate">Total appointments</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?= $statistics['total_appointments'] ?? 0 ?></p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20h6m-6 0a4 4 0 01-4-4v-1m0-4a4 4 0 018 0m0 0V6a4 4 0 10-8 0v5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Hidden on mobile: Other Stats -->
            <div id="moreStats" class="hidden sm:grid sm:grid-cols-1 lg:grid-cols-4 sm:col-span-2 lg:col-span-4 gap-4 sm:gap-6 w-full mt-4">
                <!-- Pending -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 truncate">Pending</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2"><?= $statistics['total_pending_appointments'] ?? 0 ?></p>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Confirmed -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 truncate">Confirmed</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2"><?= $statistics['total_confirmed_appointments'] ?? 0 ?></p>
                        </div>
                        <div class="p-3 rounded-full bg-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Denied -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 truncate">Denied</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2"><?= $statistics['total_denied_appointments'] ?? 0 ?></p>
                        </div>
                        <div class="p-3 rounded-full bg-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Cancelled -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 truncate">Cancelled</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2"><?= $statistics['total_cancelled_appointments'] ?? 0 ?></p>
                        </div>
                        <div class="p-3 rounded-full bg-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View More Button (Mobile Only) -->
        <div class="sm:hidden text-center mb-10">
            <button id="viewMoreBtn"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                View More
            </button>
        </div>

        <!-- Toggle Script -->
        <script>
            const viewMoreBtn = document.getElementById('viewMoreBtn');
            const moreStats = document.getElementById('moreStats');

            viewMoreBtn.addEventListener('click', () => {
                moreStats.classList.toggle('hidden');
                viewMoreBtn.textContent = moreStats.classList.contains('hidden') ? 'View More' : 'View Less';
            });
        </script>




        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Upcoming Appointments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Upcoming Appointments</h3>
                    <!-- Calendar icon (simple SVG) -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </div>

                <div id="appointmentsList" class="space-y-4">
                    <?php
                    // Filter only confirmed appointments
                    $confirmedAppointments = array_filter($appointments, fn($a) => strtolower($a['status']) === 'confirmed');

                    // Limit to first 2 confirmed appointments
                    foreach (array_slice($confirmedAppointments, 0, 2) as $appointment):
                        $doctor = 'Dr. ' . trim(($appointment['doctor_first_name'] ?? '') . ' ' . ($appointment['doctor_last_name'] ?? '')) ?: 'Unknown';
                        $specialty = $appointment['specialty'] ?? 'N/A';

                        $date = !empty($appointment['appointment_date'])
                            ? date('M j, Y', strtotime($appointment['appointment_date']))
                            : (!empty($appointment['requested_date']) ? date('M j, Y', strtotime($appointment['requested_date'])) : 'Unknown');

                        $time = !empty($appointment['slot_start']) ? date('g:i A', strtotime($appointment['slot_start'])) : 'Unknown';
                        ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900"><?= htmlspecialchars($doctor) ?></p>
                                <p class="text-sm text-gray-600"><?= htmlspecialchars($specialty) ?></p>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($date) ?> at <?= htmlspecialchars($time) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Trigger Button -->
                <button
                        id="bookAppointmentBtn"
                        class="w-full mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg font-medium
                        hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center space-x-2"
                >
                    <!-- Plus icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    <span>Book New Appointment</span>
                </button>
            </div>

            <!-- Quick Access Panels -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Medical Records Button -->
                <button id="medicalRecordsBtn" onclick="showMedicalRecordsModal()"
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group">
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M9 12h6m-6 4h6m-7-8h8l4 4v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-6z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Medical Records</p>
                </button>


                <!-- Billing Info -->
<!--            <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group">-->
<!--                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">-->
                    <!-- Credit Card Icon -->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">-->
<!--                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>-->
<!--                        <path d="M16 3h-8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>-->
<!--                    </svg>-->
<!--                </div>-->
<!--                <p class="text-sm font-medium text-gray-900">Billing Info</p>-->
<!--            </button>-->

                <!-- Messages -->
<!--            <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group">-->
<!--                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">-->
                    <!-- Message Icon -->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">-->
<!--                             <path d="M21 11.5a8.38 8.38 0 0 1-1.9 5.4 8.5 8.5 0 0 1-6.6 3.1 8.38 8.38 0 0 1-5.4-1.9L3 21l1.9-4.1a8.38 8.38 0 0 1-1.9-5.4 8.5 8.5 0 0 1 3.1-6.6 8.38 8.38 0 0 1 5.4-1.9h.5"/>-->
<!--                    </svg>-->
<!--                </div>-->
<!--                <p class="text-sm font-medium text-gray-900">Messages</p>-->
<!--            </button>-->

                <!-- Profile Settings -->
                <button
                        onclick="document.getElementById('editProfileModal').classList.remove('hidden')"
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group"
                >
                    <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                        <!-- User Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="7" r="4" />
                            <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Profile Settings</p>
                </button>


            </div>

        </div>

        <!-- Appointment Management -->
        <div class="bg-white p-6 rounded-xl shadow ">
            <h2 class="text-xl font-semibold mb-6">Past Appointments</h2>
            <!-- Search and Filters Container -->
            <form method="GET" action="/vas-care/src/index.php">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <!-- Header with Search and Filters -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- Search Input -->
                            <div class="relative flex-1">
                                <!-- Search Icon -->
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                                <input type="hidden" name="action" value="viewAllAppointments" />
                                <input type="text" name="search" placeholder="Search appointments"
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                                />
                            </div>

                            <!-- Filter Dropdowns -->
                            <div class="flex gap-2">
                                <!-- Status Filter -->
                                <select name="status" onchange="this.form.submit()"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All</option>
                                    <option value="pending" <?= (($_GET['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
                                    <option value="confirmed" <?= (($_GET['status'] ?? '') === 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
                                    <option value="cancelled" <?= (($_GET['status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                                    <option value="denied" <?= (($_GET['status'] ?? '') === 'denied') ? 'selected' : '' ?>>Denied</option>
                                    <option value="completed" <?= (($_GET['status'] ?? '') === 'completed') ? 'selected' : '' ?>>Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>

        <?php if (isset($appointments['error'])): ?>
            <p class="text-red-600"><?= htmlspecialchars($appointments['error']) ?></p>
        <?php endif; ?>

        <?php if (empty($appointments)): ?>
            <div class="text-center text-gray-500 text-lg">
                No Appointments found.
            </div>
        <?php else: ?>

            <!-- Scrollable Table Container -->
            <div class="overflow-x-auto">
                <div class="min-w-[1000px]">
                    <table class="min-w-full text-sm text-left text-gray-700 md:mb-20">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Requested</th>
                            <th class="px-6 py-3">Confirmed</th>
                            <th class="px-6 py-3">Time Slot</th>
                            <th class="px-6 py-3">Ailment</th>
                            <th class="px-6 py-3">Doctor</th>
                            <th class="px-6 py-3">Assigned By</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Comment</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($appointments as $appointment): ?>
                        <?php
                        if (!is_array($appointment)) continue;
                        $status = strtolower($appointment['status']);
                        [$colorClass, $iconClass] = match ($status) {
                            'confirmed' => ['text-green-600', 'fa-solid fa-circle-check'],
                            'pending' => ['text-yellow-600', 'fa-solid fa-hourglass-half'],
                            'cancelled' => ['text-red-600', 'fa-solid fa-circle-xmark'],
                            'denied' => ['text-gray-500', 'fa-solid fa-ban'],
                            default => ['text-black', 'fa-solid fa-question-circle'],
                        };
                        ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $requestedDate = $appointment['requested_date'];
                                if (!empty($requestedDate) && $requestedDate !== '0000-00-00') {
                                    echo date('F j, Y', strtotime($requestedDate));
                                } else {
                                    echo "Not specified";
                                }
                                ?>
                            </td>



                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (empty($appointment['appointment_date'])): ?>
                                    <?= "No date assigned"; ?>
                                <?php else: ?>
                                    <?= date("F j, Y", strtotime($appointment['appointment_date'])); ?>
                                <?php endif; ?>
                                <span id="appointmentDate-<?= $appointment['appointment_id'] ?>" class="hidden"><?= htmlspecialchars($appointment['appointment_date']) ?></span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (!empty($appointment['slot_start']) && !empty($appointment['slot_end'])): ?>
                                    <?= date("g:i A", strtotime($appointment['slot_start'])) ?> -
                                    <?= date("g:i A", strtotime($appointment['slot_end'])) ?>
                                <?php else: ?>
                                    No time assigned
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($appointment['ailment']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                if (!empty($appointment['doctor_first_name']) && !empty($appointment['doctor_last_name'])) {
                                    echo 'Dr. ' . htmlspecialchars($appointment['doctor_first_name']) . ' ' . htmlspecialchars($appointment['doctor_last_name']);
                                }
                                else echo 'Not Assigned';

                                ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                if (!empty($appointment['nurse_first_name']) && !empty($appointment['nurse_last_name'])) {
                                    echo 'Nurse. ' . htmlspecialchars($appointment['nurse_first_name']) . ' ' . htmlspecialchars($appointment['nurse_last_name']);
                                }
                                else echo 'Not Assigned';
                                ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap <?= $colorClass ?>">
                                <i class="<?= $iconClass ?> mr-1"></i>
                                <?= ucfirst($appointment['status']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= htmlspecialchars(!empty($appointment['comments']) ? $appointment['comments'] : 'No comment') ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">

                                <form id="cancelForm-<?= $appointment['appointment_id'] ?>" method="POST" action="<?= BASE_URL; ?>/index.php?action=updateStatus">
                                    <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="button" onclick="openCancelModal('cancelForm-<?= $appointment['appointment_id'] ?>')"
                                            class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-200" title="Cancel">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                                    </button>

                                </form>

                                <button type="button"
                                        onclick='openEditModal(<?= json_encode($appointment) ?>)'
                                        class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200"
                                        title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>


                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>



        <!-- Modals -->
    <?php include 'patient_models/modal.php' ?>




        <?php if (isset($_SESSION['error'])): ?>
            <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 mx-4">
                    <h2 class="text-red-600 text-xl font-semibold mb-4">Error</h2>
                    <p class="mb-6 text-gray-800"><?= htmlspecialchars($_SESSION['error']) ?></p>
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
            <?php unset($_SESSION['error']); endif; ?>





<script>
    const dropdownBtn = document.getElementById('userDropdownBtn');
    const dropdownMenu = document.getElementById('userDropdownMenu');

    dropdownBtn.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });

    function assignDoctor(name) {
        console.log('Assigned:', name);
        // You can add logic here to assign the doctor to your appointment
        closeDoctorModal();
    }

    lucide.createIcons();
</script>


    <script>
        lucide.createIcons();
    </script>

</main>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarToggle.classList.add('hidden'); // Hide toggle button
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarToggle.classList.remove('hidden'); // Show toggle button again
    }

    sidebarToggle.addEventListener('click', openSidebar);
    sidebarClose.addEventListener('click', closeSidebar);

    // Handle sidebar state on window resize
    function handleResize() {
        if (window.innerWidth < 768) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    window.addEventListener('resize', handleResize);
    document.addEventListener('DOMContentLoaded', handleResize);
</script>


</body>
</html>
