<?php
require_once __DIR__ . '/../../config/constants.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vascare</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col">

<div>

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <i data-lucide="heart-pulse" class="h-8 w-8 text-blue-600"></i>
                    <span class="ml-2 text-2xl font-bold text-gray-900">Vascare</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-700 hover:text-blue-600">Home</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600">Services</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600">Doctors</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600">Contact</a>
                </div>
            </div>
        </div>
    </nav>

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
                        At Vascare, we combine world-class medical expertise with cutting-edge technology to provide exceptional healthcare services. Our dedicated team of professionals is committed to your well-being.
                    </p>
                    <div class="mt-10">
                        <?php
                        if (!defined('BASE_URL')) {
                            define('BASE_URL', '/vas-care/src'); // or your actual URL
                        }
                        ?>

                        <a href="<?= BASE_URL ?>/views/login.php" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-300">
                            <i data-lucide="calendar" class="h-5 w-5 mr-2"></i>
                            Book Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center">
                        <i data-lucide="heart-pulse" class="h-8 w-8 text-blue-500"></i>
                        <span class="ml-2 text-2xl font-bold text-white">Vascare</span>
                    </div>
                    <p class="mt-4 text-gray-400">
                        Providing quality healthcare services with compassion and excellence.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-blue-500">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-500">Our Services</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-500">Find a Doctor</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-500">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Contact Info</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i data-lucide="map-pin" class="h-5 w-5 mr-2"></i>
                            123 Healthcare Ave, Medical City
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="phone" class="h-5 w-5 mr-2"></i>
                            +1 (555) 123-4567
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="mail" class="h-5 w-5 mr-2"></i>
                            info@vascare.com
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; 2024 Vascare Hospital. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
