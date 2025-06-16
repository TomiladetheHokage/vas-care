<!--ADD PAGINATION OOOOOOOOOOOOOO-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Doctor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-800 text-base">
<!--<!-- Sidebar Toggle Button (Hamburger/Panel) -->-->
<!--<button id="sidebarToggle" class="fixed top-4 left-4 z-50 bg-white p-2 rounded-full shadow-md border border-gray-200">-->
<!--    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left-close-icon lucide-panel-left-close"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="m16 15-3-3 3-3"/></svg>-->
<!--</button>-->

<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r shadow-lg flex flex-col transition-transform duration-300" style="transform: translateX(0);">
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
                <p class="text-sm text-gray-600">Nurse Sarah</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>
<!--        <a href="/appointments" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="calendar-check" class="w-5 h-5"></i>-->
<!--            <span>Appointments</span>-->
<!--        </a>-->
<!--        <a href="/patients" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="user" class="w-5 h-5"></i>-->
<!--            <span>Patients</span>-->
<!--        </a>-->
<!--        <a href="/medical-records" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="file-text" class="w-5 h-5"></i>-->
<!--            <span>Medical Records</span>-->
<!--        </a>-->
<!--        <a href="/messages" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="message-square" class="w-5 h-5"></i>-->
<!--            <span>Messages</span>-->
<!--        </a>-->
        <button onclick="showEditProfile()" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="user-circle" class="w-5 h-5"></i>
            <span>Edit Profile</span>
        </button>
        <!-- Settings Trigger -->
        <a href="#" onclick="document.getElementById('settingsModal').classList.remove('hidden')" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="settings" class="w-5 h-5"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- Logout Section -->
    <div class="px-4 py-4 border-t border-gray-100">
        <button class="flex items-center gap-3 px-3 py-2 w-full rounded-md text-red-600 hover:bg-red-50">
            <i data-lucide="log-out" class="w-5 h-5"></i>
            <span>Logout</span>
        </button>
    </div>
</aside>

<!-- Main Content -->
<main class="pt-2 ml-64 px-6">
    <!-- Availability Toggle -->
    <div class="bg-gray-50 p-6 w-full max-w-[1500px]">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 w-full">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Availability Status</h3>
                    <p class="text-gray-600">Toggle your availability for new appointments</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span id="availabilityLabel" class="text-sm font-medium text-green-600">Available</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="availabilityToggle" class="sr-only peer" checked />
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full
                      peer peer-checked:after:translate-x-full peer-checked:after:border-white
                      after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                      after:bg-white after:border-gray-300 after:border after:rounded-full
                      after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                        </div>
                    </label>
                </div>
            </div>
        </div>
    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pending Appointments -->
<!--        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">-->
<!--            <div class="flex items-center justify-between">-->
<!--                <div>-->
<!--                    <p class="text-sm font-medium text-gray-600">Pending Appointments</p>-->
<!--                    <p class="text-2xl font-bold text-yellow-600">12</p>-->
<!--                </div>-->
<!--                <i data-lucide="clock" class="w-8 h-8 text-yellow-500"></i>-->
<!--            </div>-->
<!--        </div>-->

        <!-- Confirmed Today -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Completed</p>
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
                <p class="text-gray-900">Dr. Tomilade Yemi-Oyebola</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Licence Number</p>
                <p class="text-gray-900">MD123456</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Speciality</p>
                <p class="text-gray-900">General Medicine</p>
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
                <p class="text-sm font-medium text-gray-700 mb-1">Experience</p>
                <p class="text-gray-900">15 years</p>
            </div>
        </div>
    </div>



    <!-- Appointment Management -->
    <div class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-xl font-semibold mb-6">Appointments</h2>
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
                            <option value="confirmed">Urgent</option>
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
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Time</th>
                        <th class="px-6 py-3">Ailment</th>
                        <th class="px-6 py-3">Patient</th>
                        <th class="px-6 py-3">Assigned By</th>
                        <th class="px-6 py-3">Internal Note</th>
                        <td class="px-6 py-4 whitespace-nowrap">Status</td>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">Jun 13th, 25</td>
                        <td class="px-6 py-4 whitespace-nowrap">9am - 10am</td>
                        <td class="px-6 py-4 whitespace-nowrap">Regular checkup</td>
                        <td class="px-6 py-4 whitespace-nowrap">John Tomi</td>
                        <td class="px-6 py-4 whitespace-nowrap">Nurse Ola</td>
                        <td class="px-6 py-4 whitespace-nowrap">Patient has history of anxiety</td>
                        <td class="px-6 py-4 whitespace-nowrap">Confirmed</td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <button class="w-8 h-8 flex items-center justify-center bg-green-100 text-green-600 rounded-full hover:bg-green-200" title="Confirm">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                            </button>
                            <!-- Preview Button -->
                            <button onclick="openPatientPreview()" class="w-8 h-8 flex items-center justify-center text-blue-600 rounded-full hover:bg-blue-200" title="Preview">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                     stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>





    </div>
