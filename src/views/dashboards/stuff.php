<!-- Billing Info -->
<!--            <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group">-->
<!--                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">-->
<!-- Credit Card Icon -->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">-->
<!--                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>-->
<!--                        <path d="M16 3h-8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>-->
<!--                    </svg>-->
<!--                </div>-->
<!--                <p class="text-sm font-medium text-gray-900">Billing Info</p>-->
<!--            </button>-->

<!-- Messages -->
<!--            <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-center group">-->
<!--                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">-->
<!-- Message Icon -->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">-->
<!--                             <path d="M21 11.5a8.38 8.38 0 0 1-1.9 5.4 8.5 8.5 0 0 1-6.6 3.1 8.38 8.38 0 0 1-5.4-1.9L3 21l1.9-4.1a8.38 8.38 0 0 1-1.9-5.4 8.5 8.5 0 0 1 3.1-6.6 8.38 8.38 0 0 1 5.4-1.9h.5"/>-->
<!--                    </svg>-->
<!--                </div>-->
<!--                <p class="text-sm font-medium text-gray-900">Messages</p>-->
<!--            </button>-->








<!--        <a href="/appointments" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="calendar-check" class="w-5 h-5"></i>-->
<!--            <span>My Appointments</span>-->
<!--        </a>-->
<!--        <a href="/medical-records" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="file-text" class="w-5 h-5"></i>-->
<!--            <span>Medical Records</span>-->
<!--        </a>-->
<!--        <a href="/billing" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="credit-card" class="w-5 h-5"></i>-->
<!--            <span>Billing</span>-->
<!--        </a>-->
<!--        <a href="/messages" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">-->
<!--            <i data-lucide="message-square" class="w-5 h-5"></i>-->
<!--            <span>Messages</span>-->
<!--        </a>-->








<!-- Confirmed -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600 truncate">Confirmed</p>
            <p class="text-2xl font-bold text-gray-900 mt-2"><?= $statistics['total_confirmed_appointments'] ?? 0 ?></p>
        </div>
        <div class="p-3 rounded-full bg-green-500">
            <!-- CheckCircle Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a10 10 0 11-20 0 10 10 0 0120 0z" />
            </svg>
        </div>
    </div>
</div>

<!-- Denied -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600 truncate">Denied</p>
            <p class="text-2xl font-bold text-gray-900 mt-2"><?= $statistics['total_denied_appointments'] ?? 0 ?></p>
        </div>
        <div class="p-3 rounded-full bg-red-500">
            <!-- XCircle Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
    </div>
</div>

<!-- Cancelled -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600 truncate">Cancelled</p>
            <p class="text-2xl font-bold text-gray-900 mt-2"><?= $statistics['total_cancelled_appointments'] ?? 0 ?></p>
        </div>
        <div class="p-3 rounded-full bg-gray-500">
            <!-- AlertCircle Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
            </svg>
        </div>
    </div>
</div>