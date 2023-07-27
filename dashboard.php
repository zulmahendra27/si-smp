<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
      <div class="page-header-title d-flex align-items-center">
        <i class="ik ik-bar-chart-2 bg-blue"></i>
        <div class="d-inline">
          <h5 class="mb-0">Dashboard</h5>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row clearfix">
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="widget bg-primary">
              <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="state">
                    <h6>Guru</h6>
                    <h2>
                      <?= select($c, 'guru', ['join' => "INNER JOIN users ON guru.id_user=users.id_user", 'where'=>"users.level!='kepsek'"])->num_rows ?>
                    </h2>
                  </div>
                  <div class="icon">
                    <i class="ik ik-user"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="widget bg-success">
              <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="state">
                    <h6>Siswa</h6>
                    <h2><?= select($c, 'siswa')->num_rows ?></h2>
                  </div>
                  <div class="icon">
                    <i class="ik ik-users"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="widget bg-warning">
              <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="state">
                    <h6>Wali</h6>
                    <h2><?= select($c, 'wali')->num_rows ?></h2>
                  </div>
                  <div class="icon">
                    <i class="ik ik-user-check"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="widget bg-info">
              <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="state">
                    <h6>Rombel</h6>
                    <h2><?= select($c, 'rombel')->num_rows ?></h2>
                  </div>
                  <div class="icon">
                    <i class="ik ik-home"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="widget bg-danger">
              <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="state">
                    <h6>Mata Pelajaran</h6>
                    <h2><?= select($c, 'mapel')->num_rows ?></h2>
                  </div>
                  <div class="icon">
                    <i class="ik ik-book-open"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>