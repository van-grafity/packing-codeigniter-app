<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addModal">Add New</button>

                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle">SN</th>
                            <th class="text-center align-middle">Factory Name</th>
                            <th class="text-center align-middle">In-Charge</th>
                            <th class="text-center align-middle">Remarks</th>
                            <th class="text-center align-middle">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($factory as $fty) : ?>
                            <tr>
                                <th class="text-center" scope="row"><?= $i++; ?></th>
                                <td><?= $fty->name; ?></td>
                                <td><?= $fty->incharge; ?></td>
                                <td><?= $fty->remarks; ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $fty->id; ?>" data-name="<?= $fty->name; ?>" data-incharge="<?= $fty->incharge; ?>" data-remarks="<?= $fty->remarks ?>">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $fty->id; ?>" data-name="<?= $fty->name; ?>" data-incharge="<?= $fty->incharge; ?>" data-remarks="<?= $fty->remarks ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $fty->id; ?>">Delete</a>
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

<!-- Modal Add Factory-->
<form action="../index.php/factory/save" method="post">
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Factory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Factory Name</label>
                        <input type="text" class="form-control" name="fty_name" placeholder="Factory Name" autofocus>
                    </div>
                    <div class="form-group">
                        <label>Factory In-charge</label>
                        <input type="text" class="form-control" name="incharge" placeholder="Factory In-charge">
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" class="form-control" name="remarks" placeholder="Remarks">
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
<!-- End Modal Add Factory-->

<!-- Modal Details Factory-->
<form action="" method="post">
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Factory Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Factory Name</label>
                        <input type="text" disabled class="form-control name" name="name" placeholder="Factory Name">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Factory In-charge</label>
                        <input type="text" disabled class="form-control incharge" name="incharge" placeholder="Factory In-charge">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" disabled class="form-control remarks" name="remarks" placeholder="Remarks">
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
<!-- End Modal Details Factory-->

<!-- Modal Edit Factory-->
<form action="../index.php/factory/update" method="post">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Factory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Factory Name</label>
                        <input type="text" class="form-control name" name="name" placeholder="Factory Name">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Factory In-charge</label>
                        <input type="text" class="form-control incharge" name="incharge" placeholder="Factory In-charge">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" class="form-control remarks" name="remarks" placeholder="Remarks">
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
<!-- End Modal Edit Factory-->

<!-- Modal Delete Factory-->
<form action="../index.php/factory/delete" method="post">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Factory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h4>Are you sure want to delete this data?</h4>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="factory_id" class="factoryID">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Delete Factory-->

<script>
    $(document).ready(function() {
        // get Factory Detail
        $('.btn-detail').on('click', function() {
            // get data from button detail
            const id = $(this).data('id');
            const name = $(this).data('name');
            const incharge = $(this).data('incharge');
            const remarks = $(this).data('remarks');
            // Set data to Form Detail
            $('.id').val(id);
            $('.name').val(name);
            $('.incharge').val(incharge);
            $('.remarks').val(remarks);
            // Call Modal Detail
            $('#detailModal').modal('show');
        });

        // get Edit Factory
        $('.btn-edit').on('click', function() {
            // get data from button edit
            const id = $(this).data('id');
            const name = $(this).data('name');
            const incharge = $(this).data('incharge');
            const remarks = $(this).data('remarks');
            // Set data to Form Edit
            $('.id').val(id);
            $('.name').val(name);
            $('.incharge').val(incharge);
            $('.remarks').val(remarks);
            // Call Modal Edit
            $('#editModal').modal('show');
        });

        // get Delete Factory
        $('.btn-delete').on('click', function() {
            // get data from button delete
            const id = $(this).data('id');
            // Set data to Form Delete
            $('.factoryID').val(id);
            // Call Modal Delete
            $('#deleteModal').modal('show');
        });
    });
</script>
<?= $this->endSection('content'); ?>