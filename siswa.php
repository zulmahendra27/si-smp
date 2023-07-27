<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
      <div class="page-header-title d-flex align-items-center">
        <i class="ik ik-users bg-blue"></i>
        <div class="d-inline">
          <h5 class="mb-0">Data Siswa</h5>
        </div>
      </div>
      <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
      <button type="button" id="addButton" class="btn btn-success" data-toggle="modal" data-target="#siswaModal"><i
          class="ik ik-plus-circle"></i>Tambah Data</button>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <table id="tabelData" class="table table-striped table-bordered dt-responsive nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>NISN</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Jenis Kelamin</th>
              <th>Nama Wali</th>
              <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
              <th>Aksi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1;
            $join = 'INNER JOIN users ON siswa.id_user=users.id_user LEFT JOIN rombel ON siswa.id_rombel=rombel.id_rombel LEFT JOIN wali ON siswa.id_wali=wali.id_wali';
            $select = "users.username, users.level, siswa.*, rombel.*, wali.id_wali, wali.nama_wali";
            $query = select($c, 'siswa', ['join' => $join, 'select' => $select]);
            while ($data = mysqli_fetch_assoc($query)) : ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $data['nisn'] ?></td>
              <td><?= $data['nama_siswa'] ?></td>
              <td><?= $data['nama_rombel'] ?></td>
              <td><?= $data['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
              <td><?= $data['nama_wali'] ?></td>
              <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
              <td>
                <div class="table-actions text-center">
                  <button type="button" class="btn btn-icon btn-success" id="detailButton" data-toggle="modal"
                    data-target="#detailModal" onclick="detailData(<?= $data['id_user'] ?>)" title="Detail Siswa">
                    <i class="ik ik-eye"></i>
                  </button>
                  <button type="button" class="btn btn-icon btn-info" id="editButton" data-toggle="modal"
                    data-target="#siswaModal" onclick="editData(<?= $data['id_user'] ?>)">
                    <i class="ik ik-edit-2"></i>
                  </button>
                  <button type="button" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#deleteModal"
                    onclick="deleteData('<?= $data['id_user'] ?>')">
                    <i class="ik ik-trash-2"></i>
                  </button>
                </div>
              </td>
              <?php endif; ?>
            </tr>
            <?php $i++;
            endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="siswaModal" tabindex="-1" role="dialog" aria-labelledby="siswaModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formData" action="./control/aksi_insert.php" method="post" data-type="add">
        <input type="hidden" name="id_user" id="id_user">
        <div class="modal-header">
          <h5 class="modal-title" id="siswaModalLabel">Data Siswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="form-group row">
            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama">
            </div>
          </div>
          <div class="form-group row">
            <label for="nisn" id="nisnLabel" class="col-sm-3 col-form-label">NISN</label>
            <div class="col-sm-9">
              <input type="text" name="nisn" class="form-control" id="nisn" placeholder="NISN">
            </div>
          </div>
          <div class="form-group row">
            <label for="gender" id="genderLabel" class="col-sm-3 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-9">
              <select name="gender" id="gender" class="form-control">
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="tempat_lahir" id="tempat_lahirLabel" class="col-sm-3 col-form-label">Tempat Lahir</label>
            <div class="col-sm-9">
              <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" placeholder="Tempat Lahir">
            </div>
          </div>
          <div class="form-group row">
            <label for="tanggal_lahir" id="tanggal_lahirLabel" class="col-sm-3 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-9">
              <input type="date" value="<?= date('Y-m-d') ?>" name="tanggal_lahir" class="form-control"
                id="tanggal_lahir" placeholder="Tanggal Lahir">
            </div>
          </div>
          <div class="form-group row">
            <label for="agama" id="agamaLabel" class="col-sm-3 col-form-label">Agama</label>
            <div class="col-sm-9">
              <select name="agama" id="agama" class="form-control">
                <option value="Islam">Islam</option>
                <option value="Protestan">Protestan</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Budha">Budha</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="alamat" id="alamatLabel" class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-9">
              <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat">
            </div>
          </div>
          <div class="form-group row">
            <label for="rombel" id="rombelLabel" class="col-sm-3 col-form-label">Rombel</label>
            <div class="col-sm-9">
              <select name="id_rombel" id="rombel" class="form-control">
                <option value="-1">-- Pilih Rombel --</option>
                <?php
                $queryRombel = select($c, 'rombel');
                while ($data = mysqli_fetch_assoc($queryRombel)) :
                ?>
                <option value="<?= $data['id_rombel'] ?>"><?= $data['nama_rombel'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="wali" id="waliLabel" class="col-sm-3 col-form-label">Nama Wali</label>
            <div class="col-sm-9">
              <select name="id_wali" id="wali" class="form-control">
                <option value="-1">-- Pilih Wali --</option>
                <?php
                $queryWali = select($c, 'wali');
                while ($data = mysqli_fetch_assoc($queryWali)) :
                ?>
                <option value="<?= $data['id_wali'] ?>"><?= $data['nama_wali'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
          </div>
          <div class="form-group row">
            <label for="nohp" class="col-sm-3 col-form-label">No. HP</label>
            <div class="col-sm-9">
              <input type="text" name="nohp" class="form-control" id="nohp" placeholder="No. HP">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="buttonForm" name="siswa" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Data Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

        <div class="table-responsive">
          <table class="table" width="100%">
            <tr>
              <td>Nama</td>
              <td>:</td>
              <td id="detailNama"></td>
            </tr>
            <tr>
              <td>NISN</td>
              <td>:</td>
              <td id="detailNISN"></td>
            </tr>
            <tr>
              <td>Jenis Kelamin</td>
              <td>:</td>
              <td id="detailGender"></td>
            </tr>
            <tr>
              <td>Tempat Lahir</td>
              <td>:</td>
              <td id="detailTempatLahir"></td>
            </tr>
            <tr>
              <td>Tanggal Lahir</td>
              <td>:</td>
              <td id="detailTanggalLahir"></td>
            </tr>
            <tr>
              <td>Agama</td>
              <td>:</td>
              <td id="detailAgama"></td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>:</td>
              <td id="detailAlamat"></td>
            </tr>
            <tr>
              <td>Rombel</td>
              <td>:</td>
              <td id="detailRombel"></td>
            </tr>
            <tr>
              <td>Wali</td>
              <td>:</td>
              <td id="detailWali"></td>
            </tr>
            <tr>
              <td>Email</td>
              <td>:</td>
              <td id="detailEmail"></td>
            </tr>
            <tr>
              <td>No. HP</td>
              <td>:</td>
              <td id="detailNohp"></td>
            </tr>
          </table>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
window.addEventListener("DOMContentLoaded", () => {
  let addButton = document.getElementById('addButton');
  let formData = document.getElementById('formData');

  addButton.addEventListener('click', function() {
    formData.reset();
    formData.setAttribute('action', './control/aksi_insert.php');
  });
});

function editData(id) {
  document.getElementById('formData').setAttribute('action', './control/aksi_update.php')

  fetch('./control/aksi_select.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        'detail': 'siswa',
        'id_user': id
      })
    })
    .then(response => response.json())
    .then(data => {
      document.getElementById('id_user').value = data.id_user;
      document.getElementById('nama').value = data.nama_siswa;
      document.getElementById('nisn').value = data.nisn;
      document.getElementById('tempat_lahir').value = data.tempat_lahir;
      document.getElementById('tanggal_lahir').value = data.tanggal_lahir;
      document.getElementById('alamat').value = data.alamat;
      document.getElementById('email').value = data.email_siswa;
      document.getElementById('nohp').value = data.nohp_siswa;

      let gender = document.getElementById("gender");

      for (let i = 0; i < gender.options.length; i++) {
        if (gender.options[i].value == data.gender) {
          gender.options[i].selected = true;
          break;
        }
      }

      let agama = document.getElementById("agama");

      for (let i = 0; i < agama.options.length; i++) {
        if (agama.options[i].value == data.agama) {
          agama.options[i].selected = true;
          break;
        }
      }

      let rombel = document.getElementById("rombel");

      for (let i = 0; i < rombel.options.length; i++) {
        if (rombel.options[i].value == data.id_rombel) {
          rombel.options[i].selected = true;
          break;
        }
      }

      let wali = document.getElementById("wali");

      for (let i = 0; i < wali.options.length; i++) {
        if (wali.options[i].value == data.id_wali) {
          wali.options[i].selected = true;
          break;
        }
      }
    })
    .catch(err => console.log(err));
}

