<?php include 'patientsComponents/patientSessionInformation.php'?>

<?php  include 'patientsComponents/patientBoilerTemplate.php'?>

<body class="bg-gray-50 font-sans">
<div class="flex h-screen">

    <?php include 'components/patientSideBar.php'; ?>

    <main class="flex-1 p-6 overflow-auto">
        <?php include 'patientsComponents/patientHeader.php'?>

        <?php include 'patientsComponents/patientSearchForm.php'?>

        <?php include 'patientsComponents/patientStats.php'?>

        <?php include 'patientsComponents/patientTable.php'?>
    </main>

    <?php include 'components/modelPopupsForPatients.php'; ?>

    <?php include 'patientsComponents/patientErrors.php'?>

    <?php include 'js/patientJs.php'; ?>
</body>
</html>
