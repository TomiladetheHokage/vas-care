<!-- Users Table -->
<?php if (empty($users)): ?>
    <div class="text-center text-gray-500 text-lg">
        No users found.
    </div>
<?php else: ?>
    <div class="overflow-x-auto bg-white shadow-sm rounded-lg">
        <table class="min-w-full table-auto text-left border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
            <tr>
                <th class="px-4 py-2 border-b">First Name</th>
                <th class="px-4 py-2 border-b">Last Name</th>
                <th class="px-4 py-2 border-b">Email</th>
                <th class="px-4 py-2 border-b">Role</th>
                <th class="px-4 py-2 border-b">Status</th>
                <th class="px-4 py-2 border-b">Actions</th>
            </tr>
            </thead>
            <tbody class="text-sm text-gray-800">
            <?php foreach ($users as $user): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?= htmlspecialchars($user['first_name']) ?></td>
                    <td class="px-4 py-2 border-b"><?= htmlspecialchars($user['last_name']) ?></td>
                    <td class="px-4 py-2 border-b"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="px-4 py-2 border-b"><?= htmlspecialchars($user['role']) ?></td>
                    <td class="px-4 py-2 border-b">
                        <?php if ($user['status'] === 'active'): ?>
                            <span class="text-green-600 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i> Active</span>
                        <?php else: ?>
                            <span class="text-red-600 font-semibold"><i class="fa-solid fa-circle-xmark mr-1"></i> Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 border-b relative">
                        <div class="relative inline-block text-left">
                            <button onclick="toggleDropdown(this)" type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                                    aria-expanded="true" aria-haspopup="true">
                                Actions
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div class="dropdown-menu hidden absolute right-0 mt-2 w-36 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                                <form action="/vas-care/src/adminIndex.php?action=updateUserStatus" method="post" class="block w-full">
                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" name="action" value="activate"
                                            class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-gray-100">
                                        <i class="fa-solid fa-square-check text-green-600 text-lg"></i> Activate
                                    </button>
                                </form>
                                <form action="/vas-care/src/adminIndex.php?action=updateUserStatus" method="post" class="block w-full">
                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                    <input type="hidden" name="status" value="inactive">
                                    <button type="submit" name="action" value="deactivate"
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fa-solid fa-square-xmark text-red-600 text-lg"></i> Deactivate
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>