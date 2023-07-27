<div class="d-flex justify-content-center mb-4">
  <h5 class="font-weight-bold">Laporan Data <?= ucwords($_GET['p']) ?></h5>
</div>

<div class="pt-3">
  <table class="table table-striped table-bordered mx-4">
    <thead>
      <tr class="text-center">
        <th>No.</th>
        <th>Username</th>
        <th>Nama</th>
        <th>Email</th>
        <th>No. HP</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = select($c, 'wali', ['join' => 'INNER JOIN users ON wali.id_user=users.id_user']);
      if ($query->num_rows > 0) :
        $i = 1;
        foreach ($query as $data) :
      ?>
          <tr>
            <td class="text-center"><?= $i ?></td>
            <td><?= $data['username'] ?></td>
            <td><?= $data['nama_wali'] ?></td>
            <td><?= $data['email_wali'] ?></td>
            <td><?= $data['nohp_wali'] ?></td>
          </tr>
        <?php $i++;
        endforeach;
      else : ?>
        <tr>
          <td colspan="5" class="text-center">-- Tidak ada data</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>