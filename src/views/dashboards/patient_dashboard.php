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
                <p class="text-sm text-gray-600">John Doe</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>
        <a href="/appointments" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="calendar-check" class="w-5 h-5"></i>
            <span>My Appointments</span>
        </a>
        <a href="/medical-records" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span>Medical Records</span>
        </a>
        <a href="/billing" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="credit-card" class="w-5 h-5"></i>
            <span>Billing</span>
        </a>
        <a href="/messages" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="message-square" class="w-5 h-5"></i>
            <span>Messages</span>
        </a>
        <a href="/profile" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
            <i data-lucide="user-circle" class="w-5 h-5"></i>
            <span>Edit Profile</span>
        </a>
        <a href="/settings" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
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
<main class="pt-10 ml-64 px-6">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white">
            <h2 class="text-2xl font-bold mb-2">Welcome back, <!-- Insert first name here --></h2>
            <p class="text-blue-100">Here's an overview of your health journey with us.</p>
        </div>
    </div>

    <!-- Container for all stats -->
    <div id="statsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mb-10"></div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 truncate">Pending</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">3</p>
                </div>
                <div class="p-3 rounded-full bg-yellow-500">
                    <!-- Clock Icon -->
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
                    <p class="text-2xl font-bold text-gray-900 mt-2">8</p>
                </div>
                <div class="p-3 rounded-full bg-green-500">
                    <!-- CheckCircle Icon -->
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
                    <p class="text-2xl font-bold text-gray-900 mt-2">1</p>
                </div>
                <div class="p-3 rounded-full bg-red-500">
                    <!-- XCircle Icon -->
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
                    <p class="text-2xl font-bold text-gray-900 mt-2">2</p>
                </div>
                <div class="p-3 rounded-full bg-gray-500">
                    <!-- AlertCircle Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>




    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <!-- Upcoming Appointments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Upcoming Appointments</h3>
                <!-- Calendar icon (simple SVG) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
            </div>

            <div id="appointmentsList" class="space-y-4">
                <!-- Appointments will be injected here -->
            </div>

            <!-- Trigger Button -->
            <button
                    id="bookAppointmentBtn"
                    class="w-full mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center space-x-2"
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
        <!-- Quick Access Panels -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Medical Records -->
            <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 12h6m-6 4h6m-7-8h8l4 4v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-6z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-900">Medical Records</p>
            </button>

            <!-- Billing Info -->
            <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                    <!-- Credit Card Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 3h-8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-900">Billing Info</p>
            </button>

            <!-- Messages -->
            <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                    <!-- Message Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                             <path d="M21 11.5a8.38 8.38 0 0 1-1.9 5.4 8.5 8.5 0 0 1-6.6 3.1 8.38 8.38 0 0 1-5.4-1.9L3 21l1.9-4.1a8.38 8.38 0 0 1-1.9-5.4 8.5 8.5 0 0 1 3.1-6.6 8.38 8.38 0 0 1 5.4-1.9h.5"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-900">Messages</p>
            </button>

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

    <script>
        // Sample upcoming appointments data
        const upcomingAppointments = [
            {
                doctor: "Dr. Sarah Johnson",
                specialty: "Cardiology",
                date: "June 20, 2025",
                time: "10:00 AM",
                status: "Confirmed"
            },
            {
                doctor: "Dr. Michael Smith",
                specialty: "Dermatology",
                date: "June 22, 2025",
                time: "2:30 PM",
                status: "Pending"
            },
            // add more if you want
        ];

        const appointmentsList = document.getElementById('appointmentsList');
        upcomingAppointments.forEach(appointment => {
            const statusClasses = appointment.status === "Confirmed"
                ? "bg-green-100 text-green-800"
                : "bg-yellow-100 text-yellow-800";

            const appointmentDiv = document.createElement('div');
            appointmentDiv.className = "flex items-center justify-between p-4 bg-gray-50 rounded-lg";
            appointmentDiv.innerHTML = `
      <div>
        <p class="font-medium text-gray-900">${appointment.doctor}</p>
        <p class="text-sm text-gray-600">${appointment.specialty}</p>
        <p class="text-sm text-gray-500">${appointment.date} at ${appointment.time}</p>
      </div>
      <span class="px-2 py-1 rounded-full text-xs font-medium ${statusClasses}">
        ${appointment.status}
      </span>
    `;
            appointmentsList.appendChild(appointmentDiv);
        });

    //     // Quick access panel data
    //     const panels = [
    //         {
    //             title: 'Medical Records',
    //             color: 'bg-purple-500',
    //             icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    //     <path d="M9 12h6m-6 4h6m-7-8h8l4 4v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-6z"/>
    //   </svg>`,
    //             onClick: () => alert('Medical Records clicked')
    //         },
    //         {
    //             title: 'Billing Info',
    //             color: 'bg-green-500',
    //             icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    //     <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
    //     <path d="M16 3h-8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>
    //   </svg>`,
    //             onClick: () => alert('Billing Info clicked')
    //         },
    //         {
    //             title: 'Messages',
    //             color: 'bg-blue-500',
    //             icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    //     <path d="M21 11.5a8.38 8.38 0 0 1-1.9 5.4 8.5 8.5 0 0 1-6.6 3.1 8.38 8.38 0 0 1-5.4-1.9L3 21l1.9-4.1a8.38 8.38 0 0 1-1.9-5.4 8.5 8.5 0 0 1 3.1-6.6 8.38 8.38 0 0 1 5.4-1.9h.5"/>
    //   </svg>`,
    //             onClick: () => alert('Messages clicked')
    //         },
    //         {
    //             title: 'Profile Settings',
    //             color: 'bg-gray-500',
    //             icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    //     <circle cx="12" cy="7" r="4" />
    //     <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
    //   </svg>`,
    //         }
    //     ];
    //
    //     const quickAccessPanels = document.getElementById('quickAccessPanels');
    //
    //     panels.forEach(panel => {
    //         const btn = document.createElement('button');
    //         btn.className = "bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group flex flex-col items-center";
    //         btn.innerHTML = `
    //   <div class="${panel.color} w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
    //     ${panel.icon}
    //   </div>
    //   <p class="text-sm font-medium text-gray-900">${panel.title}</p>
    // `;
    //         btn.addEventListener('click', panel.onClick);
    //         quickAccessPanels.appendChild(btn);
    //     });
    </script>


    <!-- Appointment Management -->
    <div class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-xl font-semibold mb-6">Past Appointments</h2>
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
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">Jun 13th, 25</td>
                        <td class="px-6 py-4 whitespace-nowrap">Jun 13th, 25</td>
                        <td class="px-6 py-4 whitespace-nowrap">9am - 10am</td>
                        <td class="px-6 py-4 whitespace-nowrap">Regular checkup</td>
                        <td class="px-6 py-4 whitespace-nowrap">Dr. Yinka</td>
                        <td class="px-6 py-4 whitespace-nowrap">Nurse Ola</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">Please arrive 15 minutes early</td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <button
                                    id="cancelBtn"
                                    class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-200"
                                    title="Cancel"
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

</div>
<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Book New Appointment</h3>

        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date</label>
                <input
                        type="date"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ailment (Optional)</label>
                <textarea
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Describe your symptoms or concern..."
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Medication (Optional)</label>
                <input
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
<!-- JavaScript to Toggle Modal -->
<script>
    const openBtn = document.getElementById('bookAppointmentBtn');
    const modal = document.getElementById('bookingModal');
    const cancelBtn = document.getElementById('cancelBookingBtn');

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
</script>
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
        lucide.createIcons();
    </script>

</main>
</body>
</html>
