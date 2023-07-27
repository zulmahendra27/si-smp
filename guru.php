<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
      <div class="page-header-title d-flex align-items-center">
        <i class="ik ik-user bg-blue"></i>
        <div class="d-inline">
          <h5 class="mb-0">Data Guru</h5>
        </div>
      </div>
      <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
      <button type="button" id="addButton" class="btn btn-success" data-toggle="modal" data-target="#guruModal"><i
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
              <th>NIP</th>
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
            $query = select($c, 'guru', ['join' => 'INNER JOIN users ON guru.id_user=users.id_user', 'where'=>"users.level!='kepsek'"]);
            while ($data = mysqli_fetch_assoc($query)) : ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $data['nip'] == '' ? '-' : $data['nip'] ?></td>
              <td><?= $data['nama_guru'] ?></td>
              <td><?= $data['gender_guru'] ?></td>
              <td><?= $data['tempat_lahir_guru'] . ' /<br>' . date('d-m-Y', strtotime($data['tanggal_lahir_guru'])) ?>
              </td>
              <td><?= $data['agama_guru'] ?></td>
              <td><?= $data['alamat_guru'] ?></td>
              <td><?= $data['email'] ?></td>
              <td><?= $data['nohp'] ?></td>
              <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
              <td>
                <div class="table-actions text-center">
                  <button type="button" class="btn btn-icon btn-info" id="editButton" data-toggle="modal"
                    data-target="#guruModal" onclick="editData(<?= $data['id_user'] ?>)"><i
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

<div class="modal fade" id="guruModal" tabindex="-1" role="dialog" aria-labelledby="guruModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formData" action="./control/aksi_insert.php" method="post" data-type="add">
        <input type="hidden" name="id_user" id="id_user">
        <div class="modal-header">
          <h5 class="modal-title" id="guruModalLabel">Data Guru</h5>
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
            <label for="status" class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-9">
              <select name="status" id="status" class="form-control">
                <option value="asn">ASN</option>
                <option value="honorer">Honorer</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="username" id="usernameLabel" class="col-sm-3 col-form-label">NIP</label>
            <div class="col-sm-9">
              <input type="text" name="username" class="form-control" id="username" placeholder="NIP">
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
          <button type="submit" id="buttonForm" name="guru" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
window.addEventListener("DOMContentLoaded", () => {
  let status = document.getElementById('status');
  let username = document.getElementById('username');
  let usernameLabel = document.getElementById('usernameLabel');

  status.addEventListener('change', function() {
    if (this.value == 'asn') {
      username.setAttribute('placeholder', 'NIP');
      usernameLabel.innerText = 'NIP';
    } else {
      username.setAttribute('placeholder', 'Username');
      usernameLabel.innerText = 'Username';
    }
  });

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
        'detail': 'guru',
        'id_user': id
      })
    })
    .then(response => response.json())
    .then(data => {
      let username = '';
      if (data.nip == '') {
        document.getElementById('usernameLabel').innerText = 'Username';
        username = data.username;
      } else {
        document.getElementById('usernameLabel').innerText = 'NIP';
        username = data.nip
      }

      document.getElementById('id_user').value = data.id_user;
      document.getElementById('nama').value = data.nama_guru;
      document.getElementById('username').value = username;
      document.getElementById('tempat_lahir').value = data.tempat_lahir_guru;
      document.getElementById('tanggal_lahir').value = data.tanggal_lahir_guru;
      document.getElementById('alamat').value = data.alamat_guru;
      document.getElementById('email').value = data.email;
      document.getElementById('nohp').value = data.nohp;

      let gender = document.getElementById("gender");

      for (let i = 0; i < gender.options.length; i++) {
        if (gender.options[i].value == data.gender_guru) {
          gender.options[i].selected = true;
          break;
        }
      }

      let agama = document.getElementById("agama");

      for (let i = 0; i < agama.options.length; i++) {
        if (agama.options[i].value == data.agama_guru) {
          agama.options[i].selected = true;
          break;
        }
      }
    })
    .catch(err => console.log(err));
}

function deleteData(id) {
  document.getElementById('delButton').setAttribute('href', './control/aksi_delete.php?del=guru&id=' + id);
}
</script>