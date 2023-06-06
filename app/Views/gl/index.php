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
                <button type="button" class="btn btn-secondary mb-2" id="btn-add-detail">Add GL</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle" width="5%">SN</th>
                            <th class="text-center align-middle" width="15%">GL No.</th>
                            <th class="text-center align-middle" width="20%">Buyer</th>
                            <th class="text-center align-middle" width="20%">Style</th>
                            <th class="text-center align-middle" width="20%">Season</th>
                            <th class="text-center align-middle" width="20%">Size Order</th>
                            <th class="text-center align-middle" width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($gl as $g) : ?>
                            <tr>
                                <td class="text-center" scope="row"><?= $i++; ?></th>
                                <td><?= $g->gl_number; ?></td>
                                <td><?= $g->buyer_name; ?></td>
                                <td><?= $g->style_description; ?></td>
                                <td><?= $g->season; ?></td>
                                <td><?= $g->size_order; ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $g->id; ?>" data-gl-number="<?= $g->gl_number; ?>" data-buyer_id="<?= $g->buyer_id; ?>" data-style_id="<?= $g->style_id; ?>" data-season="<?= $g->season; ?>" data-size_order="<?= $g->size_order ?>">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $g->id; ?>" data-gl-number="<?= $g->gl_number; ?>" data-buyer_id="<?= $g->buyer_id; ?>" data-style_id="<?= $g->style_id; ?>" data-season="<?= $g->season; ?>" data-size_order="<?= $g->size_order ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $g->id; ?>" data-gl-number="<?= $g->gl_number; ?>">Delete</a>
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

<!-- Modal Add and Edit GL Detail -->
<div class="modal fade" id="modal_gl_detail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="gl_form">
                <input type="hidden" name="edit_gl_id" value="" id="edit_gl_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New GL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="number" class="col-form-label">GL No :</label>
                        <input type="text" class="form-control" id="number" name="number" placeholder="GL Number" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="buyer" class="col-form-label">Buyer :</label>
                        <select id="gl_buyer" name="gl_buyer" class="form-control" required>
                            <option value="">-Select Buyer-</option>
                            <?php foreach ($buyer as $b) : ?>
                                <option value="<?= $b->id; ?>"><?= $b->buyer_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="style" class="col-form-label">Style :</label>
                        <select id="gl_style" name="gl_style" class="form-control" required>
                            <option value="">-Select Style-</option>
                            <?php foreach ($style as $s) : ?>
                                <option value="<?= $s->id; ?>"><?= $s->style_description; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="season" class="col-form-label">Season :</label>
                        <input type="text" class="form-control" id="season" name="season" placeholder="Season">
                    </div>
                    <div class="form-group">
                        <label for="size_order" class="col-form-label">Size Order :</label>
                        <input type="text" class="form-control" id="size_order" name="size_order" placeholder="Size Order">
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
<!-- End Modal Add and Edit GL Detail -->

<!-- Modal Delete GL -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../index.php/gl/delete" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete GL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this GL?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="gl_id" id="gl_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete GL -->

<script>
    $(document).ready(function() {
        // ## prevent submit form when keyboard press enter
        $('#gl_form input').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#btn-add-detail').on('click', function(event) {
            $('#ModalLabel').text("Add GL")
            $('#btn_submit').text("Add GL")
            $('#gl_form').attr('action', store_url);
            $('#btn_submit').attr('hidden', false);
            $('#gl_form').find("input[type=text], input[type=number], textarea").val("");
            $('#gl_form').find('select').val("").trigger('change');

            $('#modal_gl_detail').modal('show');
        })

        // get Delete GL
        $('.btn-delete').on('click', function() {
            // get data from button delete
            let id = $(this).data('id');
            let gl_number = $(this).data('gl-number');

            // Set data to Form Delete
            $('#gl_id').val(id);
            if (gl_number) {
                $('#delete_message').text(`Are you sure want to delete this GL (${gl_number}) from this database ?`);
            }

            // Call Modal Delete
            $('#deleteModal').modal('show');
        })

        $('.btn-edit').on('click', function(event) {
            // get data from button delete
            let id = $(this).data('id');
            let gl_number = $(this).data('gl-number');
            let buyer = $(this).data('buyer_id');
            let style = $(this).data('style_id');
            let season = $(this).data('season');
            let sizeorder = $(this).data('size_order');

            $('#ModalLabel').text("Edit GL")
            $('#btn_submit').text("Update GL")
            $('#btn_submit').attr('hidden', false);
            $('#gl_form').attr('action', update_url);

            // Set ReadOnly the textboxes
            $('#edit_gl_id').attr("readonly", false);
            $('#number').attr("readonly", false);
            $('#gl_buyer').attr("readonly", false);
            $('#gl_style').attr("readonly", false);
            $('#season').attr("readonly", false);
            $('#size_order').attr("readonly", false);

            // Set data to Form
            $('#edit_gl_id').val(id);
            $('#number').val(gl_number);
            $('#gl_buyer').val(buyer);
            $('#gl_style').val(style);
            $('#season').val(season);
            $('#size_order').val(sizeorder);

            $('#modal_gl_detail').modal('show');
        })

        $('.btn-detail').on('click', function(event) {
            // get data from button delete
            let id = $(this).data('id');
            let gl_number = $(this).data('gl-number');
            let buyer = $(this).data('buyer_id');
            let style = $(this).data('style_id');
            let season = $(this).data('season');
            let sizeorder = $(this).data('size_order');

            $('#ModalLabel').text("Edit GL")
            $('#btn_submit').text("Update GL")
            $('#btn_submit').attr('hidden', false);
            $('#gl_form').attr('action', update_url);

            // Set ReadOnly the textboxes
            $('#edit_gl_id').attr("readonly", true);
            $('#number').attr("readonly", true);
            $('#gl_buyer').attr("readonly", true);
            $('#gl_style').attr("readonly", true);
            $('#season').attr("readonly", true);
            $('#size_order').attr("readonly", true);

            // Set data to Form
            $('#edit_gl_id').val(id);
            $('#number').val(gl_number);
            $('#gl_buyer').val(buyer);
            $('#gl_style').val(style);
            $('#season').val(season);
            $('#size_order').val(sizeorder);
            $('#modal_gl_detail').modal('show');
        })
    });
</script>

<script type="text/javascript">
    const store_url = "../index.php/gl/save";
    const update_url = "../index.php/gl/update";
</script>

<?= $this->endSection('content'); ?>