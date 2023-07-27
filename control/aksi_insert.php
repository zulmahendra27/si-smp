<?php
include_once 'connection.php';
include_once 'helper.php';
session_start();

if (isset($_POST['guru'])) {
  $status = mysqli_escape_string($c, htmlspecialchars($_POST['status']));
  $username = mysqli_escape_string($c, htmlspecialchars($_POST['username']));

  if ($status == 'asn') {
    $nip = $username;
  } else {
    $nip = '';
  }

  $data_user = array(
    'username' => $username,
    'password' => password_hash($_POST['username'], PASSWORD_DEFAULT),
    'level' => 'guru'
  );

  $query_user = insert($c, $data_user, 'users');

  $data_guru = array(
    'id_user' => mysqli_insert_id($c),
    'nip' => $nip,
    'nama_guru' => mysqli_escape_string($c, htmlspecialchars($_POST['nama'])),
    'gender_guru' => mysqli_escape_string($c, htmlspecialchars($_POST['gender'])),
    'tanggal_lahir_guru' => mysqli_escape_string($c, htmlspecialchars($_POST['tanggal_lahir'])),
    'tempat_lahir_guru' => mysqli_escape_string($c, htmlspecialchars($_POST['tempat_lahir'])),
    'agama_guru' => mysqli_escape_string($c, htmlspecialchars($_POST['agama'])),
    'alamat_guru' => mysqli_escape_string($c, htmlspecialchars($_POST['alamat'])),
    'email' => mysqli_escape_string($c, htmlspecialchars($_POST['email'])),
    'nohp' => mysqli_escape_string($c, htmlspecialchars($_POST['nohp']))
  );

  $query_guru = insert($c, $data_guru, 'guru');

  if ($query_user && $query_guru) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=guru");
  }
} elseif (isset($_POST['siswa'])) {
  $nisn = mysqli_escape_string($c, htmlspecialchars($_POST['nisn']));

  $data_user = array(
    'username' => $nisn,
    'password' => password_hash($_POST['nisn'], PASSWORD_DEFAULT),
    'level' => 'siswa'
  );

  $query_user = insert($c, $data_user, 'users');

  $data_siswa = array(
    'id_user' => mysqli_insert_id($c),
    'id_rombel' => mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel'])),
    'id_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['id_wali'])),
    'nama_siswa' => mysqli_escape_string($c, htmlspecialchars($_POST['nama'])),
    'nisn' => $nisn,
    'gender' => mysqli_escape_string($c, htmlspecialchars($_POST['gender'])),
    'tanggal_lahir' => mysqli_escape_string($c, htmlspecialchars($_POST['tanggal_lahir'])),
    'tempat_lahir' => mysqli_escape_string($c, htmlspecialchars($_POST['tempat_lahir'])),
    'agama' => mysqli_escape_string($c, htmlspecialchars($_POST['agama'])),
    'alamat' => mysqli_escape_string($c, htmlspecialchars($_POST['alamat'])),
    'email_siswa' => mysqli_escape_string($c, htmlspecialchars($_POST['email'])),
    'nohp_siswa' => mysqli_escape_string($c, htmlspecialchars($_POST['nohp']))
  );

  $query_siswa = insert($c, $data_siswa, 'siswa');

  if ($query_user && $query_siswa) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=siswa");
  }
} elseif (isset($_POST['wali'])) {
  $data_user = array(
    'username' => mysqli_escape_string($c, htmlspecialchars($_POST['username'])),
    'password' => password_hash($_POST['username'], PASSWORD_DEFAULT),
    'level' => 'wali'
  );

  $query_user = insert($c, $data_user, 'users');

  $data_wali = array(
    'id_user' => mysqli_insert_id($c),
    'nama_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['nama'])),
    'gender_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['gender'])),
    'tanggal_lahir_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['tanggal_lahir'])),
    'tempat_lahir_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['tempat_lahir'])),
    'agama_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['agama'])),
    'alamat_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['alamat'])),
    'email_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['email'])),
    'nohp_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['nohp']))
  );

  $query_wali = insert($c, $data_wali, 'wali');

  if ($query_user && $query_wali) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=wali");
  }
} elseif (isset($_POST['rombel'])) {
  $data = array(
    'walas' => mysqli_escape_string($c, htmlspecialchars($_POST['walas'])),
    'nama_rombel' => mysqli_escape_string($c, htmlspecialchars($_POST['nama']))
  );

  $query = insert($c, $data, 'rombel');

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=rombel");
  }
} elseif (isset($_POST['mapel'])) {
  $data = array(
    'nama_mapel' => mysqli_escape_string($c, htmlspecialchars($_POST['nama']))
  );

  $query = insert($c, $data, 'mapel');

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=mapel");
  }
} elseif (isset($_POST['pengampu'])) {
  $data = array(
    'id_mapel' => mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel'])),
    'id_rombel' => mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel'])),
    'id_guru' => mysqli_escape_string($c, htmlspecialchars($_POST['id_guru']))
  );

  $query = insert($c, $data, 'pengampu');

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=pengampu");
  }
} elseif (isset($_POST['penilaian'])) {
  $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel']));
  $id_mapel = mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel']));
  $id_jenisnilai = mysqli_escape_string($c, htmlspecialchars($_POST['id_jenisnilai']));
  $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$id_rombel"]);

  $queryGuru = select($c, 'users a', ['join' => 'INNER JOIN guru b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
  $dataGuru = mysqli_fetch_assoc($queryGuru);

  $joinNilai = "INNER JOIN siswa b ON a.id_siswa=b.id_siswa";
  $whereNilai = "a.id_mapel=$id_mapel AND b.id_rombel=$id_rombel AND a.id_jenisnilai=$id_jenisnilai";
  $queryNilai = select($c, 'penilaian a', ['join' => $joinNilai, 'where' => $whereNilai]);

  if ($queryNilai->num_rows <= 0) {
    $arraySiswa = array();
    $arrayNilai = array();

    foreach ($querySiswa as $dataSiswa) {
      $nilai = mysqli_escape_string($c, htmlspecialchars($_POST['nilai-' . $dataSiswa['id_siswa']]));
      array_push($arraySiswa, $dataSiswa['id_siswa']);
      array_push($arrayNilai, $nilai);
    }

    $data = array(
      'id_siswa' => $arraySiswa,
      'id_mapel' => $id_mapel,
      'id_jenisnilai' => $id_jenisnilai,
      'nilai' => $arrayNilai
    );

    $query = insert_nilai($c, $data, 'penilaian');
  } else {
    foreach ($querySiswa as $dataSiswa) {
      $nilai = mysqli_escape_string($c, htmlspecialchars($_POST['nilai-' . $dataSiswa['id_siswa']]));
      $where = "id_siswa=" . $dataSiswa['id_siswa'] . " AND id_mapel=$id_mapel AND id_jenisnilai=$id_jenisnilai";
      $querySiswaPenilaian = select($c, 'penilaian', ['where' => $where]);

      if ($querySiswaPenilaian->num_rows > 0) {
        $nilaiDb = mysqli_fetch_assoc($querySiswaPenilaian);
        if ($nilaiDb['nilai'] != $nilai) {
          $query = update($c, ['nilai' => $nilai], 'penilaian', $where);
        }
        continue;
      }

      $dataInput = array(
        'id_siswa' => $dataSiswa['id_siswa'],
        'id_mapel' => $id_mapel,
        'id_jenisnilai' => $id_jenisnilai,
        'nilai' => $nilai
      );
      $query = insert($c, $dataInput, 'penilaian');
    }


    // if (count($arraySiswa) > $queryNilai->num_rows) {
    //   foreach ($arraySiswa as $key => $siswaInput) {
    //     foreach ($queryNilai as $nilaiDb) {
    //       if ($siswaInput == $nilaiDb['id_siswa']) {
    //         continue;
    //       } else {
    //         $where = "id_siswa=" . $siswaInput . " AND id_mapel=$id_mapel";
    //         $querySiswaPenilaian = select($c, 'penilaian', ['where' => $where]);
    //         if ($querySiswaPenilaian->num_rows > 0) {
    //           $query = update($c, ['nilai' => $nilaiInput], 'penilaian', "id_siswa=$nilaiInput");
    //         }
    //         continue;
    //       }

    //       $dataInput = array(
    //         'id_siswa' => $arraySiswa[$key],
    //         'id_mapel' => $id_mapel,
    //         'nilai' => $nilaiInput
    //       );
    //       $query = insert($c, $dataInput, 'penilaian');
    //     }
    //   }
    // } else {
    //   foreach ($arrayNilai as $key => $nilaiInput) {
    //     foreach ($queryNilai as $nilaiDb) {
    //       if ($nilaiInput == $nilaiDb['nilai']) {
    //         continue;
    //       }

    //       $dataInput = array(
    //         'id_siswa' => $arraySiswa[$key],
    //         'id_mapel' => $id_mapel,
    //         'nilai' => $nilaiInput
    //       );
    //       $query = insert($c, $dataInput, 'penilaian');
    //     }
    //   }
    // }
  }

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=penilaian_add");
  }
} elseif (isset($_POST['absensi'])) {
  $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel']));
  $id_mapel = mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel']));
  $tanggal = mysqli_escape_string($c, htmlspecialchars($_POST['tanggal']));
  $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$id_rombel"]);

  $joinAbsensi = "INNER JOIN siswa b ON a.id_siswa=b.id_siswa";
  $whereAbsensi = "a.id_mapel=$id_mapel AND b.id_rombel=$id_rombel AND a.tanggal='$tanggal'";
  $queryAbsensi = select($c, 'absensi a', ['join' => $joinAbsensi, 'where' => $whereAbsensi]);

  if ($queryAbsensi->num_rows <= 0) {
    $arraySiswa = array();
    $arrayAbsensi = array();

    foreach ($querySiswa as $dataSiswa) {
      $absensi = mysqli_escape_string($c, htmlspecialchars($_POST['status-' . $dataSiswa['id_siswa']]));
      array_push($arraySiswa, $dataSiswa['id_siswa']);
      array_push($arrayAbsensi, $absensi);
    }

    $data = array(
      'id_siswa' => $arraySiswa,
      'id_mapel' => $id_mapel,
      'tanggal' => $tanggal,
      'status' => $arrayAbsensi
    );

    $query = insert_absensi($c, $data, 'absensi');
  } else {
    foreach ($querySiswa as $dataSiswa) {
      $absensi = mysqli_escape_string($c, htmlspecialchars($_POST['status-' . $dataSiswa['id_siswa']]));
      $where = "id_siswa=" . $dataSiswa['id_siswa'] . " AND id_mapel=$id_mapel AND tanggal='$tanggal'";
      $querySiswaAbsensi = select($c, 'absensi', ['where' => $where]);

      if ($querySiswaAbsensi->num_rows > 0) {
        $absensiDb = mysqli_fetch_assoc($querySiswaAbsensi);
        if ($absensiDb['status'] != $absensi) {
          $query = update($c, ['status' => "$absensi"], 'absensi', $where);
        }
        continue;
      }

      $dataInput = array(
        'id_siswa' => $dataSiswa['id_siswa'],
        'id_mapel' => $id_mapel,
        'tanggal' => "$tanggal",
        'status' => "$absensi"
      );
      $query = insert($c, $dataInput, 'absensi');
    }


    // if (count($arraySiswa) > $queryAbsensi->num_rows) {
    //   foreach ($arraySiswa as $key => $siswaInput) {
    //     foreach ($queryAbsensi as $absensiDb) {
    //       if ($siswaInput == $absensiDb['id_siswa']) {
    //         continue;
    //       } else {
    //         $where = "id_siswa=" . $siswaInput . " AND id_mapel=$id_mapel";
    //         $querySiswaAbsensi = select($c, 'absensi', ['where' => $where]);
    //         if ($querySiswaAbsensi->num_rows > 0) {
    //           $query = update($c, ['absensi' => $absensiInput], 'absensi', "id_siswa=$absensiInput");
    //         }
    //         continue;
    //       }

    //       $dataInput = array(
    //         'id_siswa' => $arraySiswa[$key],
    //         'id_mapel' => $id_mapel,
    //         'absensi' => $absensiInput
    //       );
    //       $query = insert($c, $dataInput, 'absensi');
    //     }
    //   }
    // } else {
    //   foreach ($arrayAbsensi as $key => $absensiInput) {
    //     foreach ($queryAbsensi as $absensiDb) {
    //       if ($absensiInput == $absensiDb['absensi']) {
    //         continue;
    //       }

    //       $dataInput = array(
    //         'id_siswa' => $arraySiswa[$key],
    //         'id_mapel' => $id_mapel,
    //         'absensi' => $absensiInput
    //       );
    //       $query = insert($c, $dataInput, 'absensi');
    //     }
    //   }
    // }
  }

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=absensi");
  }
} elseif (isset($_POST['jenispenilaian'])) {
  $queryGuru = select($c, 'users a', ['join' => 'INNER JOIN guru b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
  $dataGuru = mysqli_fetch_assoc($queryGuru);

  $data = array(
    'id_guru' => $dataGuru['id_guru'],
    'jenisnilai' => mysqli_escape_string($c, htmlspecialchars($_POST['jenisnilai'])),
    'bobot_nilai' => mysqli_escape_string($c, htmlspecialchars($_POST['bobot_nilai']))
  );

  $query = insert($c, $data, 'jenisnilai');

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=jenis_penilaian");
  }
}
