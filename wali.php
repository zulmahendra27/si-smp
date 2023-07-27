<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
      <div class="page-header-title d-flex align-items-center">
        <i class="ik ik-user-check bg-blue"></i>
        <div class="d-inline">
          <h5 class="mb-0">Data Wali</h5>
        </div>
      </div>
      <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
      <button type="button" id="addButton" class="btn btn-success" data-toggle="modal" data-target="#waliModal"><i
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
              <th>Username</th>
              <th>Nama</th>
              <th>Gender</th>
              <th>Tempat /<br>Tanggal Lahir</th>
              <th>Agama</th>
              <th>Alamat</th>
              <th>Email</th>
              <th>No. HP</th>
              <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
              <th>Aksi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1;
            $query = select($c, 'wali', ['join' => 'INNER JOIN users ON wali.id_user=users.id_user']);
            while ($data = mysqli_fetch_assoc($query)) : ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $data['username'] ?></td>
              <td><?= $data['nama_wali'] ?></td>
              <td><?= $data['gender_wali'] ?></td>
              <td><?= $data['tempat_lahir_wali'] . ' /<br>' . date('d-m-Y', strtotime($data['tanggal_lahir_wali'])) ?>
              </td>
              <td><?= $data['agama_wali'] ?></td>
              <td><?= $data['alamat_wali'] ?></td>
              <td><?= $data['email_wali'] ?></td>
              <td><?= $data['nohp_wali'] ?></td>
              <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
              <td>
                <div class="table-actions text-center">
                  <button type="button" class="btn btn-icon btn-info" id="editButton" data-toggle="modal"
                    data-target="#waliModal" onclick="editData(<?= $data['id_user'] ?>)"><i
                      class="ik ik-edit-2"></i></button>
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

<div class="modal fade" id="waliModal" tabindex="-1" role="dialog" aria-labelledby="waliModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formData" action="./control/aksi_insert.php" method="post" data-type="add">
        <input type="hidden" name="id_user" id="id_user">
        <div class="modal-header">
          <h5 class="modal-title" id="waliModalLabel">Data Wali</h5>
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
            <label for="username" id="usernameLabel" class="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-9">
              <input type="text" name="username" class="form-control" id="username" placeholder="Username">
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
          <button type="submit" id="buttonForm" name="wali" class="btn btn-primary">Simpan</button>
        </div>
      </form>
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
  document.getElementById('formData').setAttribute('action', './control/aksi_update.php');

  fetch('./control/aksi_select.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        'detail': 'wali',
        'id_user': id
      })
    })
    .then(response => response.json())
    .then(data => {
      document.getElementById('id_user').value = data.id_user;
      document.getElementById('nama').value = data.nama_wali;
      document.getElementById('username').value = data.username;
      document.getElementById('tempat_lahir').value = data.tempat_lahir_wali;
      document.getElementById('tanggal_lahir').value = data.tanggal_lahir_wali;
      document.getElementById('alamat').value = data.alamat_wali;
      document.getElementById('email').value = data.email_wali;
      document.getElementById('nohp').value = data.nohp_wali;

      let gender = document.getElementById("gender");

      for (let i = 0; i < gender.options.length; i++) {
        if (gender.options[i].value == data.gender_wali) {
          gender.options[i].selected = true;
          break;
        }
      }

      let agama = document.getElementById("agama");

      for (let i = 0; i < agama.options.length; i++) {
        if (agama.options[i].value == data.agama_wali) {
          agama.options[i].selected = true;
          break;
        }
      }
    })
    .catch(err => console.log(err));
}

function deleteData(id) {
  document.getElementById('delButton').setAttribute('href', './control/aksi_delete.php?del=wali&id=' + id);
}
</script>