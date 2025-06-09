<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-sm text-gray-500">Total Appointments</p>
        <p class="text-xl font-bold"><?= $statistics['total_appointments'] ?? 0 ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-sm text-gray-500">Pending</p>
        <p class="text-xl font-bold text-yellow-500"><?= $statistics['total_pending_appointments'] ?? 0 ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-sm text-gray-500">Denied</p>
        <p class="text-xl font-bold text-gray-500"><?= $statistics['total_denied_appointments'] ?? 0 ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-sm text-gray-500">Confirmed</p>
        <p class="text-xl font-bold text-gray-500"><?= $statistics['total_confirmed_appointments'] ?? 0 ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-sm text-gray-500">Cancelled</p>
        <p class="text-xl font-bold text-gray-500"><?= $statistics['total_cancelled_appointments'] ?? 0 ?></p>
    </div>
    <!--            <div class="bg-white p-4 rounded-lg shadow text-center">-->
    <!--                <p class="text-sm text-gray-500">Completed</p>-->
    <!--                <p class="text-xl font-bold text-gray-500">--><?php //= $statistics['total_confirmed_completed'] ?? 0 ?><!--</p>-->
    <!--            </div>-->
</div>