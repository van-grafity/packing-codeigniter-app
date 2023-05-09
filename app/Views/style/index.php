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
                <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addModal">Add Style</button>
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
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $st->id; ?>">Delete</a>
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

<!-- Modal Add Style-->
<form action="../index.php/style/save" method="post">
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Style</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Style No</label>
                        <input type="text" class="form-control" name="number" placeholder="Style No" autofocus>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" placeholder="Description">
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
<!-- End Modal Add Style-->

<!-- Modal Details Style-->
<form action="" method="post">
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Style Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Style No</label>
                        <input type="text" disabled class="form-control number" name="number" placeholder="Style No">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Style Description</label>
                        <input type="text" disabled class="form-control description" name="description" placeholder="Description">
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
<!-- End Modal Details Style-->

<!-- Modal Edit Style-->
<form action="../index.php/style/update" method="post">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Style</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Style No</label>
                        <input type="text" class="form-control number" name="number" placeholder="Style Number">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Style Description</label>
                        <input type="text" class="form-control description" name="description" placeholder="Description">
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
<!-- End Modal Edit Style-->

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

                    <h4>Are you sure want to delete this data?</h4>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="style_id" class="styleID">
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
        // get Style Detail
        $('.btn-detail').on('click', function() {
            // get data from button detail
            const id = $(this).data('id');
            const number = $(this).data('number');
            const description = $(this).data('description');
            // Set data to Form Detail
            $('.id').val(id);
            $('.number').val(number);
            $('.description').val(description);
            // Call Modal Detail
            $('#detailModal').modal('show');
        });

        // get Edit Style
        $('.btn-edit').on('click', function() {
            // get data from button edit
            const id = $(this).data('id');
            const number = $(this).data('number');
            const description = $(this).data('description');
            // Set data to Form Edit
            $('.id').val(id);
            $('.number').val(number);
            $('.description').val(description);
            // Call Modal Edit
            $('#editModal').modal('show');
        });

        // get Delete Style
        $('.btn-delete').on('click', function() {
            // get data from button delete
            const id = $(this).data('id');
            // Set data to Form Delete
            $('.styleID').val(id);
            // Call Modal Delete
            $('#deleteModal').modal('show');
        });
    });
</script>

<?= $this->endSection(); ?>