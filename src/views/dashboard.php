<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;
$firstName = $isLoggedIn ? htmlspecialchars($user['first_name']) : '';
$firstName = $isLoggedIn ? htmlspecialchars($user['first_name']) : '';
$email = $isLoggedIn ? htmlspecialchars($user['email']) : '';
$role = $isLoggedIn ? htmlspecialchars($user['role']) : '';




$isPfPPresent = isset($_SESSION['user']['profile_picture']);
$pfp = $isPfPPresent ? $_SESSION['user']['profile_picture'] : '';
$profile_picture = $pfp;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vascare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex min-h-screen flex-col">

<!-- Navbar -->
<nav class="bg-white shadow-md fixed w-full top-0 z-20">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="text-2xl font-bold text-indigo-600">Vascare</div>
        <ul class="hidden md:flex space-x-8 text-gray-600 font-semibold">
            <li><a href="#hero" class="hover:text-indigo-600 transition">Home</a></li>
            <li><a href="#about" class="hover:text-indigo-600 transition">About</a></li>
            <li><a href="#contact" class="hover:text-indigo-600 transition">Contact</a></li>
        </ul>
        <button
                class="md:hidden text-indigo-600 focus:outline-none"
                id="mobile-menu-button"
                aria-label="Open Menu"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
    <!-- Mobile Menu -->
    <div
            id="mobile-menu"
            class="hidden md:hidden bg-white shadow-md"
    >
        <ul class="flex flex-col px-6 py-4 space-y-4">
            <li><a href="#hero" class="hover:text-indigo-600 font-semibold">Home</a></li>
            <li><a href="#about" class="hover:text-indigo-600 font-semibold">About</a></li>
            <li><a href="#contact" class="hover:text-indigo-600 font-semibold">Contact</a></li>
        </ul>
    </div>
</nav>

<div class="flex flex-1 pt-16">

    <!-- Sidebar -->
    <aside class="hidden lg:flex flex-col w-72 bg-white shadow-lg p-6 sticky top-16 h-[calc(100vh-4rem)]">
        <div class="flex flex-col items-center space-y-4 mb-8">
            <?php if ($isLoggedIn): ?>
            <img src="<?= !empty($profile_picture) ? '/vas-care/src/public/' . $profile_picture : '/vas-care/src/assests/3.jpg' ?>" alt="Profile Picture"
                    class="w-24 h-24 rounded-full object-cover border-4 border-indigo-600"
            />
            <div class="text-center">
                <p class="text-xl font-semibold text-gray-800">Welcome <strong><?= $firstName ?></strong></p>
                <p class="text-sm text-gray-500"><?=$email?></p>
                <p class="text-sm text-gray-500"><?=$role?></p>

            </div>
            <?php else: ?>
                <p class="text-gray-600">You're not logged in.</p>
                <a href="/vas-care/src/views/register.php" class="block text-blue-600 hover:underline">Register</a>
                <a href="/vas-care/src/views/login.php" class="block text-blue-600 hover:underline">Login</a>
            <?php endif; ?>

        </div>

        <nav class="flex flex-col space-y-3 flex-grow">
            <a href="#" class="px-4 py-2 rounded-md text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 font-semibold transition">Dashboard</a>
<!--            <a href="#" class="px-4 py-2 rounded-md text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 font-semibold transition">Book Appointment</a>-->
            <a href="#" class="px-4 py-2 rounded-md text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 font-semibold transition">My Appointments</a>
            <a href="#" class="px-4 py-2 rounded-md text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 font-semibold transition">Edit Profile</a>
        </nav>

        <?php if ($isLoggedIn): ?>
        <a  href="/vas-care/src/index.php?action=logout" class="mt-auto bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-semibold transition">
            Logout
        </a>
        <?php endif; ?>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 max-w-7xl mx-auto">

        <!-- Hero Section -->
        <main class="flex-grow">
            <div class="relative">
                <div class="absolute inset-0">
                    <img
                            src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80"
                            alt="Hospital"
                            class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gray-900 bg-opacity-50"></div>
                </div>

                <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                            Your Health Is Our Priority
                        </h1>
                        <p class="mt-6 text-xl text-gray-100 max-w-3xl">
                            At Vascare, we combine world-class medical expertise with cutting-edge technology to provide exceptional healthcare services.
                        </p>
                        <div class="mt-10">
                            <a href="/vas-care/src/views/createAppointment.php"
                               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md
                               text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-300">
                                Book Appointment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- About Section -->
        <section
                id="about"
                class="mt-20 max-w-4xl mx-auto text-center"
        >
            <h2 class="text-3xl font-bold mb-4 text-indigo-700">About Vascare</h2>
            <p class="text-gray-700 leading-relaxed">
                At Vascare, we are committed to ensuring our patients receive the best possible care.
                Our hospital combines modern medical technology with a compassionate team of healthcare
                professionals to provide an exceptional healthcare experience.
            </p>
        </section>

        <!-- Optional Contact Section -->
        <section
                id="contact"
                class="mt-12 max-w-4xl mx-auto text-center text-gray-600"
        >
            <h3 class="text-xl font-semibold mb-2">Contact Us</h3>
            <p>Email: support@vascare.com</p>
            <p>Phone: +234 800 123 4567</p>
            <p>Address: 123 Health Street, Lagos, Nigeria</p>
        </section>

    </main>
</div>

<!-- Footer -->
<footer class="bg-white shadow-inner py-6 text-center text-gray-500 text-sm mt-auto">
    &copy; 2025 Vascare Hospital. All rights reserved.
</footer>

<script>
    // Mobile menu toggle
    const menuBtn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    menuBtn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    function logout() {
        alert('Logging out...');
        window.location.href = 'logout.php'; // Update with your logout handler
    }
</script>
</body>
</html>


</body>
</html>