<?php
// Sample doctor info (dynamic in real app)
$doctorName = "Dr. Yemi-Oyebola";
$doctorEmail = "dr.yemi@example.com";
$profilePicture = "https://i.pravatar.cc/150?img=15";

// Sample appointments data (fetch from DB in real app)
$appointments = [
    [
        "date" => "2025-05-18 09:30",
"ailment" => "Hypertension",
"medication" => "Lisinopril",
"history" => "High blood pressure for 3 years",
"nurse" => "Nurse Amina"
],
[
"date" => "2025-05-18 14:00",
"ailment" => "Diabetes",
"medication" => "Metformin",
"history" => "Type 2 diabetes, diagnosed 2018",
"nurse" => "Nurse John"
],
[
"date" => "2025-05-19 10:00",
"ailment" => "Asthma",
"medication" => "Albuterol",
"history" => "Asthma since childhood",
"nurse" => "Nurse Amina"
],
];
?>




        <!DOCTYPE html>
        <html lang="en" class="scroll-smooth">
        <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Doctor Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Profile Header -->
<header class="bg-white shadow p-6 flex items-center space-x-6 border-b border-gray-200">
    <img
            src="<?= htmlspecialchars($profilePicture) ?>"
            alt="Doctor Profile Picture"
            class="w-20 h-20 rounded-full border-4 border-indigo-600"
    />
    <div>
        <h1 class="text-3xl font-semibold text-gray-900">Welcome, <?= htmlspecialchars($doctorName) ?></h1>
        <p class="text-gray-600 mt-1"><?= htmlspecialchars($doctorEmail) ?></p>
        <div class="mt-3 space-x-6">
            <a
                    href="/edit-profile.php"
                    class="inline-block px-4 py-2 text-indigo-700 border border-indigo-700 rounded hover:bg-indigo-700 hover:text-white transition"
            >Edit Profile</a
            >
            <a
                    href="/logout.php"
                    class="inline-block px-4 py-2 text-red-600 border border-red-600 rounded hover:bg-red-600 hover:text-white transition"
            >Logout</a
            >
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="flex-grow max-w-7xl mx-auto p-6">

    <!-- Search and Filters -->
    <section
            class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0 mb-8"
    >
        <input
                id="searchInput"
                type="text"
                placeholder="Search by ailment, medication, nurse, history..."
                class="flex-grow rounded-md border border-gray-300 px-4 py-3 shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
        />
        <input
                id="dateFilter"
                type="date"
                class="rounded-md border border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
        />
        <input
                id="timeFilter"
                type="time"
                class="rounded-md border border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
        />
    </section>

    <!-- Appointments Table -->
    <section class="overflow-x-auto rounded-lg shadow bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-600">
            <tr>
                <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider"
                >
                    Date & Time
                </th>
                <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider"
                >
                    Ailment
                </th>
                <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider"
                >
                    Current Medication
                </th>
                <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider"
                >
                    Medical History
                </th>
                <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider"
                >
                    Nurse Assigned
                </th>
            </tr>
            </thead>
            <tbody id="appointmentsTableBody" class="bg-white divide-y divide-gray-200">
            <?php foreach ($appointments as $appt): ?>
            <tr class="hover:bg-indigo-50 cursor-pointer transition">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <?= htmlspecialchars(date("Y-m-d H:i", strtotime($appt["date"]))) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    <?= htmlspecialchars($appt["ailment"]) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    <?= htmlspecialchars($appt["medication"]) ?>
                </td>
                <td class="px-6 py-4 max-w-xs text-sm text-gray-700 truncate" title="<?= htmlspecialchars($appt["history"]) ?>">
                <?= htmlspecialchars($appt["history"]) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    <?= htmlspecialchars($appt["nurse"]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<script>
    // Filtering logic (same as before)
    const searchInput = document.getElementById("searchInput");
    const dateFilter = document.getElementById("dateFilter");
    const timeFilter = document.getElementById("timeFilter");
    const tableBody = document.getElementById("appointmentsTableBody");
    const rows = Array.from(tableBody.querySelectorAll("tr"));

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const dateTerm = dateFilter.value; // yyyy-mm-dd
        const timeTerm = timeFilter.value; // hh:mm

        rows.forEach(row => {
            const cells = row.querySelectorAll("td");
            const dateTimeText = cells[0].textContent.trim(); // "YYYY-MM-DD HH:mm"
            const ailment = cells[1].textContent.toLowerCase();
            const medication = cells[2].textContent.toLowerCase();
            const history = cells[3].textContent.toLowerCase();
            const nurse = cells[4].textContent.toLowerCase();

            const matchesSearch =
                ailment.includes(searchTerm) ||
                medication.includes(searchTerm) ||
                history.includes(searchTerm) ||
                nurse.includes(searchTerm);

            const matchesDate = dateTerm ? dateTimeText.startsWith(dateTerm) : true;
            const matchesTime = timeTerm ? dateTimeText.endsWith(timeTerm) : true;

            row.style.display = matchesSearch && matchesDate && matchesTime ? "" : "none";
        });
    }

    searchInput.addEventListener("input", filterTable);
    dateFilter.addEventListener("change", filterTable);
    timeFilter.addEventListener("change", filterTable);
</script>

</body>
</html>
</title>
</head>
<body>

</body>
</html>