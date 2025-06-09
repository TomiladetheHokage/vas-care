<script>

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
        currentCancelFormId = null;
    }

    document.getElementById('confirmCancelBtn').addEventListener('click', function () {
        if (currentCancelFormId) document.getElementById(currentCancelFormId).submit();
    });
    //
    // function openEditModal(id, selectElement) {
    //     const modal = document.getElementById('editModal');
    //
    //     document.getElementById('edit_appointment_id').value = id;
    //
    //     document.querySelector("input[name='appointment_date']").value = selectElement.dataset.appointmentDate;
    //     document.querySelector("textarea[name='ailment']").value = selectElement.dataset.ailment;
    //     document.querySelector("input[name='medical_history']").value = selectElement.dataset.medicalHistory;
    //     document.querySelector("input[name='current_medication']").value = selectElement.dataset.currentMedication;
    //
    //     modal.classList.remove('hidden');
    // }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function handleActionSelect(selectElement) {
        const selectedValue = selectElement.value;

        if (selectedValue.startsWith("edit-")) {
            const appointmentId = selectedValue.split("-")[1];

            // ✅ Fill fields
            document.getElementById('edit_appointment_id').value = appointmentId;
            document.getElementById('edit_appointment_date').value = selectElement.dataset.appointmentDate;
            document.getElementById('edit_ailment').value = selectElement.dataset.ailment;
            document.getElementById('edit_medical_history').value = selectElement.dataset.medicalHistory;
            document.getElementById('edit_current_medication').value = selectElement.dataset.currentMedication;

            // ✅ Show the modal
            document.getElementById("editModalOverlay").classList.remove("hidden");

        } else if (selectedValue.startsWith("cancel-")) {
            const appointmentId = selectedValue.split("-")[1];

            const formId = `cancel-${appointmentId}`;
            document.getElementById("confirmCancelBtn").dataset.formId = formId;

            document.getElementById("cancelModal").classList.remove("hidden");
        }

        // Reset dropdown
        selectElement.value = "";
    }


    window.addEventListener('click', function(e) {
        const modalOverlay = document.getElementById("editModalOverlay");
        if (e.target === modalOverlay) {
            modalOverlay.classList.add("hidden");
        }
    });

    function openBookModal() {
        document.getElementById('bookModalOverlay').classList.remove('hidden');
    }

    function closeBookModal() {
        document.getElementById('bookModalOverlay').classList.add('hidden');
    }

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

    document.getElementById("confirmCancelBtn").addEventListener("click", function () {
        const formId = this.dataset.formId;
        const form = document.getElementById(formId);
        if (form) form.submit();
    });

    window.onload = function () {
        <?php if (isset($_SESSION['message'])): ?>
        openSuccessModal("<?= $_SESSION['message']; ?>");
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    };

</script>