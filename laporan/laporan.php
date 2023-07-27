<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="stylesheet" href="../assets/plugins/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../assets/plugins/ionicons/dist/css/ionicons.min.css">
  <link rel="stylesheet" href="../assets/plugins/icon-kit/dist/css/iconkit.min.css">
  <link rel="stylesheet" href="../assets/dist/css/theme.min.css">
</head>

<body>

  <?php
  include_once "../control/connection.php";
  include_once "../control/helper.php";
  session_start();
  if (isset($_GET['p'])) {
    include_once $_GET['p'] . ".php";
  }
  ?>

  <script>
  window.print();
  </script>
</body>

</html>