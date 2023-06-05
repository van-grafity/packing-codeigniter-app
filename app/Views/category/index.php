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
                <button type="button" class="btn btn-secondary mb-2" id="btn-add-detail">Add Product Type</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle" width="10%">No</th>
                            <th class="text-center align-middle">Product Type Name</th>
                            <th class="text-center align-middle" width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($category as $c) : ?>
                            <tr>
                                <th class="text-center" scope="row"><?= $i++; ?></th>
                                <td><?= $c->category_name; ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $c->id ?>" data-category-name="<?= $c->category_name ?>">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $c->id ?>" data-category-name="<?= $c->category_name ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $c->id ?>" data-category-name="<?= $c->category_name ?>">Delete</a>
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

<div class="modal fade" id="modal_category_detail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="category_form">
                <input type="hidden" name="edit_category_id" value="" id="edit_category_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Product Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Type Name</label>
                        <input type="text" class="form-control" id="category_name" name="name" placeholder="Product Type Name" autofocus>
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
</form>
<!-- End Modal Add and Edit Product Type Detail -->

<!-- Modal Delete Product Type-->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../index.php/category/delete" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete Product Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Product Type?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="category_id" id="category_id">
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
        $('#purchase_order_form input').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#btn-add-detail').on('click', function(event) {
            $('#ModalLabel').text("Add Product Type")
            $('#btn_submit').text("Add Product Type")
            $('#category_form').attr('action', store_url);
            $('#btn_submit').attr('hidden', false);
            $('#category_form').find("input[type=text], input[type=number], textarea").val("");
            $('#category_form').find('select').val("").trigger('change');

            $('#modal_category_detail').modal('show');
        })

        // get Delete Product Type
        $('.btn-delete').on('click', function() {
            // get data from button delete
            let id = $(this).data('id');
            let category_name = $(this).data('category-name');

            // Set data to Form Delete
            $('#category_id').val(id);
            if (category_name) {
                $('#delete_message').text(`Are you sure want to delete this Product Type (${category_name}) from this database ?`);
            }

            // Call Modal Delete
            $('#deleteModal').modal('show');
        })

        $('.btn-edit').on('click', function(event) {
            // get data from button edit
            let id = $(this).data('id');
            let name = $(this).data('category-name');

            $('#ModalLabel').text("Edit Category")
            $('#btn_submit').text("Update Category")
            $('#btn_submit').attr('hidden', false);
            $('#category_form').attr('action', update_url);

            // Set ReadOnly the textboxes
            $('#edit_category_id').attr("readonly", false);
            $('#category_name').attr("readonly", false);

            // Set data to Form
            $('#edit_category_id').val(id);
            $('#category_name').val(name);

            // Call the Modal
            $('#modal_category_detail').modal('show');
        })

        $('.btn-detail').on('click', function(event) {
            // get data from button edit
            let id = $(this).data('id');
            let name = $(this).data('category-name');

            $('#ModalLabel').text("Category Details")
            $('#btn_submit').attr('hidden', true);

            // Set ReadOnly the textboxes
            $('#edit_category_id').attr("readonly", true);
            $('#category_name').attr("readonly", true);

            // Set data to Form
            $('#edit_category_id').val(id);
            $('#category_name').val(name);

            // Call the Modal
            $('#modal_category_detail').modal('show');
        })
    });
</script>

<script type="text/javascript">
    const store_url = "../index.php/category/save";
    const update_url = "../index.php/category/update";
</script>

<?= $this->endSection(); ?>