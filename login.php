<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="images/logo smp 6 muhammadiyah.jpg" type="image/x-icon" />

  <link rel="stylesheet" href="assets/plugins/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/plugins/jquery-toast-plugin/dist/jquery.toast.min.css">

  <title>Login Page</title>
  <style>
    .btn-color {
      background-color: #0e1c36;
      color: #fff;

    }

    .profile-image-pic {
      height: 100px;
      width: 100px;
      object-fit: cover;
    }

    .cardbody-color {
      background-color: #ebf2fa;
    }

    a {
      text-decoration: none;
    }

    body {
      background-image: url('./images/');
      background-size: auto 100%;
      background-position: center center;
      background-repeat: no-repeat;
      background-color: rgba(255, 255, 255, 0.7);
      background-blend-mode: overlay;
    }
  </style>
</head>

<body>
  <?php include_once "./control/cek_login.php"; ?>

  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center text-dark mt-5">Login Form</h2>
        <div class="card my-5">

          <form method="post" action="./control/cek_login.php" class="card-body cardbody-color p-lg-5">

            <div class="text-center">
              <img src="./images/logo smp 6 muhammadiyah.jpg" class="img-fluid profile-image-pic img-thumbnail rounded-circle mb-3" alt="profile">
            </div>

            <div class="mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="text-center"><button type="submit" class="btn btn-color px-5 mb-5 w-100">Login</button></div>

          </form>
        </div>

      </div>
    </div>
  </div>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="assets/plugins/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
<script src="assets/dist/js/alerts.js"></script>

<?php if (isset($_SESSION['alert'])) {
  echo $_SESSION['alert'];
  unset($_SESSION['alert']);
} ?>

</html>