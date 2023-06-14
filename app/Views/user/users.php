<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"><?= $title ?></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h5 class="card-title">Total Users</h5>
                <h3 class="card-text"><?= $usercount ?></h3>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('users'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h5 class="card-title">New Users</h5>
                <h3 class="card-text"><?= $newusers ?> <small class="small text-whitetext-muted">(in last 30 days)</small></h3>
              </div>
              <div class="icon">
                <i class="ion ion-person-adds"></i>
              </div>
              <a href="<?php echo base_url('users'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h5 class="card-title">Active Users</h5>
                <h3 class="card-text"><?= $percentofactiveusers ?>%</h3>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url('users'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- ./row -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3">
          <h1 class="h2">Users</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createuserformmodal"><i class="fas fa-user-plus"></i> Create User</button>
          </div>
        </div>

        <div class="table-responsive">
          <table width="100%" class="table table-bordered table-striped table-hover" data-order='[[ 0, "asc" ]]'>
            <thead>
              <tr class="table-primary">
                <th class="text-center align-middle">No</th>
                <th class="text-center align-middle">Name</th>
                <th class="text-center align-middle">Email</th>
                <th class="text-center align-middle">Status</th>
                <th class="text-center align-middle">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $item) : ?>
                <tr>
                  <th class="text-center"><?= $item['id'] ?></th>
                  <td><?= $item['name'] ?></td>
                  <td><?= $item['email'] ?></td>
                  <td><?php if ($item['active'] == 1) : ?>
                      Active
                    <?php else : ?>
                      Disabled
                    <?php endif ?>
                  </td>
                  <td>
                    <?php if ($item['active'] == 0) : ?>
                      <a class="btn btn-outline-secondary btn-sm" href="<?= site_url('users/enable/') . $item['id'] ?>"><i class="fas fa-user-check"></i> Enable</a>
                    <?php endif ?>
                    <a class="btn btn-outline-secondary btn-sm" href="<?= site_url('users/edit/') . $item['id'] ?>"><i class="fas fa-edit"></i> Edit</a>
                    <a class="btn btn-outline-secondary btn-sm" href="<?= site_url('users/delete/') . $item['id'] ?>"><i class="fas fa-trash"></i> Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.table -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
</div>
<!-- /.content-wrapper -->
<?= $this->endSection(); ?>