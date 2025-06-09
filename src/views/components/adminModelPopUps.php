<!-- Modal Wrapper -->
<div id="createUserModal" class="fixed inset-0 z-50 flex items-center justify-center <?= !empty($docRegError) ? '' : 'hidden' ?> bg-black bg-opacity-50 backdrop-blur-sm transition">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative animate-fade-in-down">

        <!-- Close Button -->
        <button onclick="closeModal('createUserModal')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            &times;
        </button>

        <!-- Modal Title -->
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Create New Staff</h2>

        <!-- Form -->
        <form action="/vas-care/src/adminIndex.php?action=createNewStaffMember" method="POST" class="space-y-4" enctype="multipart/form-data">

            <?php if (!empty($docRegError)): ?>
                <p class='text-red-500 mb-4'><?= htmlspecialchars($docRegError) ?></p>
            <?php endif; ?>

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
                <select name="specialization"
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
                <label class="block text-sm font-medium text-gray-600">Role</label>
                <select name="role" required
                        class="w-full mt-1 mb-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="" disabled selected>Select Role</option>
                    <option value="doctor">Doctor</option>
                    <option value="nurse">Nurse</option>
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


<!--////   ADD A 'ARE U SURE U WANT TO DE ACTIVATE USER POP UP-->
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