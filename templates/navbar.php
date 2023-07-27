<header class="header-top" header-theme="light">
  <div class="container-fluid">
    <div class="d-flex justify-content-end">

      <div class="top-menu d-flex align-items-center" style="gap: 7px;">
        <h6 class="font-weight-bold mb-0"><?= $_SESSION['nama'] ?></h6>
        <div class="dropdown">
          <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="images/user.png" alt=""></a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#logoutModal"><i class="ik ik-power dropdown-icon"></i> Logout</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</header>