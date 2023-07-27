<?php
include_once 'connection.php';
include_once 'helper.php';

if (isset($_POST['detail'])) {
  if ($_POST['detail'] == 'guru') {
    $id_user = mysqli_escape_string($c, htmlspecialchars($_POST['id_user']));
    $where = array(
      'where' => "guru.id_user=$id_user",
      'join' => "INNER JOIN users ON users.id_user=guru.id_user",
      'select' => "users.username, users.level, guru.*"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'guru', $where)));
  } elseif ($_POST['detail'] == 'kepsek') {
    // $id_user = mysqli_escape_string($c, htmlspecialchars($_POST['id_user']));
    $where = array(
      'where' => "users.level='kepsek'",
      'join' => "INNER JOIN users ON users.id_user=guru.id_user",
      'select' => "users.username, users.level, guru.*"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'guru', $where)));
  } elseif ($_POST['detail'] == 'siswa') {
    $id_user = mysqli_escape_string($c, htmlspecialchars($_POST['id_user']));
    $join = "INNER JOIN users ON users.id_user=siswa.id_user LEFT JOIN rombel ON siswa.id_rombel=rombel.id_rombel LEFT JOIN wali ON siswa.id_wali=wali.id_wali";
    $where = array(
      'where' => "siswa.id_user=$id_user",
      'join' => $join,
      'select' => "users.username, users.level, siswa.*, rombel.*, wali.id_wali, wali.nama_wali"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'siswa', $where)));
  } elseif ($_POST['detail'] == 'wali') {
    $id_user = mysqli_escape_string($c, htmlspecialchars($_POST['id_user']));
    $where = array(
      'where' => "wali.id_user=$id_user",
      'join' => "INNER JOIN users ON users.id_user=wali.id_user",
      'select' => "users.username, users.level, wali.*"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'wali', $where)));
  } elseif ($_POST['detail'] == 'rombel') {
    $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel']));
    $where = array(
      'where' => "rombel.id_rombel=$id_rombel",
      'join' => "INNER JOIN guru ON rombel.walas=guru.id_guru"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'rombel', $where)));
  } elseif ($_POST['detail'] == 'mapel') {
    $id_mapel = mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel']));
    $where = array(
      'where' => "id_mapel=$id_mapel"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'mapel', $where)));
  } elseif ($_POST['detail'] == 'pengampu') {
    $id_pengampu = mysqli_escape_string($c, htmlspecialchars($_POST['id_pengampu']));
    $where = array(
      'where' => "id_pengampu=$id_pengampu"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'pengampu', $where)));
  } elseif ($_POST['detail'] == 'jenisnilai') {
    $id_jenisnilai = mysqli_escape_string($c, htmlspecialchars($_POST['id_jenisnilai']));
    $where = array(
      'where' => "id_jenisnilai=$id_jenisnilai"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'jenisnilai', $where)));
  }
} elseif (isset($_POST['laporan'])) {
  session_start();
  if ($_POST['laporan'] == 'penilaian_mapel') {
    $newData = array();
    $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel']));

    if ($_SESSION['level'] == 'guru') {
      $queryGuru = select($c, 'users a', ['join' => 'INNER JOIN guru b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
      $dataGuru = mysqli_fetch_assoc($queryGuru);
      $where = "b.id_rombel=$id_rombel AND b.id_guru=" . $dataGuru['id_guru'];
    } else {
      $where = "b.id_rombel=$id_rombel";

      // $id_siswa = mysqli_escape_string($c, htmlspecialchars($_POST['id_siswa']));

      $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$id_rombel"]);

      $arraySiswa = array();

      foreach ($querySiswa as $dataSiswa) {
        array_push($arraySiswa, $dataSiswa);
      }

      $newData['data_siswa'] = $arraySiswa;
    }

    $join = "INNER JOIN pengampu b ON a.id_mapel=b.id_mapel";
    $queryMapel = select($c, 'mapel a', ['where' => $where, 'join' => $join]);

    $array = array();
    $arrayJenisNilai = array();

    foreach ($queryMapel as $key => $data) {
      if ($key == 0) {

        if ($_SESSION['level'] == 'guru') {
          $id_guru = $dataGuru['id_guru'];
        } else {
          $id_mapel = $data['id_mapel'];

          $wherePengampu = "id_mapel=$id_mapel AND id_rombel=$id_rombel";
          $queryPengampu = select($c, 'pengampu', ['where' => $wherePengampu]);

          $id_guru = -1;
          if ($queryPengampu->num_rows > 0) {
            $id_guru = mysqli_fetch_assoc($queryPengampu)['id_guru'];
          }
        }

        $queryJenisNilai = select($c, 'jenisnilai', ['where' => "id_guru=" . $id_guru]);

        if ($queryJenisNilai->num_rows > 0) {
          foreach ($queryJenisNilai as $jenisnilai) {
            array_push($arrayJenisNilai, $jenisnilai);
          }
        }
      }
      array_push($array, $data);
    }

    $newData['data_mapel'] = $array;
    $newData['data_jenisnilai'] = $arrayJenisNilai;

    echo json_encode($newData);
  } elseif ($_POST['laporan'] == 'penilaian_siswa') {
    $id_siswa = mysqli_escape_string($c, htmlspecialchars($_POST['id_siswa']));
    $opt = array(
      'where' => "a.id_siswa=$id_siswa"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'penilaian a', $opt)));
  } elseif ($_POST['laporan'] == 'penilaian_mapel_jenisnilai') {
    $newData = array();

    $id_mapel = mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel']));
    $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel']));

    $arrayJenisNilai = array();

    if ($_SESSION['level'] == 'guru') {
      $queryGuru = select($c, 'users a', ['join' => 'INNER JOIN guru b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
      $dataGuru = mysqli_fetch_assoc($queryGuru);

      $id_guru = $dataGuru['id_guru'];
    } else {
      $wherePengampu = "id_mapel=$id_mapel AND id_rombel=$id_rombel";
      $queryPengampu = select($c, 'pengampu', ['where' => $wherePengampu]);

      $id_guru = -1;
      if ($queryPengampu->num_rows > 0) {
        $id_guru = mysqli_fetch_assoc($queryPengampu)['id_guru'];
      }
    }

    $queryJenisNilai = select($c, 'jenisnilai', ['where' => "id_guru=" . $id_guru]);

    if ($queryJenisNilai->num_rows > 0) {
      foreach ($queryJenisNilai as $jenisnilai) {
        array_push($arrayJenisNilai, $jenisnilai);
      }
    }

    $newData['data_jenisnilai'] = $arrayJenisNilai;

    echo json_encode($newData);
  } elseif ($_POST['laporan'] == 'penilaian_siswa_mapel') {
    $newData = array();

    $id_siswa = mysqli_escape_string($c, htmlspecialchars($_POST['id_siswa']));

    $whereSiswa = "id_siswa=$id_siswa";
    $querySiswa = select($c, 'siswa', ['where' => $whereSiswa]);
    $id_rombel = $querySiswa->num_rows > 0 ? mysqli_fetch_assoc($querySiswa)['id_rombel'] : -1;

    $joinMapel = "INNER JOIN pengampu b ON a.id_mapel=b.id_mapel";
    $whereMapel = "b.id_rombel=$id_rombel";

    $queryMapel = select($c, 'mapel a', ['where' => $whereMapel, 'join' => $joinMapel]);

    $arrayMapel = array();

    if ($queryMapel->num_rows > 0) {
      foreach ($queryMapel as $mapel) {
        array_push($arrayMapel, $mapel);
      }
    }

    $newData['data_mapel'] = $arrayMapel;

    echo json_encode($newData);
  }
} elseif (isset($_POST['absensi'])) {
  session_start();
  if ($_POST['absensi'] == 'absensi') {
    $newData = array();
    $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel']));

    if ($_SESSION['level'] == 'guru') {
      $queryGuru = select($c, 'users a', ['join' => 'INNER JOIN guru b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
      $dataGuru = mysqli_fetch_assoc($queryGuru);
      $where = "b.id_rombel=$id_rombel AND b.id_guru=" . $dataGuru['id_guru'];
    } else {
      $where = "b.id_rombel=$id_rombel";
    }

    $join = "INNER JOIN pengampu b ON a.id_mapel=b.id_mapel";
    $queryMapel = select($c, 'mapel a', ['where' => $where, 'join' => $join]);

    $array = array();

    foreach ($queryMapel as $data) {
      array_push($array, $data);
    }

    $newData['data_mapel'] = $array;

    echo json_encode($newData);
  }
}
