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
                <h3 class="card-text"><?= $newusers ?> <small class="small text-white text-muted">(in last 30 days)</small></h3>
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
                <i class="ion ion-android"></i>
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
            <button type="button" class="btn btn-sm btn-primary" id="btn-add-user"><i class="fas fa-user-plus"></i> Create User</button>
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

<!-- Modal Add and Edit User Detail -->
<div class="modal fade" id="addusermodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" method="post" id="user_form">
        <input type="hidden" name="edit_user_id" value="" id="edit_user_id">

        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name" class="col-form-label">Name :</label>
            <input type="text" class="form-control" id="buyer_name" name="name" placeholder="Buyer Name" autofocus>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn_submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal Add and Edit User Detail-->

<script type="text/javascript">
  $(document).ready(function() {
    // ## prevent submit form when keyboard press enter
    $('#user_form input').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });

    $('#btn-add-user').on('click', function(event) {
      $('#ModalLabel').text("Add User")
      $('#btn_submit').text("Add User")
      $('#user_form').attr('action', store_url);

      $('#user_form').find("input[type=text], input[type=number], textarea").val("");
      $('#user_form').find('select').val("").trigger('change');
    })

    // Call the Modal
    $('#addusermodal').modal('show');
  });
</script>

<script type="text/javascript">
  const store_url = "../index.php/user/save";
  const update_url = "../index.php/user/update";
</script>

<?= $this->endSection(); ?>