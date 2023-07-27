<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
      <div class="page-header-title d-flex align-items-center">
        <i class="ik ik-edit-1 bg-blue"></i>
        <div class="d-inline">
          <h5 class="mb-0">Pengisian Nilai Siswa</h5>
        </div>
      </div>
      <a class="btn btn-info" href="?p=penilaian"><i class="ik ik-arrow-left-circle"></i>Kembali</a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <form action="./control/aksi_insert.php" method="post">
        <div class="card-body pb-0">
          <div class="row">
            <div class="col-lg-4 form-group">
              <?php
              if ($_SESSION['level'] == 'guru') {
                $queryGuru = select($c, 'users a', ['join' => 'INNER JOIN guru b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
                $dataGuru = mysqli_fetch_assoc($queryGuru);
              }

              $join = "INNER JOIN pengampu b ON a.id_rombel=b.id_rombel";
              $where = "b.id_guru=" . $dataGuru['id_guru'];
              $queryRombel = select($c, 'rombel a', ['join' => $join, 'where' => $where, 'select' => "DISTINCT(b.id_rombel), a.*"]);
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
              <select name="id_rombel" id="rombel" class="form-control" onchange="changeRombel(event)">
                <?php if ($queryRombel->num_rows > 0) : foreach ($queryRombel as $data) : ?>
                    <option <?= $data['id_rombel'] == $rombel ? 'selected' : '' ?> value="<?= $data['id_rombel'] ?>">
                      <?= $data['nama_rombel'] ?></option>
                  <?php endforeach;
                else : ?>
                  <option value="-1">-- Tidak ada data --</option>
                <?php endif ?>
              </select>
            </div>
            <div class="col-lg-4 form-group">
              <?php
              $join = "INNER JOIN pengampu b ON a.id_mapel=b.id_mapel";
              $where = "b.id_rombel=$rombel AND b.id_guru=" . $dataGuru['id_guru'];
              $queryMapel = select($c, 'mapel a', ['where' => $where, 'join' => $join]);
              if (!isset($_GET['m'])) {
                if ($queryMapel->num_rows > 0) {
                  $mapel = mysqli_fetch_assoc($queryMapel)['id_mapel'];
                } else {
                  $mapel = -1;
                }
              } else {
                $mapel = mysqli_escape_string($c, htmlspecialchars($_GET['m']));
              }
              ?>
              <label for="mapel">Pilih Mapel</label>
              <select name="id_mapel" id="mapel" class="form-control" onchange="changeMapel(event)">
                <?php if ($queryMapel->num_rows > 0) : foreach ($queryMapel as $data) : ?>
                    <option <?= $data['id_mapel'] == $mapel ? 'selected' : '' ?> value="<?= $data['id_mapel'] ?>">
                      <?= $data['nama_mapel'] ?></option>
                  <?php endforeach;
                else : ?>
                  <option value="-1">-- Tidak ada data --</option>
                <?php endif; ?>
              </select>
            </div>
            <div class="col-lg-4 form-group">
              <?php
              $where = "id_guru=" . $dataGuru['id_guru'];
              $queryJenisNilai = select($c, 'jenisnilai', ['where' => $where]);
              if (!isset($_GET['n'])) {
                if ($queryJenisNilai->num_rows > 0) {
                  $jenisnilai = mysqli_fetch_assoc($queryJenisNilai)['id_jenisnilai'];
                } else {
                  $jenisnilai = -1;
                }
              } else {
                $jenisnilai = mysqli_escape_string($c, htmlspecialchars($_GET['n']));
              }
              ?>
              <label for="jenisnilai">Pilih Jenis Penilaian</label>
              <select name="id_jenisnilai" id="jenisnilai" class="form-control" onchange="changeJenisNilai(event)">
                <?php if ($queryJenisNilai->num_rows > 0) : foreach ($queryJenisNilai as $data) : ?>
                    <option <?= $data['id_jenisnilai'] == $jenisnilai ? 'selected' : '' ?> value="<?= $data['id_jenisnilai'] ?>">
                      <?= $data['jenisnilai'] ?></option>
                  <?php endforeach;
                else : ?>
                  <option value="-1">-- Tidak ada data --</option>
                <?php endif; ?>
              </select>
            </div>
          </div>
          <?php
          $joinNilai = "INNER JOIN siswa b ON a.id_siswa=b.id_siswa";
          $whereNilai = "a.id_mapel=$mapel AND b.id_rombel=$rombel AND a.id_jenisnilai=$jenisnilai";
          $queryNilai = select($c, 'penilaian a', ['join' => $joinNilai, 'where' => $whereNilai]);
          $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$rombel"]);

          if ($querySiswa->num_rows > 0) :
          ?>
            <button type="submit" name="penilaian" class="btn btn-primary">Simpan Penilaian</button>
          <?php endif; ?>
        </div>
        <div class="card-body">
          <table id="tabelData" class="table table-striped table-bordered dt-responsive nowrap">
            <thead>
              <tr>
                <th>No.</th>
                <th>Siswa</th>
                <th class="nosort sorting_disabled">Nilai</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $arrayNilai = array();
              foreach ($queryNilai as $dataNilai) {
                $arrayNilai[$dataNilai['id_siswa']] = $dataNilai['nilai'];
              }

              $i = 1;
              foreach ($querySiswa as $dataSiswa) :
                $nilai = array_key_exists($dataSiswa['id_siswa'], $arrayNilai) ? $arrayNilai[$dataSiswa['id_siswa']] : 0;
              ?>
                <tr>
                  <th><?= $i ?></th>
                  <th><?= $dataSiswa['nama_siswa'] ?></th>
                  <th>
                    <input type="number" name="nilai-<?= $dataSiswa['id_siswa'] ?>" class="form-control form-control-danger" min="0" value="<?= $nilai ?>">
                  </th>
                </tr>
              <?php
                $i++;
              endforeach; ?>
            </tbody>
          </table>

        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function changeRombel(e) {
    window.location.href = `?p=penilaian_add&r=${e.target.value}`;
  }

  function changeMapel(e) {
    let rombel = document.getElementById('rombel');

    window.location.href = `?p=penilaian_add&r=${rombel.value}&m=${e.target.value}`;
  }

  function changeJenisNilai(e) {
    let rombel = document.getElementById('rombel');
    let mapel = document.getElementById('mapel');

    window.location.href = `?p=penilaian_add&r=${rombel.value}&m=${mapel.value}&n=${e.target.value}`;
  }
</script>