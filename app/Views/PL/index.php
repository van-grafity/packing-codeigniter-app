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
                            <th class="text-center align-middle">PL No.</th>
                            <th class="text-center align-middle">PO No.</th>
                            <th class="text-center align-middle">Buyer</th>
                            <th class="text-center align-middle">GL No.</th>
                            <th class="text-center align-middle">Season</th>
                            <th class="text-center align-middle">Size Order</th>
                            <th class="text-center align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pl as $pl) : ?>
                            <tr>
                                <td><a href="<?= base_url('index.php/packinglist/' . $pl['packinglist_no']); ?>"><?= esc($pl['packinglist_no']); ?></a></td>
                                <td onClick="window.location.href='<?= base_url('index.php/home'); ?>'"><?= esc($pl['PO_No']); ?></td>
                                <td><?= esc($pl['buyer_name']); ?></td>
                                <td><?= esc($pl['gl_number']); ?></td>
                                <td><?= esc($pl['season']); ?></td>
                                <td><?= esc($pl['size_order']); ?></td>
                                <td class="text-center align-middle">
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
    </section>
</div>

<!-- Modal Add Packing List-->
<form action=" ../index.php/buyer/save" method="post">
    <?= csrf_field(); ?>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Packing List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List No :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packing_list_no" name="PL_no" autofocus placeholder="Packing List No">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">PO No :</label>
                        <select name="packinglist_po_id" class="form-control">
                            <option value="">-Select-</option>
                            <?php foreach ($po as $p) : ?>
                                <option value="<?= $p->id; ?>"><?= $p->PO_No; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Date :</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="packing_list_date" name="packing_list_date" autofocus placeholder="Packing List Date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packing_list_qty" name="packing_list_qty" autofocus placeholder="Packing List Qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Cutting Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packing_list_cutting_qty" name="packing_list_cutting_qty" autofocus placeholder="Packing List Cutting Qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Ship Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packing_list_ship_qty" name="packing_list_ship_qty" autofocus placeholder="Packing List Ship Qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Amount :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packing_list_amount" name="packing_list_amount" autofocus placeholder="Packing List Amount">
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
    </div>
</form>
<!-- End Modal Add Packing List -->

<style>
    td {
        cursor: pointer;
    }
</style>
</section>
</div>
<?= $this->endSection(); ?>