<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Book New Appointment</h3>

        <form action="<?php echo BASE_URL; ?>/index.php?action=createAppointment" method="POST" class="space-y-4">
            <input type="hidden" name="patient_id" value="<?= $_SESSION['user']['user_id'] ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date</label>
                <input
                    type="date"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    name="requested_date"
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ailment</label>
                <textarea
                        name="ailment"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Describe your symptoms or concern..." required>
                </textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Medication History (Optional)</label>
                <input
                        name="medical_history"
                        type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="List any history of past medications..."
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Medication (Optional)</label>
                <input
                        name="current_medication"
                        type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="List any current medications..."
                />
            </div>



            <div class="flex space-x-3 pt-4">
                <button
                    type="button"
                    id="cancelBookingBtn"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                >
                    Book Appointment
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    const openBtn = document.getElementById('bookAppointmentBtn');
    const modal = document.getElementById('bookingModal');
    const cancelBtn = document.getElementById('cancelBookingBtn');

    if (openBtn && modal && cancelBtn) {
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Optional: close modal when clicking outside the box
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    }
</script>


<!-- Edit Profile Modal (hidden by default) -->
<div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-xl flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Edit Profile</h3>
            <button onclick="hideEditProfile()" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                    <input type="text" id="firstName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                    <input type="text" id="lastName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="tel" id="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Employee ID</label>
                    <input type="text" id="employeeId" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" disabled />
                </div>
                <!--                <div>-->
                <!--                    <label class="block text-sm font-medium text-gray-700 mb-2">License Number</label>-->
                <!--                    <input type="text" id="licenseNumber" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />-->
                <!--                </div>-->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                    <select id="department" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="General Medicine">General Medicine</option>
                        <option value="Emergency">Emergency</option>
                        <option value="Pediatrics">Pediatrics</option>
                        <option value="Surgery">Surgery</option>
                        <option value="ICU">ICU</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Shift</label>
                    <select id="shift" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="Day Shift">Day Shift</option>
                        <option value="Night Shift">Night Shift</option>
                        <option value="Rotating">Rotating</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" id="dateOfBirth" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact</label>
                    <input type="text" id="emergencyContact" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Phone</label>
                    <input type="tel" id="emergencyPhone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <input type="text" id="address" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <!--                <div class="md:col-span-2">-->
                <!--                    <label class="block text-sm font-medium text-gray-700 mb-2">Specializations</label>-->
                <!--                    <textarea id="specializations" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="List your specializations..."></textarea>-->
                <!--                </div>-->
            </div>

            <div class="flex space-x-3 pt-6 mt-6 border-t border-gray-200">
                <button type="button" onclick="hideEditProfile()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">Cancel</button>
                <button type="button" onclick="saveProfile()" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Make user session data available to JS
    const userData = <?= json_encode($_SESSION['user'] ?? []) ?>;

    function showEditProfile() {
        console.log('showEditProfile called', userData);
        document.getElementById('firstName').value = userData.first_name || '';
        document.getElementById('lastName').value = userData.last_name || '';
        document.getElementById('email').value = userData.email || '';
        document.getElementById('phone').value = userData.phone_number || '';
        document.getElementById('address').value = userData.address || '';
        document.getElementById('editProfileModal').classList.remove('hidden');
    }

    function hideEditProfile() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }

    function saveProfile() {
        // Collect input values (example)
        const profile = {
            firstName: document.getElementById('firstName').value,
            lastName: document.getElementById('lastName').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            // Add others as needed...
        };
        console.log('Saving profile:', profile);

        // Here you can add your save logic, then close modal
        hideEditProfile();
    }
</script>