function detailData(id) {
  fetch('./control/aksi_select.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        'detail': 'siswa',
        'id_user': id
      })
    })
    .then(response => response.json())
    .then(data => {
      let tanggalLahir = data.tanggal_lahir;
      let arrayTanggalLahir = tanggalLahir.split("-");

      document.getElementById('detailNama').innerHTML = data.nama_siswa;
      document.getElementById('detailNISN').innerHTML = data.nisn;
      document.getElementById('detailGender').innerHTML = data.gender == 'L' ? 'Laki-laki' : 'Perempuan';
      document.getElementById('detailTempatLahir').innerHTML = data.tempat_lahir;
      document.getElementById('detailTanggalLahir').innerHTML = arrayTanggalLahir[2] + "-" + arrayTanggalLahir[1] +
        "-" + arrayTanggalLahir[0];
      document.getElementById('detailAgama').innerHTML = data.agama;
      document.getElementById('detailAlamat').innerHTML = data.alamat;
      document.getElementById('detailRombel').innerHTML = data.nama_rombel;
      document.getElementById('detailWali').innerHTML = data.nama_wali;
      document.getElementById('detailEmail').innerHTML = data.email_siswa;
      document.getElementById('detailNohp').innerHTML = data.nohp_siswa;
    })
    .catch(err => console.log(err));
}

function deleteData(id) {
  document.getElementById('delButton').setAttribute('href', './control/aksi_delete.php?del=siswa&id=' + id);
}
</script>