<?php
// Fungsi DML
function select($c, $table, $opt = [])
{
  $select = array_key_exists('select', $opt) ? $opt['select'] : '*';
  $where = array_key_exists('where', $opt) ? $opt['where'] : 1;
  $group = array_key_exists('group', $opt) ? ("GROUP BY " . $opt['group']) : '';

  if (array_key_exists('join', $opt)) {
    return $c->query("SELECT $select FROM $table $opt[join] WHERE $where $group");
  }

  return $c->query("SELECT $select FROM $table WHERE $where $group");
}

function test($c, $table, $opt = [])
{
  $select = array_key_exists('select', $opt) ? $opt['select'] : '*';
  $where = array_key_exists('where', $opt) ? $opt['where'] : 1;
  $group = array_key_exists('group', $opt) ? ("GROUP BY " . $opt['group']) : '';

  if (array_key_exists('join', $opt)) {
    return $c->query("SELECT $select FROM $table $opt[join] WHERE $where $group");
  }

  return "SELECT $select FROM $table WHERE $where $group";
}

function insert($c, $data, $table)
{
  $key = array();
  $value = array();

  foreach ($data as $k => $v) {
    array_push($key, $k);
    array_push($value, "'" . $v . "'");
  }

  $column = implode(',', $key);
  $values = implode(',', $value);

  return $c->query("INSERT INTO $table($column) VALUES ($values)");
}

function insert_nilai($c, $data, $table)
{
  $key = array();
  $value = array();

  foreach ($data as $k => $v) {
    array_push($key, $k);
  }

  for ($i = 0; $i < count($data['id_siswa']); $i++) {
    array_push($value, "(" . $data['id_siswa'][$i] . "," . $data['id_mapel'] . "," . $data['id_jenisnilai'] . "," . $data['nilai'][$i] . ")");
  }

  $column = implode(',', $key);
  $values = implode(',', $value);

  return $c->query("INSERT INTO $table($column) VALUES $values");
}

function insert_absensi($c, $data, $table)
{
  $key = array();
  $value = array();

  foreach ($data as $k => $v) {
    array_push($key, $k);
  }

  for ($i = 0; $i < count($data['id_siswa']); $i++) {
    array_push($value, "(" . $data['id_siswa'][$i] . "," . $data['id_mapel'] . ",'" . $data['tanggal'] . "','" . $data['status'][$i] . "')");
  }

  $column = implode(',', $key);
  $values = implode(',', $value);

  return $c->query("INSERT INTO $table($column) VALUES $values");
}

function update($c, $data, $table, $where)
{
  // $key = array();
  $value = array();

  foreach ($data as $k => $v) {
    // array_push($key, $k);
    array_push($value, $k . "='" . $v . "'");
  }

  $values = implode(',', $value);

  return $c->query("UPDATE $table SET $values WHERE $where");
}

function delete($c, $table, $where)
{
  return $c->query("DELETE FROM $table WHERE $where");
}

// =========================================================================================


// Fungsi Alert
function alert($text, $type = 'success')
{
  $type = 'show' . ucfirst($type) . 'Toast';

  return html_entity_decode("<script>$type('$text')</script>");
}

// =========================================================================================


// Fungsi Bulan
function bulan($tanggal)
{
  $tgl = substr($tanggal, 5, 2);

  $array = array(
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
  );

  return $array[$tgl];
}

// =========================================================================================

// Fungsi Sort
function sortMultiDimensionalArray(&$array, $index)
{
  usort($array, function ($a, $b) use ($index) {
    return $a[$index] - $b[$index];
  });
}

function sortMultiArray($array)
{
  array_multisort(array_map(function ($element) {
    return $element[1];
  }, $array), SORT_ASC, $array);

  return $array;
}

function sortArrayByNumber($array)
{
  usort($array, function ($a, $b) {
    return $b[1] - $a[1];
  });

  return $array;
}
