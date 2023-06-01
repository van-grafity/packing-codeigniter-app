<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addModal">Add Product Type</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle" width="10%">No</th>
                            <th class="text-center align-middle" width="75%">Product Type Name</th>
                            <th class="text-center align-middle" width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($category as $c) : ?>
                            <tr>
                                <th class="text-center" scope="row"><?= $i++; ?></th>
                                <td><?= $c->category_name; ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $c->id ?>" data-name="<?= $c->category_name ?>">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $c->id ?>" data-name="<?= $c->category_name ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $c->id ?>">Delete</a>
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

<!-- Modal Add Product Type -->
<form action="../index.php/category/save" method="post">
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Product Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Type Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Product Type Name" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Add Product Type -->

<!-- Modal Details Product Type-->
<form action="" method="post">
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Product Type Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Type Name </label>
                        <input type="text" disabled class="form-control name" name="name" placeholder="Product Type Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Details Product Type-->

<!-- Modal Edit Product Type-->
<form action="../index.php/category/update" method="post">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Type Name</label>
                        <input type="text" class="form-control name" name="name" placeholder="Product Type Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Edit Product Type-->

<!-- Modal Delete Product Type-->
<form action="../index.php/category/delete" method="post">
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

                    <h4>Are you sure want to delete this Product Type?</h4>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="categoryID">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Delete Product Type-->

<script>
    $(document).ready(function() {
        // get Product Type Detail
        $('.btn-detail').on('click', function() {
            // get data from button detail
            const id = $(this).data('id');
            const name = $(this).data('name');
            // Set data to Form Detail
            $('.id').val(id);
            $('.name').val(name);
            // Call Modal Detail
            $('#detailModal').modal('show');
        });

        // get Edit Product Type
        $('.btn-edit').on('click', function() {
            // get data from button edit
            const id = $(this).data('id');
            const name = $(this).data('name');
            // Set data to Form Edit
            $('.id').val(id);
            $('.name').val(name);
            // Call Modal Edit
            $('#editModal').modal('show');
        });

        // get Delete Product Type
        $('.btn-delete').on('click', function() {
            // get data from button delete
            const id = $(this).data('id');
            // Set data to Form Delete
            $('.categoryID').val(id);
            // Call Modal Delete
            $('#deleteModal').modal('show');
        });
    });
</script>

<?= $this->endSection(); ?>