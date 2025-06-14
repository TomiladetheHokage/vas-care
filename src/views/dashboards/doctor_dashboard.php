<!--<td class="px-4 py-2 font-semibold">Maria Garcia <span class="text-red-500 text-xs">•</span></td>-->

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

<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r shadow-lg hidden md:flex flex-col">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-xl font-bold text-blue-600">Vascare</h2>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>
        <a href="/appointments" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="calendar-check" class="w-5 h-5"></i>
            <span>Appointments</span>
        </a>
        <a href="/patients" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="user" class="w-5 h-5"></i>
            <span>Patients</span>
        </a>
        <a href="/settings" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="settings" class="w-5 h-5"></i>
            <span>Settings</span>
        </a>
    </nav>
</aside>


<main class="pt-20 ml-64 px-6">
    <!-- Header -->
    <header class="ml-[-10px] w-[calc(100%-16rem)] bg-white shadow px-6 py-4 fixed top-0 z-30">
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


    <div class="max-w-[1300px] mx-auto flex flex-col items-center justify-center ">
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
        </div>



        <!-- Summary Cards -->
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 w-full px-4">
            <div class="bg-white p-4 rounded shadow text-center h-20">
                <p class="text-xl font-bold">24</p>
                <p class="text-blue-600">Total Assigned</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center h-20">
                <p class="text-xl font-bold">18</p>
                <p class="text-green-600">Completed</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center h-20">
                <p class="text-xl font-bold">6</p>
                <p class="text-yellow-600">Pending</p>
            </div>
        </section>

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
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Time</th>
                            <th class="px-6 py-3">Ailment</th>
                            <th class="px-6 py-3">Current Medication</th>
                            <th class="px-6 py-3">Patient</th>
                            <th class="px-6 py-3">Assigned By</th>
                            <th class="px-6 py-3">Internal Note</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">Jun 13th, 25</td>
                            <td class="px-6 py-4 whitespace-nowrap">9am - 10am</td>
                            <td class="px-6 py-4 whitespace-nowrap">Regular checkup</td>
                            <td class="px-6 py-4 whitespace-nowrap">Paracetamol</td>
                            <td class="px-4 py-2 font-semibold">Maria Garcia <span class="text-red-500 text-xs">•</span></td>
                            <td class="px-6 py-4 whitespace-nowrap">Nurse Ola</td>
                            <td class="px-6 py-4 whitespace-nowrap">Patient has history of anxiety</td>
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
    <script>
        lucide.createIcons();
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



</body>
</html>
