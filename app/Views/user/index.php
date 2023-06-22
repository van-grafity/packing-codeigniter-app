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
                            <a href="<?php echo base_url('user'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                            <a href="<?php echo base_url('user'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                            <a href="<?php echo base_url('user'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- ./row -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3">
                    <h1 class="h2"><?php $card_title ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-secondary" id="btn-add-user"><i class="fas fa-user-plus"></i> Create User</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table width="100%" class="table table-bordered table-striped table-hover"
                        data-order='[[ 0, "asc" ]]'>
                        <thead>
                            <tr class="table-primary">
                                <th class="text-center align-middle">No</th>
                                <th class="text-center align-middle">Name</th>
                                <th class="text-center align-middle">Email</th>
                                <th class="text-center align-middle">Role</th>
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
                                <td><?= $item['role'] ?></td>
                                <td><?php if ($item['active'] == 1) : ?>
                                    Active
                                    <?php else : ?>
                                    Disabled
                                    <?php endif ?>
                                </td>
                                <td class="text-right">
                                    <?php if ($item['active'] == 0) : ?>
                                        <a class="btn btn-success btn-sm" href="<?= site_url('user/enable/') . $item['id'] ?>"><i class="fas fa-user-check"></i> Enable</a>
                                    <?php else : ?>
                                        <a class="btn btn-outline-secondary btn-sm" href="<?= site_url('user/disable/') . $item['id'] ?>"><i class="fas fa-user-times"></i> Disable</a>
                                    <?php endif ?>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $item['id']; ?>"
                                        data-firstname="<?= $item['firstname']; ?>"
                                        data-lastname="<?= $item['lastname']; ?>" 
                                        data-name="<?= $item['name']; ?>"
                                        data-email="<?= $item['email']; ?>"
                                        data-role="<?= $item['role_id']; ?>"
                                    ><i class="fas fa-edit"></i>Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $item['id']; ?>"
                                        data-name="<?= $item['name'] ?>"><i class="fas fa-trash"></i> Delete</a>
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

<!-- Modal Add User Detail -->
<div class="modal fade" id="addusermodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="user_form">
                <!-- <input type="hidden" name="edit_user_id" value="" id="edit_user_id"> -->
                <?= csrf_field() ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col">
                            <label for="firstname">First name</label>
                            <input type="text" class="form-control" id="firstname" required name="firstname" placeholder="First name" />
                        </div>
                        <div class="col">
                            <label for="lastname">Last name</label>
                            <input type="text" class="form-control" id="lastname" required name="lastname" placeholder="Last name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Nickname</label>
                        <input type="text" class="form-control" id="name" required name="name" placeholder="Nickname" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" required name="email" placeholder="<?= lang('Auth.email') ?>" />
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">-Select Role-</option>
                            <?php foreach ($roles as $role) : ?>
                                <option value="<?= $role->id; ?>"><?= $role->role; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" required name="password" placeholder="<?= lang('Auth.password') ?>" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password_confirm" required name="password_confirm" placeholder="Confirm Password" />
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
<!-- End Modal Add User Detail-->

<!-- Modal Edit User Detail -->
<div class="modal fade" id="editusermodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="edituser_form">
                <input type="hidden" id="id" name="id">
                <?= csrf_field() ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_firstname">First name</label>
                        <input type="text" class="form-control" required id="edit_firstname" name="firstname">
                    </div>
                    <div class="form-group">
                        <label for="edit_lastname">Last name</label>
                        <input type="text" class="form-control" required id="edit_lastname" name="lastname">
                    </div>
                    <div class="form-group">
                        <label for="edit_name">Nickname</label>
                        <input type="text" class="form-control" required id="edit_name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" required id="edit_email" name="email">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" id="edit_role" class="form-control" required>
                            <option value="">-Select Role-</option>
                            <?php foreach ($roles as $role) : ?>
                                <option value="<?= $role->id; ?>"><?= $role->role; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Style-->
<form action="../index.php/user/delete" method="post">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete user ?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Delete Style-->

<script type="text/javascript">
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);

    // ## Check old if any old data
    if(session._ci_old_input){
        set_old_input_form(session._ci_old_input.post, session.errors);
    }

    // ## prevent submit form when keyboard press enter
    $('#user_form input').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $('#btn-add-user').on('click', function(event) {
        $('#ModalLabel').text("Add New User")
        $('#btn_submit').text("Save")
        $('#user_form').attr('action', store_url);
        $('#btn_submit').attr('hidden', false);
        $('#user_form').find("input[type=text], input[type=number], input[type=email], input[type=password], textarea").val("");
        $('#user_form').find('select').val("").trigger('change');

        // ## remove error sign
        $(`#user_form`).find(".is-invalid").removeClass('is-invalid');
        $(`#user_form`).find(".invalid-feedback").remove();

        // Call the Modal
        $('#addusermodal').modal('show');
    })

    // get Delete User
    $('.btn-delete').on('click', function() {
        // get data from button delete
        let id = $(this).data('id');
        let name = $(this).data('name');

        // Set data to Form Delete
        $('#user_id').val(id);
        if (name) {
            $('#delete_message').text(
                `Are you sure want to delete user (${name}) from this database ?`);
        }

        // Call Modal Delete
        $('#deleteModal').modal('show');
    })

    $('.btn-edit').on('click', function(event) {
        
        // get data from button edit
        let id = $(this).data('id');
        let firstname = $(this).data('firstname');
        let lastname = $(this).data('lastname');
        let name = $(this).data('name');
        let email = $(this).data('email');
        let role = $(this).data('role');

        $('#ModalLabel').text("Edit User")
        $('#btn_update').text("Update User")
        $('#edituser_form').attr('action', update_url);
        $('#edituser_form').append('<input type="hidden" name="_method" value="PUT">');
        
        // ## remove error sign
        $(`#edituser_form`).find(".is-invalid").removeClass('is-invalid');
        $(`#edituser_form`).find(".invalid-feedback").remove();

        // set data to Form
        $('#id').val(id);
        $('#edit_firstname').val(firstname);
        $('#edit_lastname').val(lastname);
        $('#edit_name').val(name);
        $('#edit_email').val(email);
        $('#edit_role').val(role);

        // call the Modal
        $('#editusermodal').modal('show');
    });
});
</script>

