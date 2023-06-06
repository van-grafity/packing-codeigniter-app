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
                <button type="button" class="btn btn-secondary mb-2" id="btn-add-detail">Add Style</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle">No</th>
                            <th class="text-center align-middle">Style No</th>
                            <th class="text-center align-middle">Style Description</th>
                            <th class="text-center align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($styles as $st) : ?>
                            <tr>
                                <th class="text-center" scope="row"><?= $i++; ?></th>
                                <td><?= $st->style_no; ?></td>
                                <td><?= $st->style_description ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $st->id; ?>" data-number="<?= $st->style_no; ?>" data-description="<?= $st->style_description; ?>">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $st->id; ?>" data-number="<?= $st->style_no; ?>" data-description="<?= $st->style_description; ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $st->id; ?>" data-number="<?= $st->style_no; ?>">Delete</a>
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

<!-- Modal Add and Edit Style Detail -->
<div class="modal fade" id="modal_style_detail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="style_form">
                <input type="hidden" name="edit_style_id" value="" id="edit_style_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Style</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Style No</label>
                        <input type="text" class="form-control" id="number" name="number" placeholder="Style No" autofocus>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
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
<!-- End Modal Add and Edit Style Detail -->

<!-- Modal Delete Style-->
<form action="../index.php/style/delete" method="post">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Style</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h4 id="delete_message">Are you sure want to delete this data?</h4>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="style_id" id="style_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Delete Style-->

<script>
    $(document).ready(function() {
        // ## prevent submit form when keyboard press enter
        $('#style_form input').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        // get Delete Buyer
        $('.btn-delete').on('click', function() {
            // get data from button delete
            let id = $(this).data('id');
            let number = $(this).data('number');

            // Set data to Form Delete
            $('#style_id').val(id);
            if (number) {
                $('#delete_message').text(`Are you sure want to delete this style (${number}) from this database ?`);
            }

            // Call Modal Delete
            $('#deleteModal').modal('show');
        })

        $('#btn-add-detail').on('click', function(event) {
            $('#ModalLabel').text("Add Style")
            $('#btn_submit').text("Add Style")
            $('#style_form').attr('action', store_url);
            $('#btn_submit').attr('hidden', false);
            $('#style_form').find("input[type=text], input[type=number], textarea").val("");
            $('#style_form').find('select').val("").trigger('change');

            $('#modal_style_detail').modal('show');
        })

        $('.btn-edit').on('click', function(event) {
            // get data from button edit
            let id = $(this).data('id');
            let number = $(this).data('number');
            let description = $(this).data('description');

            $('#ModalLabel').text("Edit Style")
            $('#btn_submit').text("Update Style")
            $('#btn_submit').attr('hidden', false);
            $('#style_form').attr('action', update_url);

            // Set ReadOnly the textboxes
            $('#edit_style_id').attr("readonly", false);
            $('#number').attr("readonly", false);
            $('#description').attr("readonly", false);

            // Set data to Form
            $('#edit_style_id').val(id);
            $('#number').val(number);
            $('#description').val(description);

            // Call the Modal
            $('#modal_style_detail').modal('show');
        })

        $('.btn-detail').on('click', function(event) {
            // get data from button edit
            let id = $(this).data('id');
            let number = $(this).data('number');
            let description = $(this).data('description');

            $('#ModalLabel').text("Style Details")
            $('#btn_submit').attr('hidden', false);

            // Set ReadOnly the textboxes
            $('#edit_style_id').attr("readonly", true);
            $('#number').attr("readonly", true);
            $('#description').attr("readonly", true);

            // Set data to Form
            $('#edit_style_id').val(id);
            $('#number').val(number);
            $('#description').val(description);

            // Call the Modal
            $('#modal_style_detail').modal('show');
        })
    });
</script>

<script type="text/javascript">
    const store_url = "../index.php/style/save";
    const update_url = "../index.php/style/update";
</script>

<?= $this->endSection(); ?>