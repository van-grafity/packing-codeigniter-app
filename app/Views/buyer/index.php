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
                <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addModal">Add New</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle" width="5%">SN</th>
                            <th class="text-center align-middle" width="15%">Buyer Name</th>
                            <th class="text-center align-middle" width="25%">Office Address</th>
                            <th class="text-center align-middle" width="35%">Ship Address</th>
                            <th class="text-center align-middle" width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($buyer as $b) : ?>
                            <tr>
                                <th class="text-center" scope="row"><?= $i++; ?></th>
                                <td><?= $b->buyer_name; ?></td>
                                <td><?= $b->offadd; ?></td>
                                <td><?= $b->shipadd; ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $b->id; ?>" data-name="<?= $b->buyer_name; ?>" data-offadd="<?= $b->offadd; ?>" data-shipadd="<?= $b->shipadd; ?>" data-country="<?= $b->country; ?>">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $b->id; ?>" data-name="<?= $b->buyer_name; ?>" data-offadd="<?= $b->offadd; ?>" data-shipadd="<?= $b->shipadd; ?>" data-country="<?= $b->country; ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $b->id; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
</div>

<!-- Modal Add Buyer -->
<form action=" ../index.php/buyer/save" method="post">
    <?= csrf_field(); ?>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Buyer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Name :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="buyer_name" name="name" autofocus placeholder="Buyer Name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="office_address" class="col-sm-3 col-form-label">Office :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="offadd" name="offadd" placeholder="Office Address">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ship_address" class="col-sm-3 col-form-label">Warehouse :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipadd" name="shipadd" placeholder="Warehouse Address">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="country" class="col-sm-3 col-form-label">Country :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                        </div>
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
<!-- End Modal Add Buyer -->

<!-- Modal Buyer Details-->
<form action="../index.php/buyer/update" method="post">
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buyer Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Buyer Name</label>
                        <input type="text" disabled class="form-control buyer_name" name="name" placeholder="Buyer Name">
                    </div>

                    <div class="form-group">
                        <label>Office Address</label>
                        <input type="text" disabled class="form-control offadd" name="offadd" placeholder="Office Address">
                    </div>

                    <div class="form-group">
                        <label>Warehouse</label>
                        <input type="text" disabled class="form-control shipadd" name="shipadd" placeholder="Warehouse">
                    </div>

                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" disabled class="form-control country" name="country" placeholder="Country">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Buyer Details-->

<!-- Modal Edit Buyer-->
<form action="../index.php/buyer/update" method="post">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Buyer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Buyer Name</label>
                        <input type="text" class="form-control buyer_name" name="name" placeholder="Buyer Name">
                    </div>

                    <div class="form-group">
                        <label>Office Address</label>
                        <input type="text" class="form-control offadd" name="offadd" placeholder="Office Address">
                    </div>

                    <div class="form-group">
                        <label>Warehouse</label>
                        <input type="text" class="form-control shipadd" name="shipadd" placeholder="Warehouse">
                    </div>

                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control country" name="country" placeholder="Country">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="buyer_id" class="buyer_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Edit Buyer -->

<!-- Modal Delete Buyer -->
<form action="../index.php/buyer/delete" method="post">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Buyer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h4>Are you sure want to delete this buyer ?</h4>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="buyer_id" class="buyerID">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Delete Buyer -->

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // get Buyer Detail
        $('.btn-detail').on('click', function() {
            // get data from button detail
            const id = $(this).data('id');
            const name = $(this).data('name');
            const offadd = $(this).data('offadd');
            const shipadd = $(this).data('shipadd');
            const country = $(this).data('country');
            // Set data to Form Detail
            $('.buyer_id').val(id);
            $('.buyer_name').val(name);
            $('.offadd').val(offadd);
            $('.shipadd').val(shipadd);
            $('.country').val(country);
            // Call Modal Detail
            $('#detailModal').modal('show');
        });

        // get Edit Buyer
        $('.btn-edit').on('click', function() {
            // get data from button edit
            const id = $(this).data('id');
            const name = $(this).data('name');
            const offadd = $(this).data('offadd');
            const shipadd = $(this).data('shipadd');
            const country = $(this).data('country');
            // Set data to Form Edit
            $('.buyer_id').val(id);
            $('.buyer_name').val(name);
            $('.offadd').val(offadd);
            $('.shipadd').val(shipadd);
            $('.country').val(country);
            // Call Modal Edit
            $('#editModal').modal('show');
        });

        // get Delete Product
        $('.btn-delete').on('click', function() {
            // get data from button delete
            const id = $(this).data('id');
            // Set data to Form Delete
            $('.buyerID').val(id);
            // Call Modal Delete
            $('#deleteModal').modal('show');
        });
    });
</script>
</section>
</div>
<?= $this->endSection('content'); ?>