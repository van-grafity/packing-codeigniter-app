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
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $g->id; ?>" data-number="<?= $g->gl_number; ?>" data-buyer_id="<?= $g->buyer_id; ?>" data-style_id="<?= $g->style_id; ?>" data-season="<?= $g->season; ?>" data-size_order="<?= $g->size_order ?>">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $g->id; ?>" data-number="<?= $g->gl_number; ?>" data-buyer_id="<?= $g->buyer_id; ?>" data-style_id="<?= $g->style_id; ?>" data-season="<?= $g->season; ?>" data-size_order="<?= $g->size_order ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $g->id; ?>">Delete</a>
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

<!-- Modal Add GL-->
<form action="../index.php/gl/save" method="post">
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New GL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>GL No</label>
                        <input type="text" class="form-control" name="number" placeholder="GL Number" autofocus>
                    </div>
                    <div class="form-group">
                        <label>Buyer</label>
                        <select name="gl_buyer" class="form-control">
                            <option value="">-Select Buyer-</option>
                            <?php foreach ($buyer as $b) : ?>
                                <option value="<?= $b->id; ?>"><?= $b->buyer_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Style</label>
                        <select name="gl_style" class="form-control">
                            <option value="">-Select Style-</option>
                            <?php foreach ($style as $s) : ?>
                                <option value="<?= $s->id; ?>"><?= $s->style_description; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Season</label>
                        <input type="text" class="form-control" name="season" placeholder="Season">
                    </div>
                    <div class="form-group">
                        <label>Size Order</label>
                        <input type="text" class="form-control" name="size_order" placeholder="Size Order">
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
<!-- End Modal Add GL-->

<!-- Modal Details GL-->
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
                        <input type="text" disabled class="form-control number" name="number" placeholder="GL Number">
                    </div>
                    <div class="form-group">
                        <label>Buyer</label>
                        <select name="gl_buyer" class="form-control gl_buyer" disabled>
                            <option value="" disabled>-Select Buyer-</option>
                            <?php foreach ($buyer as $b) : ?>
                                <option value="<?= $b->id; ?>"><?= $b->buyer_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Style</label>
                        <select name="gl_style" class="form-control gl_style" disabled>
                            <option value="" disabled>-Select Style-</option>
                            <?php foreach ($style as $s) : ?>
                                <option value="<?= $s->id; ?>"><?= $s->style_description; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Season</label>
                        <input type="text" disabled class="form-control season" name="season" placeholder="Season">
                    </div>
                    <div class="form-group">
                        <label>Size Order</label>
                        <input type="text" disabled class="form-control size_order" name="size_order" placeholder="Size Order">
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
<!-- End Modal Details GL-->

<!-- Modal Edit GL-->
<form action="../index.php/gl/update" method="post">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit GL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>GL No</label>
                        <input type="text" class="form-control number" name="number" placeholder="GL Number">
                    </div>
                    <div class="form-group">
                        <label>Buyer</label>
                        <select name="gl_buyer" class="form-control gl_buyer">
                            <option value="">-Select Buyer-</option>
                            <?php foreach ($buyer as $b) : ?>
                                <option value="<?= $b->id; ?>"><?= $b->buyer_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Style</label>
                        <select name="gl_style" class="form-control gl_style">
                            <option value="">-Select Style-</option>
                            <?php foreach ($style as $s) : ?>
                                <option value="<?= $s->id; ?>"><?= $s->style_description; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Season</label>
                        <input type="text" class="form-control season" name="season" placeholder="Season">
                    </div>
                    <div class="form-group">
                        <label>Size Order</label>
                        <input type="text" class="form-control size_order" name="size_order" placeholder="Size Order">
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
<!-- End Modal Edit GL-->

<!-- Modal Delete Product-->
<form action="../index.php/gl/delete" method="post">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete GL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h4>Are you sure want to delete this GL?</h4>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="glid" class="glID">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Delete Product-->

<script>
    $(document).ready(function() {
        // get GL Detail
        $('.btn-detail').on('click', function() {
            // get data from button detail
            const id = $(this).data('id');
            const number = $(this).data('number');
            const buyer = $(this).data('buyer_id');
            const style = $(this).data('style_id');
            const season = $(this).data('season');
            const sizeorder = $(this).data('size_order');
            // Set data to Form Detail
            $('.id').val(id);
            $('.number').val(number);
            $('.gl_buyer').val(buyer).trigger('change');
            $('.gl_style').val(style).trigger('change');
            $('.season').val(season);
            $('.size_order').val(sizeorder);
            // Call Modal Details
            $('#detailModal').modal('show');
        })

        // get Edit GL
        $('.btn-edit').on('click', function() {
            // get data from button detail
            const id = $(this).data('id');
            const number = $(this).data('number');
            const buyer = $(this).data('buyer_id');
            const style = $(this).data('style_id');
            const season = $(this).data('season');
            const sizeorder = $(this).data('size_order');
            // Set data to Form Detail
            $('.id').val(id);
            $('.number').val(number);
            $('.gl_buyer').val(buyer).trigger('change');
            $('.gl_style').val(style).trigger('change');
            $('.season').val(season);
            $('.size_order').val(sizeorder);
            // Call Modal Edit
            $('#editModal').modal('show');
        });

        // get Delete gl
        $('.btn-delete').on('click', function() {
            // get data from button delete
            const id = $(this).data('id');
            // Set data to Form Delete
            $('.glID').val(id);
            // Call Modal Delete
            $('#deleteModal').modal('show');
        });
    });
</script>

<?= $this->endSection('content'); ?>