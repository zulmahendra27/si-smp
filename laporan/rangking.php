<div class="d-flex justify-content-center mb-4">
  <h5 class="font-weight-bold">Laporan Data <?= ucwords(str_replace("_", " ", $_GET['p'])) ?></h5>
</div>

<div class="pt-3">
  <?php
  if (isset($_POST['laporan_rangking'])) :
    $rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel_rangking']));

    $joinRombel = "LEFT JOIN guru b ON a.walas=b.id_guru";
    $queryRombel = select($c, 'rombel a', ['join' => $joinRombel, 'where' => "a.id_rombel=$rombel"]);
    $dataRombel = mysqli_fetch_assoc($queryRombel);

    $joinKepsek = "LEFT JOIN guru b ON a.id_user=b.id_user";
    $queryKepsek = select($c, 'users a', ['where' => "a.level='kepsek'", 'join' => $joinKepsek]);


    if ($queryKepsek->num_rows > 0) {
      $dataKepsek = mysqli_fetch_assoc($queryKepsek);
    }
  ?>
    <table class="mb-4">
      <tr>
        <th>Kelas</th>
        <th>: <?= $dataRombel['nama_rombel'] ?></th>
      </tr>
      <tr>
        <th style="width:100px;">Wali Kelas</th>
        <th>: <?= $dataRombel['nama_guru'] ?></th>
      </tr>
    </table>
    <table class="table table-striped table-bordered text-center">
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

        if (count($newArraySiswa) > 0) :
          $i = 1;

          foreach ($newArraySiswa as $siswa) :
            $rataNilai = $siswa[1] / $countMapel;
        ?>
            <tr>
              <th><?= $i ?></th>
              <th class="text-left"><?= $siswa[0] ?></th>
              <th><?= $siswa[1] ?></th>
              <th><?= round($rataNilai, 2) ?></th>
              <th><?= $i ?></th>
            </tr>
          <?php
            $i++;
          endforeach;
        else : ?>
          <tr>
            <th colspan="5">-- Tidak ada data --</th>
          </tr>
        <?php endif; ?>

      </tbody>
    </table>

    <table class="mt-4 text-center" style="width: 100%; font-size: 16px;">
      <thead>
        <tr>
          <th style="width: 30%;">Mengetahui</th>
          <th style="width: 40%;"></th>
          <th style="width: 30%;">Padang, <?= date('d-m-Y') ?></th>
        </tr>
        <tr>
          <th style="padding-bottom: 4rem;">Kepala Sekolah</th>
          <th></th>
          <th style="padding-bottom: 4rem;">Wali Kelas</th>
        </tr>
        <tr>
          <th><?= $dataKepsek['nama_guru'] ?></th>
          <th></th>
          <th><?= $dataRombel['nama_guru'] ?></th>
        </tr>
        <tr>
          <th>NIP. <?= $dataKepsek['nip'] != '' ? $dataKepsek['nip'] : '-' ?></th>
          <th></th>
          <th>NIP. <?= $dataRombel['nip'] != '' ? $dataRombel['nip'] : '-' ?></th>
        </tr>
      </thead>
    </table>

  <?php endif; ?>
</div>