<?php
include_once 'connection.php';
include_once 'helper.php';
session_start();

if (isset($_GET['del'])) {
  if ($_GET['del'] == 'guru') {
    $id = mysqli_escape_string($c, htmlspecialchars($_GET['id']));

    $delUser = delete($c, 'users', "id_user=$id");
    $delGuru = delete($c, 'guru', "id_user=$id");

    if ($delUser && $delGuru) {
      $_SESSION['alert'] = alert('Data berhasil dihapus', 'success');
      header("Location: ../main.php?p=guru");
    }
  } elseif ($_GET['del'] == 'siswa') {
    $id = mysqli_escape_string($c, htmlspecialchars($_GET['id']));

    $delUser = delete($c, 'users', "id_user=$id");
    $delSiswa = delete($c, 'siswa', "id_user=$id");

    if ($delUser && $delSiswa) {
      $_SESSION['alert'] = alert('Data berhasil dihapus', 'success');
      header("Location: ../main.php?p=siswa");
    }
  } elseif ($_GET['del'] == 'wali') {
    $id = mysqli_escape_string($c, htmlspecialchars($_GET['id']));

    $delUser = delete($c, 'users', "id_user=$id");
    $delWali = delete($c, 'wali', "id_user=$id");

    if ($delUser && $delWali) {
      $_SESSION['alert'] = alert('Data berhasil dihapus', 'success');
      header("Location: ../main.php?p=wali");
    }
  } elseif ($_GET['del'] == 'rombel') {
    $id = mysqli_escape_string($c, htmlspecialchars($_GET['id']));

    $del = delete($c, 'rombel', "id_rombel=$id");

    if ($del) {
      $_SESSION['alert'] = alert('Data berhasil dihapus', 'success');
      header("Location: ../main.php?p=rombel");
    }
  } elseif ($_GET['del'] == 'mapel') {
    $id = mysqli_escape_string($c, htmlspecialchars($_GET['id']));

    $del = delete($c, 'mapel', "id_mapel=$id");

    if ($del) {
      $_SESSION['alert'] = alert('Data berhasil dihapus', 'success');
      header("Location: ../main.php?p=mapel");
    }
  } elseif ($_GET['del'] == 'pengampu') {
    $id = mysqli_escape_string($c, htmlspecialchars($_GET['id']));

    $del = delete($c, 'pengampu', "id_pengampu=$id");

    if ($del) {
      $_SESSION['alert'] = alert('Data berhasil dihapus', 'success');
      header("Location: ../main.php?p=pengampu");
    }
  } elseif ($_GET['del'] == 'jenisnilai') {
    $id = mysqli_escape_string($c, htmlspecialchars($_GET['id']));

    $del = delete($c, 'jenisnilai', "id_jenisnilai=$id");
    $delPenilaian = delete($c, 'jenisnilai', "id_jenisnilai=$id");

    if ($del && $delPenilaian) {
      $_SESSION['alert'] = alert('Data berhasil dihapus', 'success');
      header("Location: ../main.php?p=jenis_penilaian");
    }
  }
} else {
  var_dump('Test');
}
