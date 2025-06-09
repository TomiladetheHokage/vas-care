<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
        <p class="text-2xl font-semibold text-gray-800 mt-1"><?= $statistics['total_users'] ?? 0 ?></p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="text-sm font-medium text-gray-500">Active Users</h3>
        <p class="text-2xl font-semibold text-green-600 mt-1"><?= $statistics['active_users'] ?? 0 ?></p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="text-sm font-medium text-gray-500">Doctors</h3>
        <p class="text-2xl font-semibold text-indigo-600 mt-1"><?= $statistics['total_doctors'] ?? 0 ?></p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="text-sm font-medium text-gray-500">Nurses</h3>
        <p class="text-2xl font-semibold text-blue-600 mt-1"><?= $statistics['total_nurses'] ?? 0 ?></p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="text-sm font-medium text-gray-500">Patients</h3>
        <p class="text-2xl font-semibold text-blue-600 mt-1"><?= $statistics['total_patients'] ?? 0 ?></p>
    </div>
</div>
