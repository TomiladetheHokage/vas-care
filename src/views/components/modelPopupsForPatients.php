
<div id="editModalOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div id="editModal" class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6 text-indigo-700">Edit Appointment</h2>

        <?php if (!empty($error)): ?>
            <p class="text-red-500 mb-4 text-sm text-center"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="/vas-care/src/index.php?action=editAppointmentSubmit" method="POST" class="space-y-4">
            <input type="hidden" name="appointment_id" id="edit_appointment_id">
            <input type="hidden" name="patient_id" value="<?= $_SESSION['user']['user_id'] ?>">


            <div>
                <label class="block text-sm font-medium text-gray-600">Date</label>
                <input type="date" name="appointment_date" id="edit_appointment_date" required
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       value="<?= htmlspecialchars($old['appointment_date'] ?? '') ?>"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Ailment</label>
                <textarea name="ailment" id="edit_ailment" required
                          class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                          rows="4"><?= htmlspecialchars($old['ailment'] ?? '') ?></textarea>
            </div>


            <div>
                <label class="block text-sm font-medium text-gray-600">Medical History</label>
                <input type="text" name="medical_history" id="edit_medical_history"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       value="<?= htmlspecialchars($old['medical_history'] ?? '') ?>"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Current Medication</label>
                <input type="text" name="current_medication" id="edit_current_medication"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       value="<?= htmlspecialchars($old['current_medication'] ?? '') ?>"/>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                Submit
            </button>
        </form>
    </div>
</div>
</div>
<!-- Book Appointment Modal Overlay -->
<div id="bookModalOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div id="bookModal" class="relative bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

        <!-- Close button -->
        <button onclick="closeBookModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>

        <h2 class="text-2xl font-bold text-center mb-6 text-indigo-700">Book Appointment</h2>

        <form action="/vas-care/src/index.php?action=createAppointment" method="POST" class="space-y-4">
            <!-- Inside the modal form -->
            <input type="hidden" name="patient_id" value="<?= $_SESSION['user']['user_id'] ?>">
<!--            <input type="hidden" name="appointment_id" value="--><?php //= $_SESSION['user']['user_id'] ?><!--">-->

            <div>
                <label class="block text-sm font-medium text-gray-600">Request a Date</label>
                <input type="date" name="appointment_date" id="appointmentDate"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
            <p class="text-xs text-gray-500 mt-1">You can leave this blank if you don't want to specify a date.</p>
            <div>
                <label class="block text-sm font-medium text-gray-600">Ailment</label>
                <textarea name="ailment" required
                          class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                          rows="4">
                </textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Medical History</label>
                <input type="text" name="medical_history" placeholder="Optional"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Current Medication</label>
                <input type="text" name="current_medication" placeholder="Optional"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                Book Now
            </button>
        </form>
    </div>
</div>

<!-- Success Modal -->
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

<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <h2 class="text-lg font-semibold mb-4">Cancel Appointment</h2>
        <p class="mb-6">Are you sure you want to cancel this appointment?</p>
        <div class="flex justify-end gap-4">
            <button onclick="closeCancelModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded">
                No
            </button>
            <button id="confirmCancelBtn" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded">
                Yes, Cancel
            </button>
        </div>
    </div>
</div>



