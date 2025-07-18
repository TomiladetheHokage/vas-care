<?php
require_once __DIR__ . '/../config/constants.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;

if(isset($_SESSION['error'])) $error = $_SESSION['error'];

if ($user['role'] !== 'nurse') {
    header('Location: ' . BASE_URL . '/views/patientDashboard.php');
    exit();
}
$firstName = $user['first_name'];
$selectedDoctorId = $_SESSION['selectedDoctorId'] ?? null;
$pfp = $isLoggedIn && isset($user['profile_picture']) ? $user['profile_picture'] : BASE_URL . '/assets/3.jpg';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nurse Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 font-sans">
<div class="flex min-h-screen">
    <!-- Sidebar always visible -->
    <?php
    require_once __DIR__ . '/../config/constants.php';
    if (session_status() === PHP_SESSION_NONE) session_start();
    $user = $_SESSION['user'] ?? [];
    $name = ($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '');
    $email = $user['email'] ?? '';
    $role = $user['role'] ?? 'nurse';
    $profile_picture = !empty($user['profile_picture']) ? BASE_URL . '/public/' . $user['profile_picture'] : BASE_URL . '/assets/3.jpg';
    $navLinks = [
        [
            'href' => BASE_URL . '/nurseIndex.php?action=viewAllAppointments',
            'icon' => 'home',
            'label' => 'Dashboard',
        ],
        [
            'href' => BASE_URL . '/nurseIndex.php?action=viewAllAppointments',
            'icon' => 'calendar-check',
            'label' => 'Appointments',
        ],
        [
            'href' => BASE_URL . '/nurseIndex.php?action=viewAllPatients',
            'icon' => 'user',
            'label' => 'Patients',
        ],
        [
            'href' => '#',
            'icon' => 'file-text',
            'label' => 'Medical Records',
        ],
        [
            'href' => '#',
            'icon' => 'message-square',
            'label' => 'Messages',
        ],
        [
            'href' => '#',
            'icon' => 'settings',
            'label' => 'Settings',
        ],
        [
            'href' => '#',
            'icon' => 'user-circle',
            'label' => 'Edit Profile',
            'onclick' => 'showEditProfile()',
        ],
    ];
    include __DIR__ . '/components/unifiedSidebar.php';
    ?>



    <!-- JavaScript to Toggle Sidebar -->
    <script>
        // Remove sidebar toggle JS and hamburger button
    </script>





    <!-- Main Content -->
  <main class="flex-1 p-6 overflow-auto mt-20 ml-64">
    <header class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold">Appointment Management</h1>
        <p class="text-gray-500">Manage and track patient appointments</p>
      </div>
    </header>

    <div class="flex gap-4 mb-4">
