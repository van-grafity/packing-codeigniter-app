<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addModal">Add New</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle" width="5%">SN</th>
                            <th class="text-center align-middle" width="10%">PL No.</th>
                            <th class="text-center align-middle" width="20%">Buyer</th>
                            <th class="text-center align-middle" width="20%">PO No.</th>
                            <th class="text-center align-middle" width="20%">GL No.</th>
                            <th class="text-center align-middle" width="10%">Season</th>
                            <th class="text-center align-middle" width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($PackingList as $PL) : ?>
                            <tr>
                                <td class="text-center" scope="row"><?= $i++; ?></td>
                                <td><a href="<?= '../index.php/packinglist/' . $PL->packinglist_no; ?>"><?= $PL->packinglist_no; ?></a></td>
                                <td><?= $PL->buyer_name; ?></td>
                                <td><?= $PL->PO_No; ?></td>
                                <td><?= $PL->gl_number; ?></td>
                                <td><?= $PL->season; ?></td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-warning btn-sm btn-edit">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<form action="<?= base_url('index.php/packinglist/store'); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
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
                            <input type="text" class="form-control" id="packinglist_no" name="packinglist_no" autofocus placeholder="Packing List No" value="" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="packinglist_po_id" class="col-sm-3 col-form-label">PO No :</label>
                        <select id="packinglist_po_id" name="packinglist_po_id" class="form-control">
                            <option value="">-Select-</option>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Date :</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="packinglist_date" name="packinglist_date" autofocus placeholder="Packing List Date" value="<?= date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Order Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" disabled class="form-control" id="packinglist_qty" name="packinglist_qty" autofocus placeholder="Order Qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Ship Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_ship_qty" name="packinglist_ship_qty" autofocus placeholder="Ship Qty">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Size :</label>
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="10%" class="text-center align-middle">Size</th>
                                    <th width="10%" class="text-center align-middle">Style</th>
                                    <th width="10%" class="text-center align-middle">Qty Order</th>
                                    <th width="10%" class="text-center align-middle">Qty Per Carton</th>
                                    <th width="10%" class="text-center align-middle">Carton</th>
                                    <th width="10%" class="text-center align-middle">Amount</th>
                                    <th width="10%" class="text-center align-middle">Action</th>
                                </tr>
                            </table>
                            <table class="table table-bordered" id="dynamic_field">
                                <tr>
                                    <td class="text-center align-middle" colspan="3">Please Select PO No.</td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small></small>
                                <button type="button" name="add" id="add" class="btn btn-success btn-sm" href="javascript:void(0);" onclick="addSize();">Add Size</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Amount :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_amount" name="packinglist_amount" autofocus placeholder="Packing List Amount">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url('index.php/packinglist'); ?>" class="btn btn-secondary">Close</a>
                    <button type="submit" class="btn btn-primary">Add Packing List</button>
                </div>
            </div>
        </div>
    </div>
</form>

</section>
</div>
<?= $this->endSection(); ?>