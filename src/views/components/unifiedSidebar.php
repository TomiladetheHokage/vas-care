<?php
// Usage: set $name, $email, $role, $profile_picture, $navLinks before including this file
if (!isset($name)) $name = '';
if (!isset($email)) $email = '';
if (!isset($role)) $role = '';
if (!isset($profile_picture)) $profile_picture = BASE_URL . '/assets/3.jpg';
if (!isset($navLinks)) $navLinks = [];
?>
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r shadow-lg flex flex-col transition-transform duration-300 transform -translate-x-full md:translate-x-0">
    <!-- Logo and Close Button (mobile) -->
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-xl font-bold text-blue-600">Vascare</h2>
        <button id="closeSidebarBtn" class="md:hidden text-gray-400 hover:text-gray-700">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>
    <!-- Profile Section -->
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                <img src="<?= htmlspecialchars($profile_picture) ?>" alt="Profile" class="w-10 h-10 object-cover rounded-full" />
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-900">Welcome,</h3>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($name) ?></p>
                <p class="text-xs text-gray-500"><?= htmlspecialchars($email) ?></p>
            </div>
        </div>
    </div>
    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <?php foreach ($navLinks as $link): ?>
            <?php if (!empty($link['onclick'])): ?>
                <button onclick="<?= $link['onclick'] ?>" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 w-full text-left">
                    <i data-lucide="<?= htmlspecialchars($link['icon']) ?>" class="w-5 h-5"></i>
                    <span><?= htmlspecialchars($link['label']) ?></span>
                </button>
            <?php else: ?>
                <a href="<?= htmlspecialchars($link['href']) ?>" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
                    <i data-lucide="<?= htmlspecialchars($link['icon']) ?>" class="w-5 h-5"></i>
                    <span><?= htmlspecialchars($link['label']) ?></span>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
    <!-- Logout Section -->
    <div class="px-4 py-4 border-t border-gray-100">
        <a href="<?php echo BASE_URL; ?>/index.php?action=logout" class="flex items-center gap-3 px-3 py-2 w-full rounded-md text-red-600 hover:bg-red-50">
            <i data-lucide="log-out" class="w-5 h-5"></i>
            <span>Logout</span>
        </a>
    </div>
</aside> 