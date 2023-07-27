<div class="d-flex justify-content-center mb-4">
  <h5 class="font-weight-bold">Laporan Data <?= ucwords($_GET['p']) ?></h5>
</div>

<div class="pt-3">
  <table class="table table-striped table-bordered mx-4">
    <thead>
      <tr class="text-center">
        <th>No.</th>
        <th>NISN</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Nama Wali</th>
        <th>Email</th>
        <th>No. HP</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $join = 'INNER JOIN users ON siswa.id_user=users.id_user INNER JOIN rombel ON siswa.id_rombel=rombel.id_rombel INNER JOIN wali ON siswa.id_wali=wali.id_wali';
      $select = "users.username, users.level, siswa.*, rombel.*, wali.id_wali, wali.nama_wali";

      $query = select($c, 'siswa', ['join' => $join, 'select' => $select]);
      if ($query->num_rows > 0) :
        $i = 1;
        foreach ($query as $data) :
      ?>
          <tr>
            <td class="text-center"><?= $i ?></td>
            <td><?= $data['nisn'] ?></td>
            <td><?= $data['nama_siswa'] ?></td>
            <td><?= $data['nama_rombel'] ?></td>
            <td><?= $data['nama_wali'] ?></td>
            <td><?= $data['email_siswa'] ?></td>
            <td><?= $data['nohp_siswa'] ?></td>
          </tr>
        <?php $i++;
        endforeach;
      else : ?>
        <tr>
          <td colspan="7" class="text-center">-- Tidak ada data</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>