<!--ADD PAGINATION OOOOOOOOOOOOOO-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nurse Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 text-base">
<!-- Header -->
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Left: Title + Menu -->
            <div class="flex items-center">
                <!-- Mobile menu button (hamburger / X) -->
                <button class="md:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-2xl font-bold text-gray-900 ml-2 md:ml-0">Dashboard</h1>
            </div>

            <!-- Right: Name dropdown and Logout button -->
            <div class="flex items-center gap-4 relative">

                <!-- Name & Role (Dropdown Trigger) -->
                <button
                        id="userDropdownBtn"
                        class="hidden sm:flex items-center gap-2 px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition"
                >
                    <div class="flex flex-col items-start leading-tight">
                        <span class="text-sm font-medium text-gray-900">Tomilade Yemi-Oyebola</span>
                        <span class="text-xs text-gray-400 capitalize font-normal">Receptionist</span>
                    </div>

                    <!-- Dropdown Icon -->
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>


                <!-- Dropdown -->
                <div id="userDropdownMenu" class="absolute right-20 top-14 w-48 bg-white border border-gray-200 rounded-lg shadow-md z-50 hidden">
                    <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Edit Profile
                    </a>
                </div>

                <!-- Logout Button (Separate) -->
                <button class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    <!-- Icon -->
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </div>
</header>

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
</script>



<!-- Main Content -->
<main class="max-w-7xl mx-auto px-6">
    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pending Appointments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Appointments</p>
                    <p class="text-2xl font-bold text-yellow-600">12</p>
                </div>
                <i data-lucide="clock" class="w-8 h-8 text-yellow-500"></i>
            </div>
        </div>

        <!-- Confirmed Today -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Confirmed Today</p>
                    <p class="text-2xl font-bold text-green-600">8</p>
                </div>
                <i data-lucide="check-circle" class="w-8 h-8 text-green-500"></i>
            </div>
        </div>

        <!-- Urgent Cases -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Urgent Cases</p>
                    <p class="text-2xl font-bold text-red-600">3</p>
                </div>
                <i data-lucide="alert-triangle" class="w-8 h-8 text-red-500"></i>
            </div>
        </div>

        <!-- Available Doctors -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Available Doctors</p>
                    <p class="text-2xl font-bold text-blue-600">5</p>
                </div>
                <i data-lucide="users" class="w-8 h-8 text-blue-500"></i>

            </div>
        </div>
    </div>



    <!-- Profile Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">My Profile</h3>
            <button onclick="showEditProfile()" class="flex items-center space-x-2 px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                <i data-lucide="edit" class="w-4 h-4"></i>
                <span>Edit Profile</span>
            </button>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Name</p>
                <p class="text-gray-900">Tomilade Yemi-Oyebola</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Employee ID</p>
                <p class="text-gray-900">EMP12345</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Department</p>
                <p class="text-gray-900">Reception</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Email</p>
                <p class="text-gray-900">email@example.com</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Phone</p>
                <p class="text-gray-900">+234 901 234 5678</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Shift</p>
                <p class="text-gray-900">Morning</p>
            </div>
        </div>
    </div>



    <!-- Appointment Management -->
    <div class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-xl font-semibold mb-6">Appointment Management</h2>
        <!-- Search and Filters Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header with Search and Filters -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <!-- Search Icon (use lucide or any icon library) -->
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <input
                                type="text"
                                placeholder="Search appointments"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>

                    <!-- Filter Dropdowns -->
                    <div class="flex gap-2">
                        <!-- Example Filter 1 -->
                        <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Filter by Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <!-- Scrollable Table Container -->
        <div class="overflow-x-auto">
            <div class="min-w-[1000px]">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Patient</th>
                        <th class="px-6 py-3">Requested</th>
                        <th class="px-6 py-3">Confirmed</th>
                        <th class="px-6 py-3">Time Slot</th>
                        <th class="px-6 py-3">Ailment</th>
                        <th class="px-6 py-3">Doctor</th>
                        <th class="px-6 py-3">Assigned By</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Comment</th>
                        <th class="px-6 py-3">Internal Note</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">John Tomi</td>
                        <td class="px-6 py-4 whitespace-nowrap">Jun 13th, 25</td>
                        <td class="px-6 py-4 whitespace-nowrap">9am - 10am</td>
                        <td class="px-6 py-4 whitespace-nowrap">Regular checkup</td>
                        <td
                                class="px-6 py-4 text-blue-600 hover:underline cursor-pointer whitespace-nowrap"
                                onclick="openDoctorModal()"
                        >
                            + Assign Doctor
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">Dr. Yinka</td>
                        <td class="px-6 py-4 whitespace-nowrap">Nurse Ola</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">Please arrive 15 minutes early</td>
                        <td class="px-6 py-4 whitespace-nowrap">Patient has history of anxiety</td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <button class="w-8 h-8 flex items-center justify-center bg-green-100 text-green-600 rounded-full hover:bg-green-200" title="Confirm">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                            </button>
                            <button
                                    id="denyBtn"
                                    class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-200"
                                    title="Deny"
                            >
                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200" title="Edit">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>





    </div>
