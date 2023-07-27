<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
      <div class="page-header-title d-flex align-items-center">
        <i class="ik ik-edit-1 bg-blue"></i>
        <div class="d-inline">
          <h5 class="mb-0">E Rapor Siswa</h5>
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
          <?php if (!in_array($_SESSION['level'], ['guru', 'siswa'])) : ?>

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
            <select name="id_siswa" id="siswa" class="form-control"
              onchange="changeSiswa<?= $_SESSION['level'] == 'admin' ? 'Admin' : ($_SESSION['level'] == 'wali' ? 'Wali' : '') ?>(event)">
              <?php if ($querySiswa->num_rows > 0) : foreach ($querySiswa as $data) : ?>
              <option <?= $data['id_siswa'] == $siswa ? 'selected' : '' ?> value="<?= $data['id_siswa'] ?>">
                <?= $data['nama_siswa'] ?></option>
              <?php endforeach;
                else : ?>
              <option value="-1">-- Tidak ada data --</option>
              <?php endif; ?>
            </select>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="card-body pt-1">
        <!-- <h5 class="font-weight-bold mb-3">E Rapor</h5> -->

        <?php
        if (in_array($_SESSION['level'], ['siswa'])) {
          $querySiswaFromUsername = select($c, 'users a', ['join' => 'INNER JOIN siswa b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
          $dataSiswaFromUsername = mysqli_fetch_assoc($querySiswaFromUsername);
          $siswa = $dataSiswaFromUsername['id_siswa'];
        }

        $joinSiswa = "LEFT JOIN rombel b ON a.id_rombel=b.id_rombel";
        $querySiswa = select($c, 'siswa a', ['where' => "a.id_siswa=$siswa", 'join' => $joinSiswa]);
        $dataSiswa = mysqli_fetch_assoc($querySiswa);
        $queryPengampu = select($c, 'pengampu', ['where' => "id_rombel=" . $dataSiswa['id_rombel']]);
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

        // $arraySiswa = array();
        // foreach ($querySiswa as $keySiswa => $dataSiswa) {
        //   $totalNilaiSiswa = 0;
        $nilaiPerMapel = array();
        foreach ($arrayJenisNilai as $keyD => $jenisNilai) {
          $joinPenilaian = "INNER JOIN mapel b ON a.id_mapel=b.id_mapel";
          $queryPenilaian = select($c, 'penilaian a', ['where' => "a.id_siswa=" . $dataSiswa['id_siswa'] . " AND a.id_mapel=$keyD", 'join' => $joinPenilaian]);

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
          if ($queryPenilaian->num_rows > 0) {
            foreach ($queryPenilaian as $keyF => $penilaian) {
              $newBobotNilai = $jenisNilaiDipilih[$penilaian['id_jenisnilai']] * 100 / $sumJenisNilai;
              $nilaiAkhirMapelSiswa[] = $newBobotNilai * $penilaian['nilai'] / 100;
              // echo "$newBobotNilai _";
            }
            $nilaiPerMapel[$keyD][0] = $penilaian['nama_mapel'];
            $nilaiPerMapel[$keyD][1] = round(array_sum($nilaiAkhirMapelSiswa), 0);
          }

          // $totalNilaiSiswa += round(array_sum($nilaiAkhirMapelSiswa), 0);
          // foreach ($jenisNilaiDipilih as $keyE => $value) {
          //   $queryPenilaianFull = select($c, 'penilaian', ['where' => "id_siswa=" . $dataSiswa['id_siswa'] . " AND id_mapel=$keyD AND id_jenisnilai=$keyE"]);
          // }


          // print_r($jenisNilaiDipilih);
          // echo $queryPenilaian->num_rows . "_" . count($jenisNilai);
          // echo "_$countJenisNilai _$sumJenisNilai ____" . array_sum($nilaiAkhirMapelSiswa) . " <br>";
        }

        // print_r($nilaiPerMapel);
        // die;
        // $arraySiswa[$keySiswa][0] = $dataSiswa['nama_siswa'];
        // $arraySiswa[$keySiswa][1] = $totalNilaiSiswa;
        // }

        // $newArraySiswa = sortArrayByNumber($arraySiswa);
        ?>

        <div class="row mb-2">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-3">
                <p>Nama Siswa</p>
              </div>
              <div class="col-lg-9">
                <p><?= $dataSiswa['nama_siswa'] ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3">
                <p>NISN</p>
              </div>
              <div class="col-lg-9">
                <p><?= $dataSiswa['nisn'] ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3">
                <p>Kelas</p>
              </div>
              <div class="col-lg-9">
                <p><?= $dataSiswa['nama_rombel'] ?></p>
              </div>
            </div>
          </div>
        </div>

        <table class="table table-bordered dt-responsive nowrap text-center">
          <thead>
            <tr>
              <th>No</th>
              <th>Mata Pelajaran</th>
              <th>Nilai</th>
              <th>Indeks Huruf</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;

            $totalNilaiSiswa = 0;
            // echo count($nilaiPerMapel);
            // die;
            if (count($nilaiPerMapel)) :
            foreach ($nilaiPerMapel as $nilaiMapelSiswa) :
              $nilai = $nilaiMapelSiswa[1];

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
              <th class="text-left"><?= $nilaiMapelSiswa[0] ?></th>
              <th><?= $nilai ?></th>
              <th><?= $huruf ?></th>
            </tr>
            <?php
              $i++;
              $totalNilaiSiswa += $nilai;
            endforeach; else : ?>
            <tr>
              <th colspan="4">-- Tidak ada data --</th>
            </tr>
            <?php endif ?>
            <tr>
              <th colspan="2">TOTAL NILAI</th>
              <th colspan="2"><?= $totalNilaiSiswa ?></th>
            </tr>
            <tr>
              <th colspan="2">RATA-RATA NILAI</th>
              <th colspan="2"><?= $totalNilaiSiswa / $countMapel ?></th>
            </tr>
          </tbody>
        </table>
      </div>

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

  window.location.href = `?p=e_rapor&s=${e.target.value}`;
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