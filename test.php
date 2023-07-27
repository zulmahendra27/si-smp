<?php
include_once './control/helper.php';
include_once './control/connection.php';

$data = [
  'username' => 'kepsek',
  'password' => password_hash('kepsek', PASSWORD_DEFAULT),
  'level' => 'kepsek'
];

// insert($c, $data, 'users');

$dataKepsek = [
  // 'id_user' => mysqli_insert_id($c),
  'nip' => '152678712798121',
  'nama_guru' => 'Kepala Sekolah',
  'gender_guru' => 'L',
  'tanggal_lahir_guru' => '1978-02-27',
  'tempat_lahir_guru' => 'Padang',
  'agama_guru' => 'Islam',
  'alamat_guru' => 'Padang',
  'email' => 'kepalasekolah@gmail.com',
  'nohp' => '082374385627'
];

// insert($c, $dataKepsek, 'guru');
// print_r(mysqli_fetch_assoc(select($c, 'guru', ['where' => "guru.id_user=3"])));