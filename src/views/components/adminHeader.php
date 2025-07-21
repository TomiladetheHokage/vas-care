<?php
require_once __DIR__ . '/../../config/constants.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$firstName = $_SESSION['user']['first_name'] ?? 'Admin';
?>
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome, <?= htmlspecialchars($firstName) ?>!</h1>
    <p class="text-gray-600">From here, you can view and manage all users in the system.</p>
</div>

<!-- Action Buttons -->
<div class="flex flex-wrap gap-3 mb-6">
    <button onclick="openModal('createUserModal')"  class="flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700
          rounded-md hover:bg-gray-50 focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m-6-6h12"></path></svg> Create New Staff
    </button>
</div>