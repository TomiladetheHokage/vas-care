<?php
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
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

    <h2 class="text-2xl font-bold text-center mb-6 text-indigo-700">Register</h2>

    <?php if (!empty($error)): ?>
        <p class="text-red-500 mb-4 text-sm text-center"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="/vas-care/src/index.php?action=saveRegister" method="POST" class="space-y-4" enctype="multipart/form-data">
        <div>
            <label class="block text-sm font-medium text-gray-600">First Name</label>
            <input type="text" name="first_name" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['first_name'] ?? '') ?>"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Last Name</label>
            <input type="text" name="last_name" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['last_name'] ?? '') ?>"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Gender</label>
            <select name="gender" required
                    class="w-full mt-1 mb-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="" disabled <?= !isset($old['gender']) ? 'selected' : '' ?>>Select Gender</option>
                <option value="male" <?= ($old['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male</option>
                <option value="female" <?= ($old['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Phone Number</label>
            <input type="text" name="phone_number" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['phone_number'] ?? '') ?>"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Email</label>
            <input type="email" name="email" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>"/>
        </div>

<!--        <div>-->
<!--            <label class="block text-sm font-medium text-gray-600">Address</label>-->
<!--            <input type="text" name="address" required-->
<!--                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"-->
<!--                   value="--><?php //= htmlspecialchars($old['address'] ?? '') ?><!--"/>-->
<!--        </div>-->

        <div>
            <label class="block text-sm font-medium text-gray-600">Password</label>
            <div class="relative">
                <input type="password" name="password" id="password" required
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 pr-10" />
                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
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
            <label class="block text-sm font-medium text-gray-600">Profile picture</label>
            <input type="file" name="profile_picture"
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
            Register
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Already have an account?
        <a href="/vas-care/src/views/login.php" class="text-indigo-600 hover:underline">Login</a>
    </p>
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

