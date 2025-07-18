<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    document.addEventListener('click', function(event) {
        const modal = document.getElementById('createUserModal');
        if (!modal.classList.contains('hidden') && event.target === modal) {
            closeModal('createUserModal');
        }
    });

    function openSuccessModal(message) {
        const successModal = document.getElementById('successModal');
        const successMessage = document.getElementById('successMessage');
        successMessage.textContent = message;
        successModal.classList.remove('hidden');
    }

    function closeSuccessModal() {
        const successModal = document.getElementById('successModal');
        successModal.classList.add('hidden');
    }

    window.onload = function () {
        <?php if (isset($_SESSION['message'])): ?>
        openSuccessModal("<?= $_SESSION['message']; ?>");
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    };
</script>
<script>
    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu !== dropdown) menu.classList.add('hidden');
        });
        dropdown.classList.toggle('hidden');
    }

    // Optional: close dropdown if user clicks outside
    document.addEventListener('click', function (event) {
        const isDropdown = event.target.closest('.dropdown-menu') || event.target.closest('button[onclick^="toggleDropdown"]');
        if (!isDropdown) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
        }
    });
</script>
<script>
    if (window.lucide) {
        lucide.createIcons();
    }
</script>