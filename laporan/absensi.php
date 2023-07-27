<div class="d-flex justify-content-center mb-4">
  <h5 class="font-weight-bold">Laporan Data <?= ucwords($_GET['p']) ?></h5>
</div>

<div class="pt-3">
  <?php if (isset($_POST['absensi_perbulan'])) :
    $bulan = mysqli_escape_string($c, htmlspecialchars($_POST['bulan']));
    $tahun = mysqli_escape_string($c, htmlspecialchars($_POST['tahun']));

    if ($_SESSION['level'] == 'siswa') {
      $querySiswa = select($c, 'users a', ['join' => 'INNER JOIN siswa b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
      $dataSiswa = mysqli_fetch_assoc($querySiswa);
      $id_siswa = $dataSiswa['id_siswa'];
    } else {
      $id_siswa = mysqli_escape_string($c, htmlspecialchars($_POST['id_siswa2']));
    }

    $join = "INNER JOIN rombel b ON a.id_rombel=b.id_rombel";
    $where = "a.id_siswa=$id_siswa";
    $queryData = select($c, 'siswa a', ['join' => $join, 'where' => $where]);
    $siswa = mysqli_fetch_assoc($queryData);
  ?>
    <table class="mb-4">
      <tr>
        <th style="width:100px;">Nama Siswa</th>
        <th>: <?= $siswa['nama_siswa'] ?></th>
      </tr>
      <tr>
        <th>Rombel</th>
        <th>: <?= $siswa['nama_rombel'] ?></th>
      </tr>
    </table>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Siswa</th>
          <th>Mata Pelajaran</th>
          <th>Tanggal</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;

        $day = $tahun . "-" . $bulan . "-01";
        $lastDay = date('Y-m-d', strtotime("last day of this month", strtotime($day)));

        $joinAbsensi = "INNER JOIN siswa b ON a.id_siswa=b.id_siswa INNER JOIN mapel c ON a.id_mapel=c.id_mapel";
        $whereAbsensi = "a.id_siswa=$id_siswa AND a.tanggal BETWEEN '$day' AND '$lastDay'";
        $queryAbsensi = select($c, 'absensi a', ['join' => $joinAbsensi, 'where' => $whereAbsensi]);

        $arrayAbsensi = array();

        foreach ($queryAbsensi as $dataSiswa) :
        ?>
          <tr>
            <th><?= $i ?></th>
            <th><?= $dataSiswa['nama_siswa'] ?></th>
            <th><?= $dataSiswa['nama_mapel'] ?></th>
            <th><?= date('d-m-Y', strtotime($dataSiswa['tanggal'])) ?></th>
            <th><?= ucwords($dataSiswa['status']) ?></th>
          </tr>
        <?php
          $i++;
        endforeach; ?>
      </tbody>
    </table>
  <?php
  elseif (isset($_POST['absensi_pertanggal'])) :
    $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel2']));
    $id_mapel = mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel2']));
    $tanggal = mysqli_escape_string($c, htmlspecialchars($_POST['tanggal']));

    $rombel = mysqli_fetch_assoc(select($c, 'rombel', ['where' => "id_rombel=$id_rombel"]));
    $mapel = mysqli_fetch_assoc(select($c, 'mapel', ['where' => "id_mapel=$id_mapel"]));
  ?>
    <table class="mb-4">
      <tr>
        <th style="width:100px;">Rombel</th>
        <th>: <?= $rombel['nama_rombel'] ?></th>
      </tr>
      <tr>
        <th>Mata Pelajaran</th>
        <th>: <?= $mapel['nama_mapel'] ?></th>
      </tr>
      <tr>
        <th>Bulan</th>
        <th>: <?= bulan($tanggal) . " " . date('Y', strtotime($tanggal)) ?></th>
      </tr>
    </table>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Siswa</th>
          <th>Hadir</th>
          <th>Sakit</th>
          <th>Izin</th>
          <th>Alfa</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$id_rombel"]);
        $newTanggal = substr($tanggal, 0, 7);

        foreach ($querySiswa as $dataSiswa) :
          $selectCountAbsensi = "COUNT(id_absensi) as jumlah, status";
          $whereCountAbsensi = "id_siswa=" . $dataSiswa['id_siswa'] . " AND id_mapel=$id_mapel AND LEFT(tanggal, 7)='$newTanggal'";
          $queryCountAbsensi = select($c, 'absensi', ['select' => $selectCountAbsensi, 'where' => $whereCountAbsensi, 'group' => 'status']);

          $countHadir = 0;
          $countSakit = 0;
          $countIzin = 0;
          $countAlfa = 0;

          if ($queryCountAbsensi->num_rows > 0) {
            foreach ($queryCountAbsensi as $count) {
              if ($count['status'] == 'hadir') {
                $countHadir = $count['jumlah'];
              } elseif ($count['status'] == 'sakit') {
                $countSakit = $count['jumlah'];
              } elseif ($count['status'] == 'izin') {
                $countIzin = $count['jumlah'];
              } else {
                $countAlfa = $count['jumlah'];
              }
            }
          }

        ?>
          <tr>
            <th><?= $i ?></th>
            <th><?= $dataSiswa['nama_siswa'] ?></th>
            <th><?= $countHadir . " kali" ?></th>
            <th><?= $countSakit . " kali" ?></th>
            <th><?= $countIzin . " kali" ?></th>
            <th><?= $countAlfa . " kali" ?></th>
          </tr>
        <?php
          $i++;
        endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>