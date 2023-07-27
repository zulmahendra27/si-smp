<?php
if ($_SESSION['level'] == 'guru') {
  $queryGuru = select($c, 'users a', ['join' => 'INNER JOIN guru b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
  $dataGuru = mysqli_fetch_assoc($queryGuru);
}
?>

<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
      <div class="page-header-title d-flex align-items-center">
        <i class="ik ik-edit-1 bg-blue"></i>
        <div class="d-inline">
          <h5 class="mb-0">Data Penilaian Siswa</h5>
        </div>
      </div>
      <?php if ($_SESSION['level'] == 'guru') : ?>
        <a href="?p=penilaian_add" class="btn btn-success"><i class="ik ik-plus-circle"></i>Tambah Data</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <?php /* if ($_SESSION['level'] != 'siswa') : */ ?>
      <div class="card-body pb-0">

        <div class="row">
          <?php if (!in_array($_SESSION['level'], ['wali', 'siswa'])) : ?>
            <div class="col-lg-4 form-group">
              <?php
              if (in_array($_SESSION['level'], ['guru'])) {
                $joinRombel = "INNER JOIN pengampu b ON a.id_rombel=b.id_rombel";
                $selectRombel = "DISTINCT(b.id_rombel), a.*";
                $whereRombel = "b.id_guru=" . $dataGuru['id_guru'];
                $queryRombel = select($c, 'rombel a', ['join' => $joinRombel, 'select' => $selectRombel, 'where' => $whereRombel]);
              } else {
                $queryRombel = select($c, 'rombel');
              }
              if (!isset($_GET['r'])) {
                if ($queryRombel->num_rows > 0) {
                  $rombel = mysqli_fetch_assoc($queryRombel)['id_rombel'];
                } else {
                  $rombel = -1;
                }
              } else {
                $rombel = mysqli_escape_string($c, htmlspecialchars($_GET['r']));
              }
              ?>
              <label for="rombel">Pilih Rombel</label>
              <select name="rombel" id="rombel" class="form-control" onchange="changeRombel(event)">
                <?php if ($queryRombel->num_rows > 0) : foreach ($queryRombel as $data) : ?>
                    <option <?= $data['id_rombel'] == $rombel ? 'selected' : '' ?> value="<?= $data['id_rombel'] ?>">
                      <?= $data['nama_rombel'] ?></option>
                  <?php endforeach;
                else : ?>
                  <option value="-1">-- Tidak ada data --</option>
                <?php endif ?>
              </select>
            </div>

            <div class="col-lg-4 form-group">
              <?php
              if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'kepsek') {
                $queryMapel = select($c, 'mapel a');
              } else {
                $join = "INNER JOIN pengampu b ON a.id_mapel=b.id_mapel";
                $where = "b.id_rombel=$rombel AND b.id_guru=" . $dataGuru['id_guru'];
                $queryMapel = select($c, 'mapel a', ['where' => $where, 'join' => $join]);
              }

              if (!isset($_GET['m'])) {
                if ($queryMapel->num_rows > 0) {
                  $mapel = mysqli_fetch_assoc($queryMapel)['id_mapel'];
                } else {
                  $mapel = -1;
                }
              } else {
                $mapel = mysqli_escape_string($c, htmlspecialchars($_GET['m']));
              }
              ?>
              <label for="mapel">Pilih Mapel</label>
              <select name="id_mapel" id="mapel" class="form-control" onchange="changeMapel<?= in_array($_SESSION['level'], ['admin', 'kepsek']) ? 'Admin' : '' ?>(event)">
                <?php if ($queryMapel->num_rows > 0) : foreach ($queryMapel as $data) : ?>
                    <option <?= $data['id_mapel'] == $mapel ? 'selected' : '' ?> value="<?= $data['id_mapel'] ?>">
                      <?= $data['nama_mapel'] ?></option>
                  <?php endforeach;
                else : ?>
                  <option value="-1">-- Tidak ada data --</option>
                <?php endif; ?>
              </select>
            </div>

            <div class="col-lg-4 form-group">
              <?php
              if ($_SESSION['level'] == 'guru') {
                $id_guru = $dataGuru['id_guru'];
              } else {
                $wherePengampu = "id_mapel=$mapel AND id_rombel=$rombel";
                $queryPengampu = select($c, 'pengampu', ['where' => $wherePengampu]);

                $id_guru = -1;
                if ($queryPengampu->num_rows > 0) {
                  $id_guru = mysqli_fetch_assoc($queryPengampu)['id_guru'];
                }
              }

              $queryJenisNilai = select($c, 'jenisnilai', ['where' => "id_guru=" . $id_guru]);
              if (!isset($_GET['n'])) {
                if ($queryJenisNilai->num_rows > 0) {
                  $jenisnilai = mysqli_fetch_assoc($queryJenisNilai)['id_jenisnilai'];
                } else {
                  $jenisnilai = -1;
                }
              } else {
                $jenisnilai = mysqli_escape_string($c, htmlspecialchars($_GET['n']));
              }
              ?>
              <label for="jenisnilai">Pilih Jenis Penilaian</label>
              <select name="jenisnilai" id="jenisnilai" class="form-control" onchange="changeJenisNilai(event)">
                <?php if ($queryJenisNilai->num_rows > 0) : foreach ($queryJenisNilai as $data) : ?>
                    <option <?= $data['id_jenisnilai'] == $jenisnilai ? 'selected' : '' ?> value="<?= $data['id_jenisnilai'] ?>">
                      <?= $data['jenisnilai'] ?></option>
                  <?php endforeach;
                else : ?>
                  <option value="-1">-- Tidak ada data --</option>
                <?php endif ?>
              </select>
            </div>

          <?php endif;
          if (!in_array($_SESSION['level'], ['guru', 'siswa'])) : ?>

            <div class="col-lg-4 form-group">
              <?php
              if ($_SESSION['level'] == 'wali') {
                $queryWali = select($c, 'users a', ['join' => 'INNER JOIN wali b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
                $dataWali = mysqli_fetch_assoc($queryWali);

                $querySiswa = select($c, 'siswa', ['where' => "id_wali=" . $dataWali['id_wali']]);
              } else {
                $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$rombel"]);
              }

              if (!isset($_GET['s'])) {
                if ($querySiswa->num_rows > 0) {
                  $siswa = mysqli_fetch_assoc($querySiswa)['id_siswa'];
                } else {
                  $siswa = -1;
                }
              } else {
                $siswa = mysqli_escape_string($c, htmlspecialchars($_GET['s']));
              }
              ?>
              <label for="siswa">Pilih Siswa</label>
              <select name="id_siswa" id="siswa" class="form-control" onchange="changeSiswa<?= in_array($_SESSION['level'], ['admin', 'kepsek']) ? 'Admin' : ($_SESSION['level'] == 'wali' ? 'Wali' : '') ?>(event)">
                <?php if ($querySiswa->num_rows > 0) : foreach ($querySiswa as $data) : ?>
                    <option <?= $data['id_siswa'] == $siswa ? 'selected' : '' ?> value="<?= $data['id_siswa'] ?>">
                      <?= $data['nama_siswa'] ?></option>
                  <?php endforeach;
                else : ?>
                  <option value="-1">-- Tidak ada data --</option>
                <?php endif; ?>
              </select>
            </div>
          <?php endif;
          if (in_array($_SESSION['level'], ['wali', 'siswa'])) : ?>
            <div class="col-lg-4 form-group">
              <?php
              if ($_SESSION['level'] == 'siswa') {
                $querySiswa = select($c, 'users a', ['join' => 'INNER JOIN siswa b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
                $dataSiswa = mysqli_fetch_assoc($querySiswa);

                $whereSiswa = "id_siswa=" . $dataSiswa['id_siswa'];
              } else {
                $whereSiswa = "id_siswa=$siswa";
              }
              $querySiswa = select($c, 'siswa', ['where' => $whereSiswa]);
              $id_rombel = $querySiswa->num_rows > 0 ? mysqli_fetch_assoc($querySiswa)['id_rombel'] : -1;

              $joinMapel = "INNER JOIN pengampu b ON a.id_mapel=b.id_mapel";
              $whereMapel = "b.id_rombel=$id_rombel";

              $queryMapel = select($c, 'mapel a', ['where' => $whereMapel, 'join' => $joinMapel]);

              if (!isset($_GET['m'])) {
                if ($queryMapel->num_rows > 0) {
                  $mapel = mysqli_fetch_assoc($queryMapel)['id_mapel'];
                } else {
                  $mapel = -1;
                }
              } else {
                $mapel = mysqli_escape_string($c, htmlspecialchars($_GET['m']));
              }
              ?>
              <label for="mapel">Pilih Mapel</label>
              <select name="id_mapel" id="mapelWali" class="form-control" onchange="changeMapel<?= ucwords($_SESSION['level']) ?>(event)">
                <?php if ($queryMapel->num_rows > 0) : foreach ($queryMapel as $data) : ?>
                    <option <?= $data['id_mapel'] == $mapel ? 'selected' : '' ?> value="<?= $data['id_mapel'] ?>">
                      <?= $data['nama_mapel'] ?></option>
                  <?php endforeach;
                else : ?>
                  <option value="-1">-- Tidak ada data --</option>
                <?php endif; ?>
              </select>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <?php if (!in_array($_SESSION['level'], ['wali', 'siswa'])) : ?>
        <div class="card-body">
          <h5 class="font-weight-bold mb-3">Filter by Mata Pelajaran</h5>
          <table id="tabelData" class="table table-striped table-bordered dt-responsive nowrap">
            <thead>
              <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Nilai</th>
                <th>Indeks Huruf</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              $joinNilai = "INNER JOIN siswa b ON a.id_siswa=b.id_siswa";
              $whereNilai = "a.id_mapel=$mapel AND b.id_rombel=$rombel AND a.id_jenisnilai=$jenisnilai";
              $queryNilai = select($c, 'penilaian a', ['join' => $joinNilai, 'where' => $whereNilai]);
              $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$rombel"]);

              $arrayNilai = array();
              foreach ($queryNilai as $dataNilai) {
                $arrayNilai[$dataNilai['id_siswa']] = $dataNilai['nilai'];
              }

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
                  <th><?= $i ?></th>
                  <th><?= $dataSiswa['nama_siswa'] ?></th>
                  <th><?= $nilai ?></th>
                  <th><?= $huruf ?></th>
                </tr>
              <?php
                $i++;
              endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif;
      // endif;
      if ($_SESSION['level'] != 'guru') : ?>
        <div class="card-body">
          <h5 class="font-weight-bold mb-3">Filter by Siswa</h5>
          <table class="table table-striped table-bordered dt-responsive nowrap">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Siswa</th>
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

                $where = "a.id_siswa=" . $dataSiswa['id_siswa'] . " AND a.id_mapel=$mapel";
              } else {
                $where = "a.id_siswa=$siswa AND a.id_mapel=$mapel";
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
                  <td><?= $data['nama_siswa'] ?></td>
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
                <th colspan="5">Total Nilai</th>
                <th colspan="2"><?= $totalNilai ?></th>
              </tr>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  function changeRombel(e) {
    window.location.href = `?p=penilaian&r=${e.target.value}`;
  }

  function changeSiswa(e) {
    let rombel = document.getElementById('rombel');

    window.location.href = `?p=penilaian&r=${rombel.value}&s=${e.target.value}`;
  }

  function changeSiswaWali(e) {
    let rombel = document.getElementById('rombel');

    window.location.href = `?p=penilaian&s=${e.target.value}`;
  }

  function changeMapelWali(e) {
    let siswa = document.getElementById('siswa');

    window.location.href = `?p=penilaian&s=${siswa.value}&m=${e.target.value}`;
  }

  function changeMapelSiswa(e) {
    window.location.href = `?p=penilaian&m=${e.target.value}`;
  }

  function changeMapel(e) {
    let rombel = document.getElementById('rombel');

    window.location.href = `?p=penilaian&r=${rombel.value}&m=${e.target.value}`;
  }

  function changeSiswaAdmin(e) {
    let rombel = document.getElementById('rombel');
    let mapel = document.getElementById('mapel');

    window.location.href = `?p=penilaian&r=${rombel.value}&m=${mapel.value}&s=${e.target.value}`;
  }

  function changeMapelAdmin(e) {
    let rombel = document.getElementById('rombel');
    let siswa = document.getElementById('siswa');

    window.location.href = `?p=penilaian&r=${rombel.value}&m=${e.target.value}&s=${siswa.value}`;
  }

  function changeJenisNilai(e) {
    let rombel = document.getElementById('rombel');
    let mapel = document.getElementById('mapel');

    window.location.href = `?p=penilaian&r=${rombel.value}&m=${mapel.value}&n=${e.target.value}`;
  }
</script>