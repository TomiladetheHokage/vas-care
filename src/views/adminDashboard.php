<?php  include 'components/adminSessionInformation.php'?>

<?php include 'components/adminBoilerCode.php'?>

<body class="bg-gray-100 p-6 text-sm font-sans">
<div class="flex min-h-screen">
    <?php include 'components/adminSideBar.php'; ?>

  <div class="flex-1">
    <div class="max-w-7xl mx-auto p-6">
     <?php include 'components/adminHeader.html' ?>

      <?php include 'components/adminSearchForm.php' ?>

      <?php include 'components/adminStat.php' ?>

      <?php include 'components/adminTable.php'?>

      <?php include 'components/adminPagination.php'?>
    </div>
  </div>

</div>
    <?php include 'components/adminModelPopUps.php' ?>

    <?php include 'js/adminJs.php'; ?>
</body>
</html>
