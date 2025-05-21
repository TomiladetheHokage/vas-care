<div class="hidden sm:block">
    <?php if (empty($contacts)): ?>
        <p class="text-gray-500">No contacts found.</p>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table id="contact-table" class="min-w-full table-fixed divide-y divide-gray-200 text-xl">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider break-words w-1/4">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider break-words w-1/3">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider break-words w-1/4">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Actions!</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td class="px-6 py-4 break-words"><?= htmlspecialchars($contact['name']) ?></td>
                        <td class="px-6 py-4 break-words"><?= htmlspecialchars($contact['email']) ?></td>
                        <td class="px-6 py-4 break-words"><?= htmlspecialchars($contact['phone']) ?></td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button onclick="openEditModal(<?= $contact['id'] ?>,
                                    '<?= htmlspecialchars($contact['name'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($contact['email'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($contact['phone'], ENT_QUOTES) ?>')"
                                        class="text-blue-600 hover:text-blue-800">Edit</button>
                                <a href="/contact-manager2/index.php?action=delete&id=<?= $contact['id'] ?>" class="text-red-600 hover:text-red-800">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p class="px-6 py-4 font-semibold text-gray-700">
                Total contacts: <?php echo isset($contactCount) ? $contactCount : 'Not Available'; ?>
            </p>
        </div>
    <?php endif; ?>
</div>