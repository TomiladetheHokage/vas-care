<?php
require_once __DIR__ . '/../config/constants.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$old = $_SESSION['old'] ?? [];
$error = $_SESSION['error'] ?? '';
unset($_SESSION['old'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen min-w-screen w-screen h-screen overflow-hidden relative bg-white flex items-center justify-center">
    <div class="flex w-full h-full items-center justify-center">
        <!-- Left: Image (hidden on mobile) -->
        <div class="hidden md:flex w-1/2 h-full relative">
            <img src="<?php echo BASE_URL; ?>/../src/assets/female-canditat.jpg" alt="Background" class="object-cover w-full h-full" />
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        </div>
        <!-- Right: Register Form -->
        <div class="w-full max-w-xl mx-auto px-6 py-6 flex flex-col justify-center">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-gray-900 text-left">Create an account</h2>
            <?php if (!empty($error)): ?>
                <p class="text-red-500 mb-4 text-sm text-left bg-red-50 px-2 py-1 rounded"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form action="<?php echo BASE_URL; ?>/index.php?action=saveRegister" method="POST" class="space-y-4" enctype="multipart/form-data">
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-900 mb-2">First Name</label>
                        <input type="text" name="first_name" required
                               class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 placeholder-gray-400 text-gray-900 font-normal"
                               value="<?= htmlspecialchars($old['first_name'] ?? '') ?>" placeholder="First name"/>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-900 mb-2">Last Name</label>
                        <input type="text" name="last_name" required
                               class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 placeholder-gray-400 text-gray-900 font-normal"
                               value="<?= htmlspecialchars($old['last_name'] ?? '') ?>" placeholder="Last name"/>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Gender</label>
                    <select name="gender" required
                            class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-gray-900">
                        <option value="" disabled <?= !isset($old['gender']) ? 'selected' : '' ?>>Select Gender</option>
                        <option value="male" <?= ($old['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= ($old['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Phone Number</label>
                    <input type="text" name="phone_number" required
                           class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 placeholder-gray-400 text-gray-900 font-normal"
                           value="<?= htmlspecialchars($old['phone_number'] ?? '') ?>" placeholder="Phone number"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Email</label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 placeholder-gray-400 text-gray-900 font-normal"
                           value="<?= htmlspecialchars($old['email'] ?? '') ?>" placeholder="Enter your mail"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 placeholder-gray-400 text-gray-900 font-normal pr-10" placeholder="Enter your password" />
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors">
                            <!-- Eye Open SVG -->
                            <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <!-- Eye Closed SVG -->
                            <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.953 9.953 0 012.293-3.95m3.507-2.527A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-1.357 2.572M15 12a3 3 0 01-3 3m0 0a3 3 0 01-3-3m3 3L3 3"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Profile Picture</label>
                    <input type="file" name="profile_picture"
                           class="w-full px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-gray-900" />
                </div>
                <div class="flex items-center mb-2">
                    <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-700">I agree to all the <a href="#" class="underline text-blue-700">Terms & Conditions</a></label>
                </div>
                <button type="submit"
                        class="w-full bg-blue-900 text-white px-4 py-3 rounded-lg font-semibold text-base hover:bg-blue-800 transition-all duration-200 mt-2">
                    Sign up
                </button>
            </form>
            <p class="mt-8 text-center text-sm text-gray-500">
                Already have an account?
                <a href="<?php echo BASE_URL; ?>/views/login.php" class="text-blue-900 hover:underline font-medium transition-colors">Login</a>
            </p>
        </div>
    </div>
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const openEye = document.getElementById('eye-open');
        const closedEye = document.getElementById('eye-closed');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            openEye.classList.add('hidden');
            closedEye.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            openEye.classList.remove('hidden');
            closedEye.classList.add('hidden');
        }
    }
</script>
</body>
</html>
