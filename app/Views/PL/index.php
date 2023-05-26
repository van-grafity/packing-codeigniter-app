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
                    <div class="form-group">
                        <label for="PL_No">Packing List No :</label>
                        <input type="text" class="form-control" id="packinglist_no" name="packinglist_no" placeholder="Packing List No" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="PL_Date">Packing List Date :</label>
                        <input type="date" class="form-control" id="packinglist_date" name="packinglist_date" placeholder="Packing List Date" value="<?= date('Y-m-d'); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="po_No">PO No :</label>
                        <select id="po_No" name="po_no" class="form-control">
                            <option value="">-Select PO No -</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order_qty">Order Qty :</label>
                        <input type="text" disabled class="form-control" id="order_qty" name="order_qty" placeholder="Order Qty">
                    </div>
                    <div class="form-group">
                        <label for="name">Ship Qty :</label>
                        <input type="text" class="form-control" id="ship_qty" name="ship_qty" placeholder="116">
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered" id="item_table">
                            <thead>
                                <tr>
                                    <th>Product No</th>
                                    <th>Style</th>
                                    <th width="10%">Size</th>
                                    <th>Qty/Carton</th>
                                    <th>Carton</th>
                                    <th>Qty Ship</th>
                                    <th>GW</th>
                                    <th>NW</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control" type="text">
                                            <option value="">195111263922</option>
                                        </select>
                                    </td>
                                    <td><input type="text" value="AE-M-FW20-SHR-127" class="form-control"></td>
                                    <td>S</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select class="form-control" type="text">
                                            <option value="">195111263939</option>
                                        </select>
                                    </td>
                                    <td><input type="text" value="AE-M-FW20-SHR-127" class="form-control"></td>
                                    <td>M</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>100</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select class="form-control" type="text">
                                            <option value="">195111263946</option>
                                        </select>
                                    </td>
                                    <td><input type="text" value="AE-M-FW20-SHR-127" class="form-control"></td>
                                    <td>L</td>
                                    <td>20</td>
                                    <td>13</td>
                                    <td>260</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select class="form-control" type="text">
                                            <option value="">195111263939</option>
                                        </select>
                                    </td>
                                    <td><input type="text" value="AE-M-FW20-SHR-127" class="form-control"></td>
                                    <td>M</td>
                                    <td>16</td>
                                    <td>1</td>
                                    <td>16</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select class="form-control" type="text">
                                            <option value="">195111263946</option>
                                        </select>
                                    </td>
                                    <td><input type="text" value="AE-M-FW20-SHR-127" class="form-control"></td>
                                    <td>L</td>
                                    <td>9</td>
                                    <td>1</td>
                                    <td>9</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small></small>
                        <button type="button" name="add" id="add" class="btn btn-success btn-sm" href="javascript:void(0);" onclick="addSize();">Add Row</button>
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
<?= $this->endSection(); ?>