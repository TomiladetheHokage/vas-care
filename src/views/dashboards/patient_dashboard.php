<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Patient Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
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


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white">
            <h2 class="text-2xl font-bold mb-2">Welcome back, <!-- Insert first name here --></h2>
            <p class="text-blue-100">Here's an overview of your health journey with us.</p>
        </div>
    </div>

    <!-- Container for all stats -->
    <div id="statsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"></div>

    <script>
        // Sample data similar to appointmentStats
        const appointmentStats = [
            {
                title: "Total Appointments",
                value: 120,
                // Icon can be an SVG string or a class (we'll use inline SVG for demo)
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-white"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>`,
                color: "bg-blue-500",
                trend: { isPositive: true, value: "5%" }
            },
            {
                title: "Cancelled",
                value: 8,
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-white"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`,
                color: "bg-red-500",
                trend: { isPositive: false, value: "2%" }
            },
            // Add more stats as needed
        ];

        const statsGrid = document.getElementById('statsGrid');

        appointmentStats.forEach(stat => {
            const card = document.createElement('div');
            card.className = "bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200";

            card.innerHTML = `
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-medium text-gray-600 truncate">${stat.title}</p>
          <p class="text-2xl font-bold text-gray-900 mt-2">${stat.value}</p>
          ${stat.trend ? `<p class="text-sm mt-2 ${stat.trend.isPositive ? 'text-green-600' : 'text-red-600'}">
            ${stat.trend.isPositive ? '↗' : '↘'} ${stat.trend.value}
          </p>` : ''}
        </div>
        <div class="p-3 rounded-full ${stat.color}">
          ${stat.icon}
        </div>
      </div>
    `;

            statsGrid.appendChild(card);
        });
    </script>




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
        <div class="grid grid-cols-2 gap-4" id="quickAccessPanels">
            <!-- Panels will be injected here -->
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

        // Quick access panel data
        const panels = [
            {
                title: 'Medical Records',
                color: 'bg-purple-500',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path d="M9 12h6m-6 4h6m-7-8h8l4 4v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-6z"/>
      </svg>`,
                onClick: () => alert('Medical Records clicked')
            },
            {
                title: 'Billing Info',
                color: 'bg-green-500',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
        <path d="M16 3h-8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>
      </svg>`,
                onClick: () => alert('Billing Info clicked')
            },
            {
                title: 'Messages',
                color: 'bg-blue-500',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path d="M21 11.5a8.38 8.38 0 0 1-1.9 5.4 8.5 8.5 0 0 1-6.6 3.1 8.38 8.38 0 0 1-5.4-1.9L3 21l1.9-4.1a8.38 8.38 0 0 1-1.9-5.4 8.5 8.5 0 0 1 3.1-6.6 8.38 8.38 0 0 1 5.4-1.9h.5"/>
      </svg>`,
                onClick: () => alert('Messages clicked')
            },
            {
                title: 'Profile Settings',
                color: 'bg-gray-500',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="7" r="4" />
        <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
      </svg>`,
                onClick: () => alert('Profile Settings clicked')
            }
        ];

        const quickAccessPanels = document.getElementById('quickAccessPanels');

        panels.forEach(panel => {
            const btn = document.createElement('button');
            btn.className = "bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group flex flex-col items-center";
            btn.innerHTML = `
      <div class="${panel.color} w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
        ${panel.icon}
      </div>
      <p class="text-sm font-medium text-gray-900">${panel.title}</p>
    `;
            btn.addEventListener('click', panel.onClick);
            quickAccessPanels.appendChild(btn);
        });

        // Hook for Book New Appointment button
        document.getElementById('bookAppointmentBtn').addEventListener('click', () => {
            alert('Show booking form');
        });
    </script>


    <!-- Scrollable Table Container -->
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Past Appointments</h3>
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
</body>
</html>