<!--      <a href="/vas-care/src/nurseIndex.php?action=viewAllAppointments" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium">View All Appointments</a>-->
<!--      <button class="border border-gray-300 px-4 py-2 rounded-lg font-medium">Reschedule Appointment</button>-->
    </div>

      <form method="GET" action="nurseIndex.php" class="flex flex-wrap gap-4 mb-6">
          <input type="hidden" name="action" value="viewAllAppointments" />
          <input type="text" name="search" placeholder="Search appointments..." class="flex-grow border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"/>
          <select name="status" class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="">Filter by Status</option>
              <option value="pending" <?= (($_GET['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
              <option value="confirmed" <?= (($_GET['status'] ?? '') === 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
              <option value="cancelled" <?= (($_GET['status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
              <option value="denied" <?= (($_GET['status'] ?? '') === 'denied') ? 'selected' : '' ?>>Denied</option>
          </select>

          <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
              Search
          </button>
      </form>

      <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-6 w-full">
          <div class="bg-white p-4 rounded-lg shadow-md border text-center">
              <p class="text-sm text-gray-500 mb-1">Total Appointments</p>
              <p class="text-2xl font-semibold text-gray-800"><?= $statistics['total_appointments'] ?? 0 ?></p>
          </div>

          <div class="bg-white p-4 rounded-lg shadow-md border text-center">
              <p class="text-sm text-gray-500 mb-1">Pending</p>
              <p class="text-2xl font-semibold text-yellow-500"><?= $statistics['total_pending_appointments'] ?? 0 ?></p>
          </div>

          <div class="bg-white p-4 rounded-lg shadow-md border text-center">
              <p class="text-sm text-gray-500 mb-1">Denied</p>
              <p class="text-2xl font-semibold text-red-500"><?= $statistics['total_denied_appointments'] ?? 0 ?></p>
          </div>

          <div class="bg-white p-4 rounded-lg shadow-md border text-center">
              <p class="text-sm text-gray-500 mb-1">Confirmed</p>
              <p class="text-2xl font-semibold text-green-500"><?= $statistics['total_confirmed_appointments'] ?? 0 ?></p>
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
    <div class="bg-white rounded-lg shadow overflow-x-auto">
      <div class="w-full overflow-x-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-3 font-medium">Patient Name</th>
            <th class="px-4 py-3 font-medium">Requested Day</th>
              <th class="px-4 py-3 font-medium">Day</th>
              <th class="px-4 py-3 font-medium">Time Slot</th>
            <th class="px-4 py-3 font-medium">Ailment</th>
            <th class="px-4 py-3 font-medium">Assigned Doctor</th>
            <th class="px-4 py-3 font-medium">Status</th>
    <!--          <th class="px-4 py-3 font-medium">Update Status</th>-->
            <th class="px-4 py-3 font-medium">Assign Doctor</th>
              <th class="px-4 py-3 font-medium">Comments</th>
              <th class="px-4 py-3 font-medium">Actions</th>
          </tr>
          </thead>
          <tbody>

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
            <tr class="border-t">

          <td class="px-4 py-3 font-medium"><?= htmlspecialchars($appointment['patient_first_name']) ?></td>

                <td class="px-4 py-3">
                    <?php if (!empty($appointment['requested_date'])): ?>
                        <?= date('F j, Y', strtotime($appointment['requested_date'])) ?>
                    <?php else: ?>
                        Not specified
                    <?php endif; ?>
                </td>

                <td class="px-4 py-3">
                    <?php
                    $appointmentDate = $appointment['appointment_date'] ?? '';
                    $requestedDate = $appointment['requested_date'] ?? '';
                    $status = $appointment['status'];

                    if (empty($appointmentDate) && $status !== 'confirmed') {
                        echo "No date assigned";
                    } elseif ($status === 'confirmed' && !empty($requestedDate)) {
                        echo date("F j, Y", strtotime($requestedDate));
                    } elseif (!empty($appointmentDate)) {
                        echo date("F j, Y", strtotime($appointmentDate));
                    } else {
                        echo "Invalid date";
                    }
                    ?>

                    <span id="appointmentDate-<?= $appointment['appointment_id'] ?>" class="hidden">
        <?= htmlspecialchars($appointment['appointment_date']) ?>
    </span>
                </td>



                <td class="px-4 py-3">
                    <?php if (!empty($appointment['slot_start']) && !empty($appointment['slot_end'])): ?>
                        <?= date("g:i A", strtotime($appointment['slot_start'])) ?> -
                        <?= date("g:i A", strtotime($appointment['slot_end'])) ?>
                    <?php else: ?>
                        No time assigned
                    <?php endif; ?>
                    <span id="slotStart-<?= $appointment['appointment_id'] ?>" class="hidden"><?= htmlspecialchars($appointment['slot_start']) ?></span>
                    <span id="slotEnd-<?= $appointment['appointment_id'] ?>" class="hidden"><?= htmlspecialchars($appointment['slot_end']) ?></span>
                </td>

                <td class="px-4 py-3"><?= htmlspecialchars($appointment['ailment']) ?></td>
          <td class="px-4 py-3">
              <?php
              if (!empty($appointment['doctor_first_name'])) echo 'Dr. ' . htmlspecialchars($appointment['doctor_first_name']);
              else echo 'Not Assigned';
              ?>
          </td>
            <td class="px-4 py-3 font-semibold <?= $colorClass ?>">
                <i class="<?= $iconClass ?> mr-1"></i>
                <?= ucfirst($appointment['status']) ?>
            </td>
                <td class="px-4 py-3 text-center">
                    <form id="assignDoctorForm<?php echo $appointment['appointment_id']; ?>" method="POST" action="<?php echo BASE_URL; ?>/nurseIndex.php?action=assignDoctor">
                        <select name="doctor_id" class="border border-gray-300 rounded-md p-1 w-full" onchange="openAssignModal(this, <?= $appointment['appointment_id'] ?>)">
                            <option value="" selected>Select Doctor</option>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= $doctor['user_id'] ?>">
                                    Dr. <?= htmlspecialchars($doctor['first_name']) ?> <?= htmlspecialchars($doctor['last_name']) ?> (<?= htmlspecialchars($doctor['specialization']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                        <input type="hidden" name="nurse_id" value="<?= $user['user_id'] ?>"> <!-- Or from session -->
                    </form>
                </td>

                <td class="px-4 py-3">
                    <?= htmlspecialchars(!empty($appointment['comments']) ? $appointment['comments'] : 'No comment') ?>
                </td>

                <td class="px-4 py-3 text-center">
                    <select class="border rounded px-2 py-1" onchange="handleActionSelect(this)">
                        <option value="">Actions</option>
                        <option value="assign-<?= $appointment['appointment_id'] ?>">Assign Timeslot</option>
                        <option value="edit-<?= $appointment['appointment_id'] ?>">Edit Timeslot</option>
                        <option value="deny-<?= $appointment['appointment_id'] ?>">Deny</option>
                    </select>

                    <!-- Hidden deny form -->
                    <form id="deny-<?= $appointment['appointment_id'] ?>" action="<?php echo BASE_URL; ?>/nurseIndex.php?action=updateStatus" method="POST" style="display: none;">
                        <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                        <input type="hidden" name="status" value="denied">
                        <input type="hidden" name="comment" id="comment-<?= $appointment['appointment_id'] ?>" value="">
                    </form>
                </td>

            </tr>
        <?php endforeach; ?>

        </tbody>
      </table>
    </div>
      <?php endif; ?>


      <?php if (!empty($appointments)): ?>
          <div class="mt-4 flex items-center justify-between">
              <div class="text-sm text-gray-500">
                  Showing <?= count($appointments) ?> of <?= $totalAppointments ?> appointments
              </div>
              <div class="flex items-center space-x-2">
                  <?php if ($currentPage > 1): ?>
                      <a href="?action=viewAllAppointments&page=<?= $currentPage - 1 ?>"
                         class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md hover:bg-gray-50">
                          Previous
                      </a>
                  <?php else: ?>
                      <button class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md opacity-50 cursor-not-allowed" disabled>
                          Previous
                      </button>
                  <?php endif; ?>

                  <span class="px-3 py-1 rounded-md bg-indigo-100 text-indigo-700 font-medium text-sm">
                <?= $currentPage ?>
            </span>

                  <?php if ($currentPage < $totalPages): ?>
                      <a href="?action=viewAllAppointments&page=<?= $currentPage + 1 ?>"
                         class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md hover:bg-gray-50">
                          Next
                      </a>
                  <?php else: ?>
                      <button class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md opacity-50 cursor-not-allowed" disabled>
                          Next
                      </button>
                  <?php endif; ?>
              </div>
          </div>
      <?php else: ?>
          <div class="mt-4 text-center text-gray-500 text-sm">
              No appointments found.
          </div>
      <?php endif; ?>












      <!-- Deny Comment Modal -->
      <div id="denyCommentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
          <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
              <h3 class="text-xl font-bold text-center mb-6 text-black">Reason for Denying Appointment</h3>
              <textarea id="denyCommentInput" class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
              <div class="mt-6 flex justify-end gap-4">
                  <button
                          onclick="closeDenyModal()"
                          class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                  >
                      Cancel
                  </button>
                  <button
                          onclick="submitDenyComment()"
                          class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                  >
                      Submit
                  </button>
              </div>

          </div>
      </div>




  </main>




    <div id="timeSlotModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">Assign Time Slot</h2>
            <form id="timeSlotForm" action="<?php echo BASE_URL; ?>/nurseIndex.php?action=assignTimeSlot" method="POST">
                <input type="hidden" name="appointment_id" id="modal_appointment_id">

                <label class="block mb-2">Slot Start:</label>
                <input type="time" name="slot_start" required class="border px-2 py-1 w-full mb-4">

                <label class="block mb-2">Slot End:</label>
                <input type="time" name="slot_end" required class="border px-2 py-1 w-full mb-4">

                <label class="block mb-2">Appointment Date (optional):</label>
                <input type="date" name="appointment_date" class="border px-2 py-1 w-full mb-4">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-3 py-1 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Assign</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal backdrop -->
    <div id="assignDoctorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <!-- Modal box -->
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h2 class="text-xl font-semibold mb-4">Confirm Doctor Assignment</h2>
            <p id="modalDoctorInfo" class="mb-6 text-gray-700">Are you sure you want to assign this doctor?</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelAssignBtn" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button id="confirmAssignBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Confirm</button>
            </div>
        </div>
    </div>




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
    // document.querySelector("select[name='doctor_id']").addEventListener("change", function() {
    //     this.form.submit();
    // });


    let currentDenyFormId = null;

    function handleActionSelect(select) {
        const value = select.value;
        if (!value) return;

        if (value.startsWith("assign-")) {
            const appointmentId = value.split("-")[1];
            openTimeSlotModal(appointmentId, null, 'assignTimeSlot');  // assign action
        } else if (value.startsWith("edit-")) {
            const appointmentId = value.split("-")[1];

            const slotStart = document.getElementById(`slotStart-${appointmentId}`)?.textContent.trim() || '';
            const slotEnd = document.getElementById(`slotEnd-${appointmentId}`)?.textContent.trim() || '';
            const appointmentDate = document.getElementById(`appointmentDate-${appointmentId}`)?.textContent.trim() || '';

            openTimeSlotModal(appointmentId, { slotStart, slotEnd, appointmentDate }, 'editTimeSlot');  // edit action
        } else if (value.startsWith("deny-")) {
            currentDenyFormId = value;
            showDenyModal();
        }

        select.selectedIndex = 0; // reset dropdown after action
    }

    function showDenyModal() {
        document.getElementById('denyCommentModal').style.display = 'flex';
        document.getElementById('denyCommentInput').value = '';
        document.getElementById('denyCommentInput').focus();
    }

    function closeDenyModal() {
        document.getElementById('denyCommentModal').style.display = 'none';
        currentDenyFormId = null;
    }

    function submitDenyComment() {
        const comment = document.getElementById('denyCommentInput').value.trim();
        if (!comment) {
            alert('Please enter a reason for denying the appointment.');
            return;
        }
        // Set comment value in hidden input in the form and submit it
        const commentInput = document.querySelector(`#${currentDenyFormId} input[name="comment"]`);
        commentInput.value = comment;
        document.getElementById(currentDenyFormId).submit();
        closeDenyModal();
    }




    function openTimeSlotModal(appointmentId, data, actionType = 'assignTimeSlot') {
        const modal = document.getElementById("timeSlotModal");
        modal.classList.remove("hidden");

        document.getElementById("modal_appointment_id").value = appointmentId;

        const slotStartInput = document.querySelector('input[name="slot_start"]');
        const slotEndInput = document.querySelector('input[name="slot_end"]');
        const appointmentDateInput = document.querySelector('input[name="appointment_date"]');

        if (data) {
            slotStartInput.value = data.slotStart || '';
            slotEndInput.value = data.slotEnd || '';
            appointmentDateInput.value = data.appointmentDate || '';
        } else {
            slotStartInput.value = '';
            slotEndInput.value = '';
            appointmentDateInput.value = '';
        }

        // Set form action URL dynamically
        const form = document.getElementById('timeSlotForm');
        form.action = '<?php echo BASE_URL; ?>/nurseIndex.php?action=' + actionType;
    }


    function showTimeSlotModal(appointmentId) {
        document.getElementById("modal_appointment_id").value = appointmentId;
        document.getElementById("timeSlotModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("timeSlotModal").classList.add("hidden");
    }

</script>
<script>
    // Store the form and selected value globally
    let currentForm = null;
    let selectedDoctorIdBeforeChange = null;

    function openAssignModal(selectElem, appointmentId) {
        currentForm = document.getElementById('assignDoctorForm' + appointmentId);

        // Save previous selection in case user cancels
        selectedDoctorIdBeforeChange = currentForm.querySelector('select[name="doctor_id"]').getAttribute('data-prev') ||
            currentForm.querySelector('select[name="doctor_id"]').value;

        // Get selected doctor text
        const selectedOptionText = selectElem.options[selectElem.selectedIndex].text;

        // Update modal text
        document.getElementById('modalDoctorInfo').textContent = `Are you sure you want to assign ${selectedOptionText} to this patient?`;

        // Show modal
        const modal = document.getElementById('assignDoctorModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Store current selected value temporarily
        selectElem.setAttribute('data-prev', selectElem.value);
    }

    document.getElementById('cancelAssignBtn').addEventListener('click', () => {
        // Hide modal
        const modal = document.getElementById('assignDoctorModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        // Reset select back to previous doctor
        if (currentForm) {
            const selectElem = currentForm.querySelector('select[name="doctor_id"]');
            selectElem.value = selectedDoctorIdBeforeChange;
        }
    });

    document.getElementById('confirmAssignBtn').addEventListener('click', () => {
        // Submit form
        if (currentForm) {
            currentForm.submit();
        }
    });
</script>
<script>
  lucide.createIcons();
</script>
</body>
</html>
<!--<pre>--><?php //print_r($appointments); ?><!--</pre>-->
