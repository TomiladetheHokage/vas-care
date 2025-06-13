<!-- Search and Filters -->
<form method="GET" action="adminIndex.php" class="flex mb-6">
    <input type="hidden" name="action" value="viewAllUsers">

    <input type="text" name="search" class="border border-gray-300 rounded-md p-2 w-1/2 mr-2"
           placeholder="Search users..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

    <select name="role" class="border border-gray-300 rounded-md p-2 w-1/4 mr-2">
        <option value="">Filter by Role</option>
        <option value="doctor" <?= ($_GET['role'] ?? '') === 'doctor' ? 'selected' : '' ?>>Doctor</option>
        <option value="nurse" <?= ($_GET['role'] ?? '') === 'nurse' ? 'selected' : '' ?>>Nurse</option>
    </select>

    <select name="status" class="border border-gray-300 rounded-md p-2 w-1/4">
        <option value="">Filter by Status</option>
        <option value="active" <?= ($_GET['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
        <option value="inactive" <?= ($_GET['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
        <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
    </select>

    <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">Filter</button>
</form>

