<div class="app-sidebar colored">
  <div class="sidebar-header">
    <a class="header-brand" href="main.php?p=dashboard">
      <!-- <div class="logo-img">
        <img src="assets/src/img/brand-white.svg" class="header-brand-img" alt="lavalite">
      </div> -->
      <span class="text">SI Akademik</span>
      <!-- <span class="text">SMP 6<br>Muhammadiyah Padang</span> -->
    </a>
    <button type="button" class="nav-toggle"><i data-toggle="expanded"
        class="ik ik-toggle-right toggle-icon"></i></button>
    <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
  </div>

  <div class="sidebar-content">
    <div class="nav-container">
      <nav id="main-menu-navigation" class="navigation-main">
        <div class="nav-lavel">Navigation</div>
        <div class="nav-item">
          <a href="?p=dashboard"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
        </div>

        <?php if (in_array($_SESSION['level'], ['admin', 'kepsek'])) : ?>
        <div class="nav-lavel">Master Data</div>
        <div class="nav-item">
          <a href="?p=guru"><i class="ik ik-user"></i><span>Guru</span></a>
        </div>
        <div class="nav-item">
          <a href="?p=siswa"><i class="ik ik-users"></i><span>Siswa</span></a>
        </div>
        <div class="nav-item">
          <a href="?p=wali"><i class="ik ik-user-check"></i><span>Wali</span></a>
        </div>
        <div class="nav-item">
          <a href="?p=rombel"><i class="ik ik-home"></i><span>Rombel</span></a>
        </div>
        <div class="nav-item">
          <a href="?p=mapel"><i class="ik ik-book-open"></i><span>Mata Pelajaran</span></a>
        </div>
        <div class="nav-item">
          <a href="?p=pengampu"><i class="ik ik-book"></i><span>Pengampu Mapel</span></a>
        </div>
        <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
        <div class="nav-item">
          <a href="?p=kepsek"><i class="ik ik-user"></i><span>Kepala Sekolah</span></a>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <div class="nav-lavel">Akademik</div>
        <?php if ($_SESSION['level'] == 'guru') : ?>
        <div class="nav-item">
          <a href="?p=jenis_penilaian"><i class="ik ik-edit-2"></i><span>Jenis Penilaian</span></a>
        </div>
        <?php endif; ?>
        <div class="nav-item">
          <a href="?p=absensi"><i class="ik ik-check-square"></i><span>Daftar Hadir</span></a>
        </div>

        <?php if (!in_array($_SESSION['level'], ['wali'])) : ?>
        <div class="nav-item">
          <a href="?p=penilaian"><i class="ik ik-edit-1"></i><span>Penilaian</span></a>
        </div>
        <?php endif; ?>

        <?php if (in_array($_SESSION['level'], ['admin', 'guru', 'kepsek'])) : ?>
        <div class="nav-item">
          <a href="?p=rangking"><i class="ik ik-trending-up"></i><span>Rangking</span></a>
        </div>
        <?php endif; ?>

        <?php if (in_array($_SESSION['level'], ['siswa', 'wali'])) : ?>
        <div class="nav-item">
          <a href="?p=e_rapor"><i class="ik ik-file"></i><span>E Rapor</span></a>
        </div>
        <?php endif; ?>

        <div class="nav-lavel">Laporan</div>
        <div class="nav-item">
          <a href="?p=laporan"><i class="ik ik-file-text"></i><span>Laporan</span></a>
        </div>

      </nav>
    </div>
  </div>
</div>