<script type="text/javascript">
const store_url = "<?php echo base_url('user/save') ?>";
const update_url = "<?php echo base_url('user/update') ?>";

function set_old_input_form(old_input_data, errors) {
    
    let element_modal_id;
    if(old_input_data._method == "PUT"){
        // set data to Form
        $('#id').val(old_input_data.id);
        $('#edit_firstname').val(old_input_data.firstname);
        $('#edit_lastname').val(old_input_data.lastname);
        $('#edit_name').val(old_input_data.name);
        $('#edit_email').val(old_input_data.email);
        $('#edit_role').val(old_input_data.role);

        $('#ModalLabel').text("Edit User");
        $('#btn_update').text("Update User");
        $('#edituser_form').attr('action', update_url);
        $('#edituser_form').append('<input type="hidden" name="_method" value="PUT">');

        element_modal_id = '#editusermodal';
    } else {
        $('#firstname').val(old_input_data.firstname);
        $('#lastname').val(old_input_data.lastname);
        $('#name').val(old_input_data.name);
        $('#email').val(old_input_data.email);
        $('#role').val(old_input_data.role);

        $('#ModalLabel').text("Add New User");
        $('#btn_submit').text("Save");
        $('#user_form').attr('action', store_url);
        
        element_modal_id = '#addusermodal';
    }
    $(element_modal_id).modal('show');

    // ## Show Error Messages
    for (let [key, value] of Object.entries(errors)) {
        let error_message = `<span id="${key}-error" class="error invalid-feedback">${value}</span>`
        let input_element = $(element_modal_id).find(`[name=${key}]`);
        input_element.addClass('is-invalid');
        input_element.parent().append(error_message);
    }
}
</script>

<?= $this->endSection(); ?>