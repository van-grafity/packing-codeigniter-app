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
                            <th class="text-center align-middle" width="15%">GL No.</th>
                            <th class="text-center align-middle" width="20%">Buyer</th>
                            <th class="text-center align-middle" width="20%">Season</th>
                            <th class="text-center align-middle" width="20%">Style</th>
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
                                <td><?= $g->season; ?></td>
                                <td><?= $g->style_description; ?></td>
                                <td><?= $g->size_order; ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm btn-detail">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete">Delete</a>
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

<!-- Modal Details Style-->
<form action="" method="post">
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">GL Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>GL No</label>
                        <input type="text" disabled class="form-control number" name="number" placeholder="GL No">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Season</label>
                        <input type="text" disabled class="form-control season" name="season" placeholder="Season">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Size Order</label>
                        <input type="text" disabled class="form-control description" name="description" placeholder="Order Size Range">
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


<script>
    $(document).ready(function() {
        // get Style Detail
        $('.btn-detail').on('click', function() {
            // get data from button detail
            const id = $(this).data('id');
            const number = $(this).data('number');
            const season = $(this).data('season');
            // Set data to Form Detail
            $('.id').val(id);
            $('.number').val(number);
            $('.description').val(description);
            // Call Modal Detail
            $('#detailModal').modal('show');
        });
    });
</script>

<?= $this->endSection('content'); ?>