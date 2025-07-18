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
            <img src="<?php echo BASE_URL; ?>/assets/female-canditat.jpg" alt="Background" class="object-cover w-full h-full" />
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        </div>
        <!-- Right: Register Form -->
        <div class="w-full max-w-xl mx-auto px-6 py-6 flex flex-col justify-center">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <span class="text-3xl font-extrabold text-blue-700 tracking-tight">Vas<span class="text-blue-400">Care</span></span>
            </div>
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
                <!-- Register Button -->
                <button type="submit"
                        class="w-full bg-blue-900 text-white px-4 py-3 rounded-lg font-semibold text-base hover:bg-blue-800 transition-all duration-200 mt-2">
                    Sign up
                </button>
                <!-- Or divider -->
                <div class="flex items-center my-4">
                    <div class="flex-grow h-px bg-gray-200"></div>
                    <span class="mx-2 text-gray-400 text-xs">or</span>
                    <div class="flex-grow h-px bg-gray-200"></div>
                </div>
                <!-- Google Sign In -->
                <button type="button" id="googleSignInBtn" class="w-full flex items-center justify-center border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition mb-2 bg-white shadow-sm cursor-not-allowed" tabindex="-1">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 48 48"><g><path fill="#4285F4" d="M24 9.5c3.54 0 6.36 1.46 7.82 2.68l5.8-5.8C34.36 3.54 29.64 1.5 24 1.5 14.82 1.5 6.98 7.98 3.68 16.44l6.74 5.23C12.36 15.36 17.7 9.5 24 9.5z"/><path fill="#34A853" d="M46.1 24.5c0-1.64-.15-3.22-.43-4.74H24v9.24h12.4c-.54 2.9-2.18 5.36-4.64 7.04l7.18 5.6C43.82 37.18 46.1 31.36 46.1 24.5z"/><path fill="#FBBC05" d="M10.42 28.67A14.98 14.98 0 019.5 24c0-1.62.28-3.18.78-4.67l-6.74-5.23A23.94 23.94 0 001.5 24c0 3.82.92 7.44 2.54 10.67l6.38-6z"/><path fill="#EA4335" d="M24 46.5c6.48 0 11.92-2.14 15.9-5.82l-7.18-5.6c-2.02 1.36-4.6 2.17-8.72 2.17-6.3 0-11.64-5.86-13.58-13.44l-6.74 5.23C6.98 40.02 14.82 46.5 24 46.5z"/></g></svg>
                    <span class="font-medium text-gray-700">Sign in with Google</span>
                </button>
                <!-- Toast for Google Sign In -->
                <div id="googleToast" class="fixed left-1/2 bottom-8 transform -translate-x-1/2 bg-blue-700 text-white px-4 py-2 rounded-lg shadow-lg text-sm opacity-0 pointer-events-none transition-opacity duration-300 z-50">
                    Google sign-in coming soon!
                </div>
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
<script>
        const googleBtn = document.getElementById('googleSignInBtn');
        const googleToast = document.getElementById('googleToast');
        function isMobile() {
            return window.innerWidth < 768;
        }
        googleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (isMobile()) {
                googleToast.classList.remove('opacity-0', 'pointer-events-none');
                googleToast.classList.add('opacity-100');
                setTimeout(() => {
                    googleToast.classList.add('opacity-0');
                    googleToast.classList.remove('opacity-100');
                }, 2000);
            }
        });
        </script>
</body>
</html>
