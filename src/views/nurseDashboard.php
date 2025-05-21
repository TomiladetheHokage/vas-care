<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;

if(isset($_SESSION['error'])) $error = $_SESSION['error'];

//if ($user['role'] !== 'nurse') {
//    header('Location: /vas-care/src/views/dashboard.php');
//    exit();
//}

$selectedDoctorId = $_SESSION['selectedDoctorId'] ?? null;

$pfp = $isLoggedIn && isset($user['profile_picture']) ? $user['profile_picture'] : '/vas-care/src/assests/3.jpg';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Nurse Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6 text-sm font-sans">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#f2f2f2] shadow-md p-6 hidden md:block mt-[-20px] ml-[-20px]">
        <div class="flex flex-col items-center">
            <img src="<?= '/vas-care/src/public/' . $pfp ?>" alt="Profile" class="rounded-full w-10 h-10 object-cover" />
            <p class="mt-4 text-sm font-semibold">Welcome <?= $user['first_name']?></p>
            <p class="text-xs text-gray-500"><?= $user['email']?></p>
            <a  href="/vas-care/src/adminIndex.php?action=logout" class="mt-4 w-full bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 text-sm">
                Logout
            </a>
        </div>
    </aside>

    <div class="flex-1">



        <!-- Layout Wrapper -->
        <div class="max-w-7xl mx-auto p-6">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Appointment Management</h1>
                <p class="text-gray-600">View and manage all Appointments in the system.</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 mb-6">
                <a href="/vas-care/src/adminIndex.php?action=viewAllUsers" class="flex items-center justify-center px-4 py-2
                bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M3 12h18M3 19h18"></path>
                    </svg>
                    View All Appointments
                </a>
                <button onclick="openModal('createUserModal')"  class="flex items-center justify-center px-4 py-2 border
                border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="16" height="16" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m-6-6h12"></path></svg> Assign Doctor
                </button>
                <button onclick="openModal('createNurseModal')"  class="flex items-center justify-center px-4 py-2 border border-gray-300
                text-gray-700 rounded-md hover:bg-gray-50 focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="16" height="16" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m-6-6h12"></path></svg> Create Nurse
                </button>
            </div>

            <!-- Search and Filters -->
            <form method="GET" action="adminIndex.php" class="flex mb-6">
                <input type="hidden" name="action" value="viewAllUsers">

                <input type="text" name="search" class="border border-gray-300 rounded-md p-2 w-1/2 mr-2" placeholder="Search users..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

                <select name="role" class="border border-gray-300 rounded-md p-2 w-1/4 mr-2">
                    <option value="">Filter by Role</option>
                    <option value="doctor" <?= ($_GET['role'] ?? '') === 'doctor' ? 'selected' : '' ?>>Doctor</option>
                    <option value="nurse" <?= ($_GET['role'] ?? '') === 'nurse' ? 'selected' : '' ?>>Nurse</option>
                </select>

                <select name="status" class="border border-gray-300 rounded-md p-2 w-1/4">
                    <option value="">Filter by Status</option>
                    <option value="pending" <?= (($_GET['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="confirmed" <?= (($_GET['status'] ?? '') === 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
                    <option value="cancelled" <?= (($_GET['status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                    <option value="denied" <?= (($_GET['status'] ?? '') === 'denied') ? 'selected' : '' ?>>Denied</option>
                </select>

                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">Filter</button>
            </form>


            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Appointments</h3>
                    <p class="text-2xl font-semibold text-gray-800 mt-1"><?= $statistics['total_appointments'] ?? 0 ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <h3 class="text-sm font-medium text-gray-500">Pending</h3>
                    <p class="text-2xl font-semibold text-green-600 mt-1"><?= $statistics['total_pending_appointments'] ?? 0 ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <h3 class="text-sm font-medium text-gray-500">Cancelled</h3>
                    <p class="text-2xl font-semibold text-indigo-600 mt-1"><?= $statistics['total_cancelled_appointments'] ?? 0 ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <h3 class="text-sm font-medium text-gray-500">Confirmed</h3>
                    <p class="text-2xl font-semibold text-blue-600 mt-1"><?= $statistics['total_confirmed_appointments'] ?? 0 ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <h3 class="text-sm font-medium text-gray-500">Denied</h3>
                    <p class="text-2xl font-semibold text-blue-600 mt-1"><?= $statistics['total_denied_appointments'] ?? 0 ?></p>
                </div>
            </div>


            <?php if (isset($appointments['error'])): ?>
                <p class="text-red-600"><?= htmlspecialchars($appointments['error']) ?></p>
            <?php endif; ?>

            <?php if (empty($appointments)): ?>
                <div class="text-center text-gray-500 text-lg">
                    No Appointments found.
                </div>
            <?php else: ?>
                <div class="overflow-x-auto bg-white shadow-sm rounded-lg">
                    <table class="min-w-full table-auto text-left border border-gray-200">
                        <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                        <tr>
                            <th class="px-4 py-2 border-b">Name</th>
                            <th class="px-4 py-2 border-b">Day</th>
                            <th class="px-4 py-2 border-b">Time slot</th>
                            <th class="px-4 py-2 border-b">Ailment</th>
<!--                            <th class="px-4 py-2 border-b">Medical History</th>-->
                            <th class="px-4 py-2 border-b">Current Medication</th>
                            <th class="px-4 py-2 border-b">Assigned Doctor</th>
                            <th class="px-4 py-2 border-b">Status</th>
                            <th class="px-4 py-2 border-b">Update Status</th>
                            <th class="px-4 py-2 border-b">Assign Doctor</th>
                        </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
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
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($appointment['patient_first_name']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($appointment['slot_start']) ?>  .  <?= htmlspecialchars($appointment['slot_end']) ?></td>
<!--                                <td class="px-4 py-2 border-b">--><?php //= htmlspecialchars($appointment['slot_end']) ?><!--</td>-->
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($appointment['ailment']) ?></td>
<!--                                <td class="px-4 py-2 border-b">--><?php //= htmlspecialchars($appointment['medical_history']) ?><!--</td>-->
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($appointment['current_medication']) ?></td>
                                <td class="px-4 py-2 border-b">
                                    <?php
                                    if (!empty($appointment['doctor_first_name'])) echo 'Dr. ' . htmlspecialchars($appointment['doctor_first_name']);
                                    else echo 'Not Assigned';
                                    ?>
                                </td>
                                <td class="px-4 py-2 border-b font-semibold <?= $colorClass ?>">
                                    <i class="<?= $iconClass ?> mr-1"></i>
                                    <?= ucfirst($appointment['status']) ?>
                                </td>
                                <td class="px-4 py-2 border-b">
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
                                        <select name="doctor_id" class="border border-gray-300 rounded-md p-1 w-full">
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



            <!--        CONSIDER ADDING A DROP-DOWN FOR ALLOWING USERS SELECT HOW MANY ROWS THEY WANT TO SEE, 5-10, 10-25,50-100.-->
            <!-- Pagination (simplified) -->
<!--            <div class="mt-4 flex items-center justify-between">-->
<!--                <div class="text-sm text-gray-500">-->
<!--                    Showing --><?php //= count($users) ?><!-- of --><?php //= $total ?><!-- users-->
<!--                </div>-->
<!--                <div class="flex items-center space-x-2">-->
<!--                    --><?php //if ($page > 1): ?>
<!--                        <a href="?action=viewAllUsers&page=--><?php //= $page - 1 ?><!--" class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>-->
<!--                    --><?php //else: ?>
<!--                        <button class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md opacity-50 cursor-not-allowed" disabled>Previous</button>-->
<!--                    --><?php //endif; ?>
<!---->
<!--                    <span class="px-3 py-1 rounded-md bg-indigo-100 text-indigo-700 font-medium text-sm">--><?php //= $page ?><!--</span>-->
<!---->
<!--                    --><?php //if ($page < $totalPages): ?>
<!--                        <a href="?action=viewAllUsers&page=--><?php //= $page + 1 ?><!--" class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md hover:bg-gray-50">Next</a>-->
<!--                    --><?php //else: ?>
<!--                        <button class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md opacity-50 cursor-not-allowed" disabled>Next</button>-->
<!--                    --><?php //endif; ?>
<!--                </div>-->
<!--            </div>-->

        </div>
    </div>

</div>
<!-- Modal Wrapper -->
<div id="createUserModal" class="fixed inset-0 z-50 flex items-center justify-center <?= !empty($docRegError) ? '' : 'hidden' ?> bg-black bg-opacity-50 backdrop-blur-sm transition">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative animate-fade-in-down">

        <!-- Close Button -->
        <button onclick="closeModal('createUserModal')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            &times;
        </button>

        <!-- Modal Title -->
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Create New Doctor</h2>

        <!-- Form -->
        <form action="/vas-care/src/adminIndex.php?action=createNewStaffMember" method="POST" class="space-y-4" enctype="multipart/form-data">

            <?php if (!empty($docRegError)): ?>
                <p class='text-red-500 mb-4'><?= htmlspecialchars($docRegError) ?></p>
            <?php endif; ?>

            <input type="hidden" name="role" value="doctor">
            <input type="hidden" name="availability" value="available">

            <div>
                <label class="block text-sm font-medium text-gray-600">First Name</label>
                <input type="text" name="first_name" required
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Last Name</label>
                <input type="text" name="last_name" required
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" name="email" required
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" required
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <!-- Specialization Dropdown -->
            <div>
                <label class="block text-sm font-medium text-gray-600">Specialization</label>
                <select name="specialization" required
                        class="w-full mt-1 mb-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="" disabled <?= !isset($old['specialization']) ? 'selected' : '' ?>>Select Specialization</option>
                    <?php
                    $specializations = ['Cardiology','Neurology','Pediatrics','Orthopedics','General Medicine','Dermatology','Radiology'];
                    foreach ($specializations as $specialty) {
                        $selected = isset($old['specialization']) && $old['specialization'] === $specialty ? 'selected' : '';
                        echo "<option value=\"$specialty\" $selected>$specialty</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Profile picture</label>
                <input type="file" name="profile_picture"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>


            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Success Modal -->
<?php if (isset($_SESSION['AssignError'])): ?>
<div id="successModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="bg-white w-full max-w-sm rounded-xl shadow-lg p-6 transform transition-all scale-100">
        <div class="flex flex-col items-center text-center">
            <!-- Success Icon -->
            <div class="bg-green-100 p-3 rounded-full mb-4">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($_SESSION['AssignError']) ?></h2>
            <p id="successMessage" class="text-gray-600 mt-2"></p>
        </div>
        <div class="mt-6 text-center">
            <button onclick="closeSuccessModal()"
                    class="inline-block px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                Close
            </button>
        </div>
    </div>
</div>
    <?php unset($_SESSION['AssignError']); endif; ?>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openSuccessModal(message) {
        const successModal = document.getElementById('successModal');
        const successMessage = document.getElementById('successMessage');
        successMessage.textContent = message;
        successModal.classList.remove('hidden');
    }

    function closeSuccessModal() {
        const successModal = document.getElementById('successModal');
        successModal.classList.add('hidden');
    }

    window.onload = function () {
        <?php if (isset($_SESSION['message'])): ?>
        openSuccessModal("<?= $_SESSION['message']; ?>");
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    };
</script>
<script>
    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu !== dropdown) menu.classList.add('hidden');
        });
        dropdown.classList.toggle('hidden');
    }

    // Optional: close dropdown if user clicks outside
    document.addEventListener('click', function (event) {
        const isDropdown = event.target.closest('.dropdown-menu') || event.target.closest('button[onclick^="toggleDropdown"]');
        if (!isDropdown) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
        }
    });
</script>

</body>
</html>
