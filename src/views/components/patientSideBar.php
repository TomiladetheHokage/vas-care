<!-- Sidebar -->

<?php
require_once __DIR__ . '/../../config/constants.php';

$profile_picture = !empty($user['profile_picture']) ? BASE_URL . '/public/' . $user['profile_picture'] : BASE_URL . '/assets/3.jpg';
//echo $profile_picture;

?>

<aside class="w-64 bg-white border-r p-6 flex flex-col justify-between">
    <div>
        <h2 class="text-xl font-bold text-indigo-600 mb-8">Patient Dashboard</h2>
        <nav class="flex flex-col items-start space-y-4">
            <!-- Profile Picture -->
            <div class="flex justify-center w-full">

                <img src="<?= $profile_picture ?>" alt="Profile Picture" class="w-16 h-16 rounded-full object-cover">

            </div>

            <!-- Welcome Message -->
            <a href="<?php echo BASE_URL; ?>/index.php?action=viewAllAppointments" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg w-full">
                <span class="ml-2">Welcome <?= htmlspecialchars($firstName) ?></span>
            </a>

            <a href="<?php echo BASE_URL; ?>/index.php?action=viewAllAppointments" class="flex items-center p-2 rounded-lg bg-indigo-600 text-white font-medium w-full">
                <span class="ml-2">Dashboard</span>
            </a>

            <!-- Management Section -->
            <div class="mt-4 w-full">
                <p class="text-xs text-gray-500 uppercase">Management</p>
                <!--                    <a href="#" class="block mt-2 text-gray-700 hover:bg-gray-100 rounded-lg p-2 w-full">Edit Profile</a>-->
                <a href="#" onclick="openBookModal()" class="block mt-1 text-gray-700 hover:bg-gray-100 rounded-lg p-2 w-full">Book Appointment</a>
            </div>
        </nav>

    </div>
    <a href="<?php echo BASE_URL; ?>/index.php?action=logout" class="mt-4 w-full bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 text-sm">
        <span class="ml-2">Logout</span>
    </a>
</aside>