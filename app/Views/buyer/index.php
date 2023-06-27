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
                <button type="button" class="btn btn-secondary mb-2" id="btn-add-detail">Add Buyer</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle" width="10%">SN</th>
                            <th class="text-center align-middle" width="15%">Buyer Name</th>
                            <th class="text-center align-middle" width="30%">Office Address</th>
                            <th class="text-center align-middle" width="30%">Ship Address</th>
                            <th class="text-center align-middle" width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($buyer as $b) : ?>
                            <tr>
                                <td class="text-center" scope="row"><?= $i++; ?></td>
                                <td><?= $b->buyer_name; ?></td>
                                <td><?= $b->offadd; ?></td>
                                <td><?= $b->shipadd; ?></td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $b->id; ?>" data-buyer-name="<?= $b->buyer_name; ?>" data-offadd="<?= $b->offadd; ?>" data-shipadd="<?= $b->shipadd; ?>" data-country="<?= $b->country; ?>">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $b->id; ?>" data-buyer-name="<?= $b->buyer_name; ?>" data-offadd="<?= $b->offadd; ?>" data-shipadd="<?= $b->shipadd; ?>" data-country="<?= $b->country; ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $b->id; ?>" data-buyer-name="<?= $b->buyer_name; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.section -->
</div>

<!-- Modal Add and Edit Buyer Detail -->
<div class="modal fade" id="modal_buyer_detail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="buyer_form">
                <input type="hidden" name="edit_buyer_id" value="" id="edit_buyer_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Buyer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name :</label>
                        <input type="text" class="form-control" id="buyer_name" name="name" placeholder="Buyer Name" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="office_address" class="col-form-label">Office :</label>
                        <input type="text" class="form-control" id="offadd" name="offadd" placeholder="Office Address">
                    </div>

                    <div class="form-group">
                        <label for="ship_address" class="col-form-label">Warehouse :</label>
                        <input type="text" class="form-control" id="shipadd" name="shipadd" placeholder="Warehouse Address">
                    </div>
                    <div class="form-group">
                        <label for="country" class="col-form-label">Country :</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder="Country">
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
<!-- End Modal Add and Edit Buyer Detail-->

<!-- Modal Delete Buyer -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('buyer/delete')?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete Buyer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this buyer ?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="buyer_id" id="buyer_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</form>
<!-- End Modal Delete Buyer -->

<script type="text/javascript">
    $(document).ready(function() {
        // ## prevent submit form when keyboard press enter
        $('#buyer_form input').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#btn-add-detail').on('click', function(event) {
            $('#ModalLabel').text("Add Buyer")
            $('#btn_submit').text("Add Buyer")
            $('#buyer_form').attr('action', store_url);
            $('#btn_submit').attr('hidden', false);
            $('#buyer_form').find("input[type=text], input[type=number], textarea").val("");
            $('#buyer_form').find('select').val("").trigger('change');

            $('#modal_buyer_detail').modal('show');
        })

        // get Delete Buyer
        $('.btn-delete').on('click', function() {
            // get data from button delete
            let id = $(this).data('id');
            let buyer_name = $(this).data('buyer-name');

            // Set data to Form Delete
            $('#buyer_id').val(id);
            if (buyer_name) {
                $('#delete_message').text(`Are you sure want to delete this Buyer (${buyer_name}) from this database ?`);
            }

            // Call Modal Delete
            $('#deleteModal').modal('show');
        })

        $('.btn-edit').on('click', function(event) {
            // get data from button edit
            let id = $(this).data('id');
            let name = $(this).data('buyer-name');
            let offadd = $(this).data('offadd');
            let shipadd = $(this).data('shipadd');
            let country = $(this).data('country');

            $('#ModalLabel').text("Edit Buyer")
            $('#btn_submit').text("Update Buyer")
            $('#btn_submit').attr('hidden', false);
            $('#buyer_form').attr('action', update_url);

            // Set ReadOnly the textboxes
            $('#edit_buyer_id').attr("readonly", false);
            $('#buyer_name').attr("readonly", false);
            $('#offadd').attr("readonly", false);
            $('#shipadd').attr("readonly", false);
            $('#country').attr("readonly", false);

            // Set data to Form
            $('#edit_buyer_id').val(id);
            $('#buyer_name').val(name);
            $('#offadd').val(offadd);
            $('#shipadd').val(shipadd);
            $('#country').val(country);

            // Call the Modal
            $('#modal_buyer_detail').modal('show');
        })

        $('.btn-detail').on('click', function(event) {
            // get data from button Detail
            let id = $(this).data('id');
            let name = $(this).data('buyer-name');
            let offadd = $(this).data('offadd');
            let shipadd = $(this).data('shipadd');
            let country = $(this).data('country');

            $('#ModalLabel').text("Buyer Details")
            $('#btn_submit').attr('hidden', true);

            // Set ReadOnly the textboxes
            $('#edit_buyer_id').attr("readonly", true);
            $('#buyer_name').attr("readonly", true);
            $('#offadd').attr("readonly", true);
            $('#shipadd').attr("readonly", true);
            $('#country').attr("readonly", true);

            // Set data to Form
            $('#edit_buyer_id').val(id);
            $('#buyer_name').val(name);
            $('#offadd').val(offadd);
            $('#shipadd').val(shipadd);
            $('#country').val(country);

            // Call the Modal
            $('#modal_buyer_detail').modal('show');
        })
    });
</script>

<script type="text/javascript">
    const store_url = "<?php echo base_url('buyer/save'); ?>";
    const update_url = "<?php echo base_url('buyer/update'); ?>";
</script>

<?= $this->endSection('content'); ?>