</main>

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

<!-- Patient Preview Modal -->
<div id="patientPreviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>

        <div class="space-y-4">
            <div>
                <p class="text-sm font-medium text-gray-700">Name</p>
                <p id="patientName" class="text-gray-900">--</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700">Age</p>
                <p id="patientAge" class="text-gray-900">--</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700">Allergies</p>
                <p id="patientAllergies" class="text-gray-900">--</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700">Last Visit</p>
                <p id="patientLastVisit" class="text-gray-900">--</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700">Condition</p>
                <p id="patientCondition" class="text-gray-900">--</p>
            </div>
        </div>

        <div class="flex space-x-3 pt-4 mt-4 border-t border-gray-200">
            <button onclick="closePatientPreview()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                Close
            </button>
        </div>
    </div>
</div>
<!-- Settings Modal -->
<div id="settingsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-[90%] max-w-4xl rounded-lg shadow-lg flex overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-100 p-4 border-r">
            <ul class="space-y-2">
                <li><button class="w-full text-left font-semibold text-gray-700 hover:text-blue-600">General</button></li>
                <li><button class="w-full text-left text-gray-700 hover:text-blue-600">Notifications</button></li>
                <li><button class="w-full text-left text-gray-700 hover:text-blue-600">Profile</button></li>
                <li><button class="w-full text-left text-gray-700 hover:text-blue-600">Security</button></li>
            </ul>
        </aside>

        <!-- Content -->
        <div class="flex-1 p-6 space-y-6">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">General Settings</h2>
                <button onclick="document.getElementById('settingsModal').classList.add('hidden')" class="text-gray-500 hover:text-red-600">&times;</button>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span>Theme</span>
                    <select class="border px-2 py-1 rounded">
                        <option>System</option>
                        <option>Light</option>
                        <option>Dark</option>
                    </select>
                </div>

                <div class="flex justify-between items-center">
                    <span>Enable Notifications</span>
                    <input type="checkbox" class="toggle toggle-primary" checked />
                </div>

                <div class="flex justify-between items-center">
                    <span>Language</span>
                    <select class="border px-2 py-1 rounded">
                        <option>Auto-detect</option>
                        <option>English</option>
                        <option>Spanish</option>
                    </select>
                </div>

                <div class="flex justify-between items-center">
                    <span>Change Password</span>
                    <button class="text-blue-600 hover:underline">Update</button>
                </div>

                <div class="flex justify-between items-center">
                    <span>Delete Account</span>
                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                </div>

                <div class="pt-4 border-t flex justify-end">
                    <button onclick="document.getElementById('settingsModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Close</button>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    // Get modal and close button
    const settingsModal = document.getElementById('settingsModal');
    const openSettingsBtn = document.getElementById('openSettingsBtn');
    const closeSettingsBtn = document.getElementById('closeSettingsBtn');

    // Open modal
    openSettingsBtn.addEventListener('click', () => {
        settingsModal.classList.remove('hidden');
    });

    // Close modal
    closeSettingsBtn.addEventListener('click', () => {
        settingsModal.classList.add('hidden');
    });

    // Optional: close modal when clicking outside it
    window.addEventListener('click', (e) => {
        if (e.target === settingsModal) {
            settingsModal.classList.add('hidden');
        }
    });
</script>

<script>
    const dummyData = {
        patientName: "John Doe",
        patientInfo: {
            age: 35,
            allergies: "Penicillin",
            lastVisit: "2025-06-01",
            condition: "Hypertension"
        }
    };

    function openPatientPreview() {
        // Replace with dynamic data if needed
        document.getElementById("patientName").textContent = dummyData.patientName;
        document.getElementById("patientAge").textContent = dummyData.patientInfo.age + " years";
        document.getElementById("patientAllergies").textContent = dummyData.patientInfo.allergies;
        document.getElementById("patientLastVisit").textContent = dummyData.patientInfo.lastVisit;
        document.getElementById("patientCondition").textContent = dummyData.patientInfo.condition;

        // Show modal
        document.getElementById("patientPreviewModal").classList.remove("hidden");
    }

    function closePatientPreview() {
        document.getElementById("patientPreviewModal").classList.add("hidden");
    }
</script>


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


<script>
    lucide.createIcons();
</script>

<script>
    function toggleDropdown() {
        document.getElementById("profileDropdown").classList.toggle("hidden");
    }
</script>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');

    function openSidebar() {
        sidebar.style.transform = 'translateX(0)';
    }
    function closeSidebar() {
        sidebar.style.transform = 'translateX(-100%)';
    }

    sidebarToggle.addEventListener('click', () => {
        if (sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === 'translateX(0)') {
            closeSidebar();
        } else {
            openSidebar();
        }
    });
    sidebarClose.addEventListener('click', closeSidebar);
    // Start with sidebar open on desktop, closed on mobile
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
