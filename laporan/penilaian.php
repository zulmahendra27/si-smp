<div class="d-flex justify-content-center mb-4">
  <h5 class="font-weight-bold">Laporan Data <?= ucwords($_GET['p']) ?></h5>
</div>

<div class="pt-3">
  <?php if (isset($_POST['laporan_permapel'])) :
    $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['rombel']));
    $id_mapel = mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel']));
    $id_jenisnilai = mysqli_escape_string($c, htmlspecialchars($_POST['id_jenisnilai']));

    $rombel = mysqli_fetch_assoc(select($c, 'rombel', ['where' => "id_rombel=$id_rombel"]));
    $mapel = mysqli_fetch_assoc(select($c, 'mapel', ['where' => "id_mapel=$id_mapel"]));
    $jenisnilai = mysqli_fetch_assoc(select($c, 'jenisnilai', ['where' => "id_jenisnilai=$id_jenisnilai"]));
  ?>
  <table class="mb-4">
    <tr>
      <th style="width:100px;">Rombel</th>
      <th>: <?= $rombel['nama_rombel'] ?></th>
    </tr>
    <tr>
      <th>Mapel</th>
      <th>: <?= $mapel['nama_mapel'] ?></th>
    </tr>
    <tr>
      <th>Jenis Penilaian</th>
      <th>: <?= $jenisnilai['jenisnilai'] ?></th>
    </tr>
  </table>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th>Siswa</th>
        <th>Nilai</th>
        <th>Indeks Huruf</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $i = 1;

        $joinNilai = "INNER JOIN siswa b ON a.id_siswa=b.id_siswa";
        $whereNilai = "a.id_mapel=$id_mapel AND b.id_rombel=$id_rombel AND a.id_jenisnilai=$id_jenisnilai";
        $queryNilai = select($c, 'penilaian a', ['join' => $joinNilai, 'where' => $whereNilai]);
        $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$id_rombel"]);

        $arrayNilai = array();
        foreach ($queryNilai as $dataNilai) {
          $arrayNilai[$dataNilai['id_siswa']] = $dataNilai['nilai'];
        }

        if ($querySiswa->num_rows > 0) :
          foreach ($querySiswa as $dataSiswa) :
            $nilai = array_key_exists($dataSiswa['id_siswa'], $arrayNilai) ? $arrayNilai[$dataSiswa['id_siswa']] : 0;

            if ($nilai > 80) {
              $huruf = 'A';
            } elseif ($nilai > 70) {
              $huruf = 'B';
            } elseif ($nilai > 60) {
              $huruf = 'C';
            } elseif ($nilai >= 0) {
              $huruf = 'D';
            } else {
              $huruf = '-';
            }
        ?>
      <tr>
        <th class="text-center"><?= $i ?></th>
        <th><?= $dataSiswa['nama_siswa'] ?></th>
        <th><?= $nilai ?></th>
        <th><?= $huruf ?></th>
      </tr>
      <?php
            $i++;
          endforeach;
        else : ?>
      <tr class="text-center">
        <th colspan="3">-- Tidak ada data --</th>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
  <?php
  elseif (isset($_POST['laporan_persiswa'])) :
    if ($_SESSION['level'] == 'siswa') {
      $querySiswa = select($c, 'users a', ['join' => 'INNER JOIN siswa b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
      $dataSiswa = mysqli_fetch_assoc($querySiswa);

      $id_siswa = $dataSiswa['id_siswa'];
    } else {
      $id_siswa = mysqli_escape_string($c, htmlspecialchars($_POST['id_siswa']));
    }

    if (in_array($_SESSION['level'], ['wali', 'siswa'])) {
      $id_mapel = mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel3']));
    } else {
      $id_mapel = mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel']));
    }

    $siswa = mysqli_fetch_assoc(select($c, 'siswa a', ['where' => "id_siswa=$id_siswa", 'join' => "INNER JOIN rombel b ON a.id_rombel=b.id_rombel"]));
  ?>
  <table class="mb-4">
    <tr>
      <th style="width:100px;">Nama Siswa</th>
      <th>: <?= $siswa['nama_siswa'] ?></th>
    </tr>
    <tr>
      <th>Kelas</th>
      <th>: <?= $siswa['nama_rombel'] ?></th>
    </tr>
  </table>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>Mata Pelajaran</th>
        <th>Guru Pengampu</th>
        <th>Penilaian</th>
        <th>Nilai</th>
        <th>Indeks Huruf</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $i = 1;

        if ($_SESSION['level'] == 'siswa') {
          $querySiswa = select($c, 'users a', ['join' => 'INNER JOIN siswa b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
          $dataSiswa = mysqli_fetch_assoc($querySiswa);

          $where = "a.id_siswa=" . $dataSiswa['id_siswa'] . " AND a.id_mapel=$id_mapel";
        } else {
          $where = "a.id_siswa=$id_siswa AND a.id_mapel=$id_mapel";
        }

        $join = "INNER JOIN siswa b ON a.id_siswa=b.id_siswa INNER JOIN mapel c ON a.id_mapel=c.id_mapel INNER JOIN rombel d ON b.id_rombel=d.id_rombel INNER JOIN jenisnilai e ON a.id_jenisnilai=e.id_jenisnilai";
        $opt = array(
          'join' => $join,
          'where' => $where
        );
        $query = select($c, 'penilaian a', $opt);
        $totalNilai = 0;
        while ($data = mysqli_fetch_assoc($query)) :
          $join = "INNER JOIN mapel b ON a.id_mapel=b.id_mapel INNER JOIN guru c ON a.id_guru=c.id_guru";
          $where = "a.id_mapel=" . $data['id_mapel'] . " AND a.id_rombel=" . $data['id_rombel'];
          $dataGuru = mysqli_fetch_assoc(select($c, 'pengampu a', ['where' => $where, 'join' => $join]));

          if ($data['nilai'] > 80) {
            $huruf = 'A';
          } elseif ($data['nilai'] > 70) {
            $huruf = 'B';
          } elseif ($data['nilai'] > 60) {
            $huruf = 'C';
          } elseif ($data['nilai'] >= 0) {
            $huruf = 'D';
          } else {
            $huruf = '-';
          }
        ?>
      <tr>
        <td><?= $i ?></td>
        <td><?= $data['nama_mapel'] ?></td>
        <td><?= $dataGuru['nama_guru'] ?></td>
        <td><?= $data['jenisnilai'] ?></td>
        <td><?= $data['nilai'] ?></td>
        <td><?= $huruf ?></td>
      </tr>
      <?php $i++;
          $totalNilai += $data['nilai'];
        endwhile; ?>
      <tr class="h4">
        <th colspan="4">Total Nilai</th>
        <th colspan="2"><?= $totalNilai ?></th>
      </tr>
    </tbody>
  </table>
  <?php endif; ?>
</div>