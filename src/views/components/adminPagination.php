<!--        CONSIDER ADDING A DROP-DOWN FOR ALLOWING USERS SELECT HOW MANY ROWS THEY WANT TO SEE, 5-10, 10-25,50-100.-->
<!-- Pagination (simplified) -->
<?php if (!empty($users)): ?>
    <div class="mt-4 flex items-center justify-between">
        <div class="text-sm text-gray-500">
            Showing <?= count($users) ?> of <?= $total ?> users
        </div>
        <div class="flex items-center space-x-2">
            <?php if ($page > 1): ?>
                <a href="?action=viewAllUsers&page=<?= $page - 1 ?>"
                   class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>
            <?php else: ?>
                <button
                        class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md opacity-50 cursor-not-allowed" disabled>
                    Previous
                </button>
            <?php endif; ?>

            <span class="px-3 py-1 rounded-md bg-indigo-100 text-indigo-700 font-medium text-sm"><?= $page ?></span>

            <?php if (!empty($nextPageUsers)): ?>
                <a href="?action=viewAllUsers&page=<?= $page + 1 ?>"
                   class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md hover:bg-gray-50">Next</a>
            <?php else: ?>
                <button
                        class="px-3 py-1 text-sm text-gray-500 border border-gray-300 rounded-md opacity-50 cursor-not-allowed" disabled>
                    Next
                </button>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="mt-4 text-center text-gray-500 text-sm">
        No users found.
    </div>
<?php endif; ?>

