<!-- Sidebar -->
<aside class="w-64 bg-[#f2f2f2] shadow-md p-6 hidden md:block mt-[-20px] ml-[-20px]">
    <div class="flex flex-col items-center">
        <!-- Profile Picture -->
        <img src="<?= '/vas-care/src/public/' . $pfp ?>" alt="Profile" class="rounded-full w-10 h-10 object-cover" />

        <p class="mt-4 text-sm font-semibold">Welcome <?= htmlspecialchars($firstName) ?></p>

        <p class="text-xs text-gray-500"><?= htmlspecialchars($email) ?></p>

        <a  href="/vas-care/src/adminIndex.php?action=logout"
            class="mt-4 w-full bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 text-sm">
            Logout
        </a>
    </div>
</aside>
