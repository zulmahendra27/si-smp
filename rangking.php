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

          <?php endif; ?>

        </div>
      </div>
      <?php if (!in_array($_SESSION['level'], ['wali', 'siswa'])) : ?>
        <div class="card-body">
          <h5 class="font-weight-bold mb-3">Data Rangking Sementara Siswa</h5>
          <table id="tabelData" class="table table-striped table-bordered dt-responsive nowrap">
            <thead>
              <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Total Nilai Nilai</th>
                <th>Rata-Rata Nilai</th>
                <th>Rangking</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$rombel"]);
              $queryPengampu = select($c, 'pengampu', ['where' => "id_rombel=$rombel"]);

              $countMapel = $queryPengampu->num_rows;
              if ($countMapel == 0) {
                $countMapel = 1;
              }

              // $dataPengampuByRombel = array();
              // $dataJenisNilai = array();
              $arrayJenisNilai = array();

              if ($queryPengampu->num_rows > 0) {
                foreach ($queryPengampu as $keyA => $pengampu) {
                  // $dataPengampuByRombel[] = $pengampu['id_guru'];
                  $queryJenisNilaiInRombel = select($c, 'jenisnilai', ['where' => "id_guru=" . $pengampu['id_guru']]);

                  if ($queryJenisNilaiInRombel->num_rows > 0) {
                    $oldArray = array();
                    foreach ($queryJenisNilaiInRombel as $keyB => $jenisNilaiInRombel) {
                      $newArray = array();
                      $newArray[$pengampu['id_mapel']] = $jenisNilaiInRombel['bobot_nilai'];
                      $arrayJenisNilai[$pengampu['id_mapel']][$jenisNilaiInRombel['id_jenisnilai']] = $jenisNilaiInRombel['bobot_nilai'];
                    }
                  }
                }

                // print_r($arrayJenisNilai);

                // $whereJenisNilaiInRombel = "(" . implode(",", $dataPengampuByRombel) . ")";
              }

              // $arrayNilai = array();
              // foreach ($queryNilai as $dataNilai) {
              //   $arrayNilai[$dataNilai['id_siswa']] = $dataNilai['nilai'];
              // }

              $arraySiswa = array();
              foreach ($querySiswa as $keySiswa => $dataSiswa) {
                $totalNilaiSiswa = 0;
                foreach ($arrayJenisNilai as $keyD => $jenisNilai) {
                  $queryPenilaian = select($c, 'penilaian', ['where' => "id_siswa=" . $dataSiswa['id_siswa'] . " AND id_mapel=$keyD"]);

                  $countJenisNilai = 0;
                  $sumJenisNilai = 0;
                  $jenisNilaiDipilih = array();

                  foreach ($jenisNilai as $keyE => $value) {
                    $queryPenilaianFull = select($c, 'penilaian', ['where' => "id_siswa=" . $dataSiswa['id_siswa'] . " AND id_mapel=$keyD AND id_jenisnilai=$keyE"]);
                    if ($queryPenilaianFull->num_rows > 0) {
                      $countJenisNilai += 1;
                      $sumJenisNilai += $value;
                      $jenisNilaiDipilih[$keyE] = $value;
                      // if ($queryPenilaian->num_rows > 0) {
                      //   foreach ($queryPenilaian as $penilaian) {
                      //     if ($penilaian['id_jenisnilai'] == $keyE) {
                      //     }
                      //   }
                      // }
                    }
                  }

                  $nilaiAkhirMapelSiswa = array();
                  foreach ($queryPenilaian as $keyF => $penilaian) {
                    $newBobotNilai = $jenisNilaiDipilih[$penilaian['id_jenisnilai']] * 100 / $sumJenisNilai;
                    $nilaiAkhirMapelSiswa[] = $newBobotNilai * $penilaian['nilai'] / 100;
                    // print_r($jenisNilaiDipilih);
                    // echo "<br>";
                    // echo "$newBobotNilai _";
                  }


                  $totalNilaiSiswa += round(array_sum($nilaiAkhirMapelSiswa), 0);
                  // foreach ($jenisNilaiDipilih as $keyE => $value) {
                  //   $queryPenilaianFull = select($c, 'penilaian', ['where' => "id_siswa=" . $dataSiswa['id_siswa'] . " AND id_mapel=$keyD AND id_jenisnilai=$keyE"]);
                  // }


                  // print_r($jenisNilaiDipilih);
                  // echo $queryPenilaian->num_rows . "_" . count($jenisNilai);
                  // echo "_$countJenisNilai _$sumJenisNilai ____" . array_sum($nilaiAkhirMapelSiswa) . " <br>";
                }
                $arraySiswa[$keySiswa][0] = $dataSiswa['nama_siswa'];
                $arraySiswa[$keySiswa][1] = $totalNilaiSiswa;
              }

              $newArraySiswa = sortArrayByNumber($arraySiswa);

              $i = 1;
              foreach ($newArraySiswa as $siswa) :
                $rataNilai = $siswa[1] / $countMapel;
              ?>
                <tr>
                  <th><?= $i ?></th>
                  <th><?= $siswa[0] ?></th>
                  <th><?= $siswa[1] ?></th>
                  <th><?= round($rataNilai, 2) ?></th>
                  <th><?= $i ?></th>
                </tr>
              <?php $i++;
              endforeach; ?>
            </tbody>
          </table>
        </div>

      <?php endif; ?>

    </div>
  </div>
</div>

<script>
  function changeRombel(e) {
    window.location.href = `?p=rangking&r=${e.target.value}`;
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