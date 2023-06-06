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
                <button type="button" class="btn btn-secondary mb-2" id="btn-add-detail">Add Colour</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle" width="10%">No</th>
                            <th class="text-center align-middle" width="75%">Colour Name</th>
                            <th class="text-center align-middle" width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($colour as $c) : ?>
                            <tr>
                                <th class="text-center" scope="row"><?= $i++; ?></th>
                                <td><?= $c->colour_name; ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $c->id; ?>" data-colour-name="<?= $c->colour_name ?>">Details</a>
                                    <a class=" btn btn-warning btn-sm btn-edit" data-id="<?= $c->id; ?>" data-colour-name="<?= $c->colour_name ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $c->id; ?>" data-colour-name="<?= $c->colour_name ?>">Delete</a>
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

<!-- Modal Add and Edit Product Type Detail -->
<div class="modal fade" id="modal_colour_detail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="colour_form">
                <input type="hidden" name="edit_colour_id" value="" id="edit_colour_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Colour</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Colour Name</label>
                        <input type="text" class="form-control" id="colour_name" name="name" placeholder="Colour Name" autofocus>
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
<!-- End Modal Add and Edit Product Type Detail -->

<!-- Modal Delete Product Type-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../index.php/colour/delete" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete Colour</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Colour named ?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="colour_id" id="colour_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete Product Type-->

<script>
    $(document).ready(function() {
        // ## prevent submit form when keyboard press enter
        $('#colour_form input').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#btn-add-detail').on('click', function(event) {
            $('#ModalLabel').text("Add New Colour")
            $('#colour_form').attr('action', store_url);
            $('#btn_submit').attr('hidden', false);
            $('#colour_form').find("input[type=text], input[type=number], textarea").val("");
            $('#colour_form').find('select').val("").trigger('change');

            $('#modal_colour_detail').modal('show');
        })

        // get Delete Product Type
        $('.btn-delete').on('click', function() {
            // get data from button delete
            let id = $(this).data('id');
            let colour_name = $(this).data('colour-name');

            // Set data to Form Delete
            $('#colour_id').val(id);
            if (colour_name) {
                $('#delete_message').text(`Are you sure want to delete this colour(${colour_name}) from this database ?`);
            }

            // Call Modal Delete
            $('#deleteModal').modal('show');
        })

        $('.btn-edit').on('click', function(event) {
            // get data from button edit
            let id = $(this).data('id');
            let name = $(this).data('colour-name');

            $('#ModalLabel').text("Edit Colour")
            $('#btn_submit').text("Update Colour")
            $('#btn_submit').attr('hidden', false);
            $('#colour_form').attr('action', update_url);

            // Set ReadOnly the textboxes
            $('#edit_colour_id').attr("readonly", false);
            $('#colour_name').attr("readonly", false);

            // Set data to Form
            $('#edit_colour_id').val(id);
            $('#colour_name').val(name);

            // Call the Modal
            $('#modal_colour_detail').modal('show');
        })

        $('.btn-detail').on('click', function(event) {
            // get data from button edit
            let id = $(this).data('id');
            let name = $(this).data('colour-name');

            $('#ModalLabel').text("Colour Details")
            $('#btn_submit').attr('hidden', true);

            // Set ReadOnly the textboxes
            $('#edit_colour_id').attr("readonly", true);
            $('#colour_name').attr("readonly", true);

            // Set data to Form
            $('#edit_colour_id').val(id);
            $('#colour_name').val(name);

            // Call the Modal
            $('#modal_colour_detail').modal('show');
        })
    });
</script>

<script type="text/javascript">
    const store_url = "../index.php/colour/save";
    const update_url = "../index.php/colour/update";
</script>
<?= $this->endSection(); ?>