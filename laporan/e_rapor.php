<div class="d-flex justify-content-center mb-4">
  <h5 class="font-weight-bold">Laporan Data <?= ucwords(str_replace("_", " ", $_GET['p'])) ?></h5>
</div>

<div class="pt-3">
  <?php if (isset($_POST['laporan_erapor'])) :
    if ($_SESSION['level'] == 'siswa') {
      $querySiswa = select($c, 'users a', ['join' => 'INNER JOIN siswa b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
      $dataSiswa = mysqli_fetch_assoc($querySiswa);
      $siswa = $dataSiswa['id_siswa'];
    } else {
      $siswa = mysqli_escape_string($c, htmlspecialchars($_POST['id_siswa_erapor']));
    }

    $joinSiswa = "LEFT JOIN rombel b ON a.id_rombel=b.id_rombel";
    $querySiswa = select($c, 'siswa a', ['where' => "a.id_siswa=$siswa", 'join' => $joinSiswa]);
    $dataSiswa = mysqli_fetch_assoc($querySiswa);

    $joinWalas = "LEFT JOIN guru b ON a.walas=b.id_guru";
    $queryWalas = select($c, 'rombel a', ['join' => $joinWalas, 'where' => "a.id_rombel=" . $dataSiswa['id_rombel']]);

    if ($queryWalas->num_rows > 0) {
      $dataWalas = mysqli_fetch_assoc($queryWalas);
    }

    $queryWali = select($c, 'wali', ['where' => "id_wali=" . $dataSiswa['id_wali']]);

    if ($queryWali->num_rows > 0) {
      $dataWali = mysqli_fetch_assoc($queryWali);
    }

    $joinKepsek = "LEFT JOIN guru b ON a.id_user=b.id_user";
    $queryKepsek = select($c, 'users a', ['where' => "a.level='kepsek'", 'join' => $joinKepsek]);

    if ($queryKepsek->num_rows > 0) {
      $dataKepsek = mysqli_fetch_assoc($queryKepsek);
    }

    // $join = "INNER JOIN rombel b ON a.id_rombel=b.id_rombel";
    // $where = "a.id_siswa=$id_siswa";
    // $queryData = select($c, 'siswa a', ['join' => $join, 'where' => $where]);
    // $siswa = mysqli_fetch_assoc($queryData);
  ?>
    <table class="mb-4">
      <tr>
        <th style="width:100px;">Nama Siswa</th>
        <th>: <?= $dataSiswa['nama_siswa'] ?></th>
      </tr>
      <tr>
        <th style="width:100px;">NISN</th>
        <th>: <?= $dataSiswa['nisn'] ?></th>
      </tr>
      <tr>
        <th>Kelas</th>
        <th>: <?= $dataSiswa['nama_rombel'] ?></th>
      </tr>
    </table>
    <table class="table table-striped table-bordered text-center">
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
        // if (in_array($_SESSION['level'], ['siswa'])) {
        //   $querySiswaFromUsername = select($c, 'users a', ['join' => 'INNER JOIN siswa b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
        //   $dataSiswaFromUsername = mysqli_fetch_assoc($querySiswaFromUsername);
        //   $siswa = $dataSiswaFromUsername['id_siswa'];
        // } else {
        //   $siswa = 
        // }

        // $joinSiswa = "LEFT JOIN rombel b ON a.id_rombel=b.id_rombel";
        // $querySiswa = select($c, 'siswa a', ['where' => "a.id_siswa=$siswa", 'join' => $joinSiswa]);
        // $dataSiswa = mysqli_fetch_assoc($querySiswa);
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
        // $arraySiswa[$keySiswa][0] = $dataSiswa['nama_siswa'];
        // $arraySiswa[$keySiswa][1] = $totalNilaiSiswa;
        // }

        // $newArraySiswa = sortArrayByNumber($arraySiswa);

        $i = 1;

        $totalNilaiSiswa = 0;
        // echo count($nilaiPerMapel);
        // die;
        if (count($nilaiPerMapel) > 0) :
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
          endforeach;
        else : ?>
          <tr>
            <th colspan="4">-- Tidak ada data --</th>
          </tr>
        <?php endif; ?>
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

    <table class="mt-4 text-center" style="width: 100%; font-size: 16px;">
      <thead>
        <tr>
          <th style="width: 30%;"></th>
          <th style="width: 40%;"></th>
          <th style="width: 30%;">Padang, <?= date('d-m-Y') ?></th>
        </tr>
        <tr>
          <th style="padding-bottom: 4rem;">Orang Tua/Wali</th>
          <th></th>
          <th style="padding-bottom: 4rem;">Wali Kelas</th>
        </tr>
        <tr>
          <th><?= $dataWali['nama_wali'] ?></th>
          <th></th>
          <th><?= $dataWalas['nama_guru'] ?></th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th>NIP. <?= $dataWalas['nip'] != '' ? $dataWalas['nip'] : '-' ?></th>
        </tr>
      </thead>
    </table>

    <table class="mt-4 text-center" style="width: 100%; font-size: 16px;">
      <thead>
        <tr>
          <th>Mengetahui,</th>
        </tr>
        <tr>
          <th style="padding-bottom: 4rem;">Kepala Sekolah</th>
        </tr>
        <tr>
          <th><?= $dataKepsek['nama_guru'] ?></th>
        </tr>
        <tr>
          <th>NIP. <?= $dataKepsek['nip'] != '' ? $dataKepsek['nip'] : '-' ?></th>
        </tr>
      </thead>
    </table>
  <?php endif; ?>
</div>