<!-- Modal -->
<div id="medicalRecordsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full relative">
        <button onclick="closeMedicalRecordsModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
        <h2 class="text-2xl font-bold mb-4">Medical Records</h2>
        <?php
        $user = $_SESSION['user'] ?? [];
        ?>
        <ul class="space-y-2">
            <li><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] ?? '') ?> <?= htmlspecialchars($user['last_name'] ?? '') ?: '<span class="text-gray-400">Not available</span>' ?></li>
            <li><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '<span class="text-gray-400">Not available</span>') ?></li>
            <li><strong>Phone:</strong> <?= htmlspecialchars($user['phone_number'] ?? '<span class="text-gray-400">Not available</span>') ?></li>
            <li><strong>Gender:</strong> <?= htmlspecialchars($user['gender'] ?? '<span class="text-gray-400">Not available</span>') ?></li>
        </ul>
        <?php if (empty($user['medical_history'])): ?>
            <p class="mt-4 text-gray-500 italic">No medical history on file yet. Please consult your doctor to update your records.</p>
        <?php else: ?>
            <div class="mt-4">
                <strong>Medical History:</strong>
                <p><?= nl2br(htmlspecialchars($user['medical_history'])) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function showMedicalRecordsModal() {
        document.getElementById('medicalRecordsModal').classList.remove('hidden');
    }

    function closeMedicalRecordsModal() {
        document.getElementById('medicalRecordsModal').classList.add('hidden');
    }
</script>


<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg w-[90%] max-w-sm">
        <h2 class="text-lg font-semibold text-gray-800 mb-2 text-center">Cancel Appointment</h2>
        <p class="text-gray-600 mb-4 text-center">Please provide a reason for cancellation:</p>
        <textarea id="cancellationReason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3" placeholder="Reason..."></textarea>
        <div class="flex justify-center gap-4 mt-4">
            <button onclick="submitCancelForm()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Submit Cancellation</button>
            <button onclick="closeCancelModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Back</button>
        </div>
    </div>
</div>

<script>
    let formToCancel = null;

    function openCancelModal(formId) {
        formToCancel = document.getElementById(formId);
        document.getElementById('cancelModal').classList.remove('hidden');
    }

    function closeCancelModal() {
        formToCancel = null;
        document.getElementById('cancellationReason').value = ''; // Clear textarea
        document.getElementById('cancelModal').classList.add('hidden');
    }

    function submitCancelForm() {
        if (formToCancel) {
            const reason = document.getElementById('cancellationReason').value;
            if (reason.trim() === '') {
                alert('Please provide a reason for cancellation.');
                return;
            }
            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'comment';
            reasonInput.value = reason;
            formToCancel.appendChild(reasonInput);
            formToCancel.submit();
        }
    }
</script>


<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-[95%] max-w-md relative">
<!--        <div class="bg-white p-4 sm:p-8 rounded-2xl shadow-xl w-[95%] max-w-md relative">-->


        <!-- Close Button -->
        <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <h2 class="text-2xl font-bold text-center mb-6 text-indigo-700">Edit Appointment</h2>

        <?php if (!empty($error)): ?>
            <p class="text-red-500 mb-4 text-sm text-center"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="<?= BASE_URL; ?>/index.php?action=editAppointmentSubmit" method="POST" class="space-y-4">
            <input type="hidden" name="appointment_id" id="edit_appointment_id">
            <input type="hidden" name="patient_id" value="<?= $_SESSION['user']['user_id'] ?>">

            <div>
                <label class="block text-sm font-medium text-gray-600">Date</label>
                <input type="date" name="requested_date" id="edit_appointment_date" required
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Ailment</label>
                <textarea name="ailment" id="edit_ailment" required
                          class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                          rows="4"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Medical History</label>
                <input type="text" name="medical_history" id="edit_medical_history"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Current Medication</label>
                <input type="text" name="current_medication" id="edit_current_medication"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                Submit
            </button>
        </form>
    </div>
</div>


<script>
    function openEditModal(appointment) {
        document.getElementById('edit_appointment_id').value = appointment.appointment_id || '';
        document.getElementById('edit_appointment_date').value = appointment.requested_date || '';
        document.getElementById('edit_ailment').value = appointment.ailment || '';
        document.getElementById('edit_medical_history').value = appointment.medical_history || '';
        document.getElementById('edit_current_medication').value = appointment.current_medication || '';

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Optional: close modal on outside click
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('editModal');
        if (e.target === modal) {
            closeEditModal();
        }
    });
</script>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="bg-white  w-[95%] max-w-sm rounded-xl shadow-lg p-6 transform transition-all scale-100">
        <div class="flex flex-col items-center text-center">
            <!-- Success Icon -->
            <div class="bg-green-100 p-3 rounded-full mb-4">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Success</h2>
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

<script>
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
