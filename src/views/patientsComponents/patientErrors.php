<?php if (isset($_SESSION['error'])): ?>
    <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 mx-4">
            <h2 class="text-red-600 text-xl font-semibold mb-4">Error</h2>
            <p class="mb-6 text-gray-800"><?= htmlspecialchars($_SESSION['error']) ?></p>
            <button id="closeErrorModal" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                Close
            </button>
        </div>
    </div>
    </div>
    <script>
        document.getElementById('closeErrorModal').addEventListener('click', () => {
            document.getElementById('errorModal').style.display = 'none';
        });
        document.getElementById('errorModal').addEventListener('click', (e) => {
            if (e.target.id === 'errorModal') {
                document.getElementById('errorModal').style.display = 'none';
            }
        });
    </script>
    <?php unset($_SESSION['error']); endif; ?>