<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//$userId = $_SESSION['user_id'];
$old = $_SESSION['old'] ?? [];
$error = $_SESSION['error'] ?? '';
unset($_SESSION['old'], $_SESSION['error']);

//echo $_SESSION['user']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

    <h2 class="text-2xl font-bold text-center mb-6 text-indigo-700">Book Appointment</h2>

    <?php if (!empty($error)): ?>
        <p class="text-red-500 mb-4 text-sm text-center"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="/vas-care/src/index.php?action=createAppointment" method="POST" class="space-y-4">
        <input type="hidden" name="patient_id" value="<?= htmlspecialchars($_SESSION['user']['user_id'] ?? '') ?>">

        <div>
            <label class="block text-sm font-medium text-gray-600">Date</label>
            <input type="date" name="appointment_date" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['appointment_date'] ?? '') ?>"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Start Time</label>
            <input type="time" id="slot_start" name="slot_start" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['slot_start'] ?? '') ?>"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">End Time</label>
            <input type="time" id="slot_end" name="slot_end" required readonly
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['slot_end'] ?? '') ?>"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Ailment</label>
            <input type="text" name="ailment" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['ailment'] ?? '') ?>"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Medical History</label>
            <input type="text" name="medical_history"
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['medical_history'] ?? '') ?>"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Current Medication</label>
            <input type="text" name="current_medication"
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['current_medication'] ?? '') ?>"/>
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
            Submit
        </button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startInput = document.getElementById('slot_start');
        const endInput = document.getElementById('slot_end');

        if (startInput && endInput) {
            startInput.addEventListener('change', function () {
                const startTime = this.value;  // "HH:MM"
                if (startTime) {
                    const [hours, minutes] = startTime.split(':').map(Number);
                    const date = new Date();
                    date.setHours(hours, minutes);

                    date.setMinutes(date.getMinutes() + 30); // add 30 mins

                    const endHours = date.getHours().toString().padStart(2, '0');
                    const endMinutes = date.getMinutes().toString().padStart(2, '0');
                    endInput.value = `${endHours}:${endMinutes}`;
                }
            });
        }
    });
</script>

</body>
</html>



