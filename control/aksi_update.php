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

  $id_user = mysqli_escape_string($c, htmlspecialchars($_POST['id_user']));
  $data_guru = array(
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

  $query_guru = update($c, $data_guru, 'guru', "id_user=$id_user");

  if ($query_guru) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=guru");
  }
} elseif (isset($_POST['kepsek'])) {
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

  $id_user = mysqli_escape_string($c, htmlspecialchars($_POST['id_user']));
  $data_guru = array(
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

  $query_guru = update($c, $data_guru, 'guru', "id_user=$id_user");

  if ($query_guru) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=kepsek");
  }
} elseif (isset($_POST['siswa'])) {
  $id_user = mysqli_escape_string($c, htmlspecialchars($_POST['id_user']));
  $nisn = mysqli_escape_string($c, htmlspecialchars($_POST['nisn']));

  $data_user = array(
    'username' => $nisn
  );

  $query_user = update($c, $data_user, 'users', "id_user=$id_user");

  $data_siswa = array(
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

  $query_siswa = update($c, $data_siswa, 'siswa', "id_user=$id_user");

  if ($query_siswa) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=siswa");
  }
} elseif (isset($_POST['wali'])) {
  $id_user = mysqli_escape_string($c, htmlspecialchars($_POST['id_user']));

  $data_user = array(
    'username' => mysqli_escape_string($c, htmlspecialchars($_POST['username']))
  );

  $query_user = update($c, $data_user, 'users', "id_user=$id_user");

  $data_wali = array(
    'nama_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['nama'])),
    'gender_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['gender'])),
    'tanggal_lahir_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['tanggal_lahir'])),
    'tempat_lahir_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['tempat_lahir'])),
    'agama_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['agama'])),
    'alamat_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['alamat'])),
    'email_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['email'])),
    'nohp_wali' => mysqli_escape_string($c, htmlspecialchars($_POST['nohp']))
  );

  $query_wali = update($c, $data_wali, 'wali', "id_user=$id_user");

  if ($query_wali) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=wali");
  }
} elseif (isset($_POST['rombel'])) {
  $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel']));

  $data = array(
    'walas' => mysqli_escape_string($c, htmlspecialchars($_POST['walas'])),
    'nama_rombel' => mysqli_escape_string($c, htmlspecialchars($_POST['nama']))
  );

  $query = update($c, $data, 'rombel', "id_rombel=$id_rombel");

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=rombel");
  }
} elseif (isset($_POST['mapel'])) {
  $id_mapel = mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel']));

  $data = array(
    'nama_mapel' => mysqli_escape_string($c, htmlspecialchars($_POST['nama']))
  );

  $query = update($c, $data, 'mapel', "id_mapel=$id_mapel");

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=mapel");
  }
} elseif (isset($_POST['pengampu'])) {
  $id_pengampu = mysqli_escape_string($c, htmlspecialchars($_POST['id_pengampu']));

  $data = array(
    'id_mapel' => mysqli_escape_string($c, htmlspecialchars($_POST['id_mapel'])),
    'id_rombel' => mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel'])),
    'id_guru' => mysqli_escape_string($c, htmlspecialchars($_POST['id_guru']))
  );

  $query = update($c, $data, 'pengampu', "id_pengampu=$id_pengampu");

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=pengampu");
  }
} elseif (isset($_POST['jenispenilaian'])) {
  $id_jenisnilai = mysqli_escape_string($c, htmlspecialchars($_POST['id_jenisnilai']));

  $data = array(
    'jenisnilai' => mysqli_escape_string($c, htmlspecialchars($_POST['jenisnilai'])),
    'bobot_nilai' => mysqli_escape_string($c, htmlspecialchars($_POST['bobot_nilai']))
  );

  $dataPenilaian = [
    'id_jenisnilai' => $id_jenisnilai
  ];

  $query = update($c, $data, 'jenisnilai', "id_jenisnilai=$id_jenisnilai");
  // $queryPenilaian = update($c, $dataPenilaian, 'penilaian', "id_jenisnilai=$id_jenisnilai");

  if ($query) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'success');
    header("Location: ../main.php?p=jenis_penilaian");
  }
}
