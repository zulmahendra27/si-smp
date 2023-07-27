<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
      <div class="page-header-title d-flex align-items-center">
        <i class="ik ik-home bg-blue"></i>
        <div class="d-inline">
          <h5 class="mb-0">Jenis Penilaian</h5>
        </div>
      </div>
      <button type="button" id="addButton" class="btn btn-success" data-toggle="modal"
        data-target="#jenisPenilaianModal"><i class="ik ik-plus-circle"></i>Tambah Data</button>
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
              <th>Jenis Penilaian</th>
              <th>Bobot Nilai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1;
            $query = select($c, 'jenisnilai');
            while ($data = mysqli_fetch_assoc($query)) : ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $data['jenisnilai'] ?></td>
              <td><?= $data['bobot_nilai'] ?></td>
              <td>
                <div class="table-actions text-center">
                  <button type="button" class="btn btn-icon btn-info" id="editButton" data-toggle="modal"
                    data-target="#jenisPenilaianModal" onclick="editData(<?= $data['id_jenisnilai'] ?>)"><i
                      class="ik ik-edit-2"></i></button>
                  <button type="button" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#deleteModal"
                    onclick="deleteData('<?= $data['id_jenisnilai'] ?>')">
                    <i class="ik ik-trash-2"></i>
                  </button>
                </div>
              </td>
            </tr>
            <?php $i++;
            endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="jenisPenilaianModal" tabindex="-1" role="dialog" aria-labelledby="jenisPenilaianModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formData" action="./control/aksi_insert.php" method="post" data-type="add">
        <input type="hidden" name="id_jenisnilai" id="id_jenisnilai">
        <div class="modal-header">
          <h5 class="modal-title" id="jenisPenilaianModalLabel">Jenis Penilaian</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="form-group row">
            <label for="jenisnilai" class="col-sm-3 col-form-label">Jenis Penilaian</label>
            <div class="col-sm-9">
              <input type="text" name="jenisnilai" class="form-control" id="jenisnilai" placeholder="Jenis Penilaian">
            </div>
          </div>
          <div class="form-group row">
            <label for="bobot_nilai" class="col-sm-3 col-form-label">Bobot Nilai</label>
            <div class="col-sm-9">
              <input type="number" min="10" value="10" name="bobot_nilai" class="form-control" id="bobot_nilai"
                placeholder="Bobot Nilai">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="buttonForm" name="jenispenilaian" class="btn btn-primary">Simpan</button>
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
  document.getElementById('formData').setAttribute('action', './control/aksi_update.php')

  fetch('./control/aksi_select.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        'detail': 'jenisnilai',
        'id_jenisnilai': id
      })
    })
    .then(response => response.json())
    .then(data => {
      document.getElementById('id_jenisnilai').value = data.id_jenisnilai;
      document.getElementById('jenisnilai').value = data.jenisnilai;
      document.getElementById('bobot_nilai').value = data.bobot_nilai;
    })
    .catch(err => console.log(err));
}

function deleteData(id) {
  document.getElementById('delButton').setAttribute('href', './control/aksi_delete.php?del=jenisnilai&id=' + id);
}
</script>