</main>
<!-- Doctor Selector Modal -->
<div id="doctorSelectorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Assign Doctor</h3>

        <div class="space-y-3 max-h-60 overflow-y-auto">
            <!-- Doctor buttons -->
            <button
                    type="button"
                    class="w-full p-3 rounded-lg border border-gray-200 text-left transition-colors duration-200 hover:border-blue-500 hover:bg-blue-50"
                    onclick="assignDoctor('Dr. Jane Doe')"
            >
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-900">Dr. Jane Doe</p>
                        <p class="text-sm text-gray-600">Cardiology</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Available</span>
                </div>
            </button>

            <button
                    type="button"
                    class="w-full p-3 rounded-lg border border-gray-200 bg-gray-50 cursor-not-allowed opacity-60 text-left"
                    disabled
            >
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-900">Dr. John Smith</p>
                        <p class="text-sm text-gray-600">Neurology</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">On Leave</span>
                </div>
            </button>
        </div>

        <div class="flex space-x-3 pt-4 mt-4 border-t border-gray-200">
            <button
                    type="button"
                    onclick="closeDoctorModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200"
            >
                Cancel
            </button>
        </div>
    </div>
</div>

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

<!-- Deny Appointment Modal (hidden by default) -->
<div id="denyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deny Appointment</h3>

        <form id="denyForm">
            <div class="space-y-4">
                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                    <select id="reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Select a reason</option>
                        <option value="no-availability">No doctor availability</option>
                        <option value="incomplete-info">Incomplete information</option>
                        <option value="duplicate">Duplicate request</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comment</label>
                    <textarea
                            id="comment"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Additional comments for the patient..."
                            required
                    ></textarea>
                </div>
            </div>

            <div class="flex space-x-3 pt-4 mt-4">
                <button
                        type="button"
                        id="denyCancelBtn"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                >
                    Cancel
                </button>
                <button
                        type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                >
                    Deny Appointment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const denyBtn = document.getElementById('denyBtn');
    const denyModal = document.getElementById('denyModal');
    const denyCancelBtn = document.getElementById('denyCancelBtn');
    const denyForm = document.getElementById('denyForm');

    // Show modal when deny button clicked
    denyBtn.addEventListener('click', () => {
        denyModal.classList.remove('hidden');
    });

    // Hide modal on cancel
    denyCancelBtn.addEventListener('click', () => {
        denyModal.classList.add('hidden');
    });

    // Handle form submission
    denyForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Example: collect values
        const reason = document.getElementById('reason').value;
        const comment = document.getElementById('comment').value;

        console.log('Denying appointment with:', { reason, comment });

        // Hide modal after submit
        denyModal.classList.add('hidden');

        // Reset form if needed
        denyForm.reset();

        // Add your deny logic here (e.g., send data to server)
    });
</script>

<script>
    function showEditProfile() {
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


<script>
    function openDoctorModal() {
        document.getElementById('doctorSelectorModal').classList.remove('hidden');
    }

    function closeDoctorModal() {
        document.getElementById('doctorSelectorModal').classList.add('hidden');
    }

    function assignDoctor(name) {
        console.log('Assigned:', name);
        // You can add logic here to assign the doctor to your appointment
        closeDoctorModal();
    }
</script>


<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

<script>
    function toggleDropdown() {
        document.getElementById("profileDropdown").classList.toggle("hidden");
    }
</script>
</body>

</html>
