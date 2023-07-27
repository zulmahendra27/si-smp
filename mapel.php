<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
      <div class="page-header-title d-flex align-items-center">
        <i class="ik ik-book-open bg-blue"></i>
        <div class="d-inline">
          <h5 class="mb-0">Data Mata Pelajaran</h5>
        </div>
      </div>
      <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
        <button type="button" id="addButton" class="btn btn-success" data-toggle="modal" data-target="#mapelModal"><i class="ik ik-plus-circle"></i>Tambah Data</button>
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
              <th>Nama Mata Pelajaran</th>
              <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
                <th>Aksi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1;
            $query = select($c, 'mapel');
            while ($data = mysqli_fetch_assoc($query)) : ?>
              <tr>
                <td><?= $i ?></td>
                <td><?= $data['nama_mapel'] ?></td>
                <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
                  <td>
                    <div class="table-actions text-center">
                      <button type="button" class="btn btn-icon btn-info" id="editButton" data-toggle="modal" data-target="#mapelModal" onclick="editData(<?= $data['id_mapel'] ?>)"><i class="ik ik-edit-2"></i></button>
                      <button type="button" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="deleteData('<?= $data['id_mapel'] ?>')">
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

<div class="modal fade" id="mapelModal" tabindex="-1" role="dialog" aria-labelledby="mapelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formData" action="./control/aksi_insert.php" method="post" data-type="add">
        <input type="hidden" name="id_mapel" id="id_mapel">
        <div class="modal-header">
          <h5 class="modal-title" id="mapelModalLabel">Data Mata Pelajaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="form-group row">
            <label for="nama" class="col-sm-3 col-form-label">Nama Mapel</label>
            <div class="col-sm-9">
              <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Mata Pelajaran">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="buttonForm" name="mapel" class="btn btn-primary">Simpan</button>
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
          'detail': 'mapel',
          'id_mapel': id
        })
      })
      .then(response => response.json())
      .then(data => {
        document.getElementById('id_mapel').value = data.id_mapel;
        document.getElementById('nama').value = data.nama_mapel;
      })
      .catch(err => console.log(err));
  }

  function deleteData(id) {
    document.getElementById('delButton').setAttribute('href', './control/aksi_delete.php?del=mapel&id=' + id);
  }
</script>