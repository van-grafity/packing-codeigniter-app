<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
    </section>

     <section class="content">
        <div class="container-fluid">
            <h1 class="mt-4"><i class="fas fa-server"></i> Purchase Order</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('index.php/home'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>
            <!-- button Create -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <a data-toggle="modal" data-target="#createModal" class="btn btn-secondary mb-2" href="#"><i class="fas fa-plus"></i> Add New</a>
                            <a href="<?= base_url('index.php/purchaseorder/import'); ?>" class="btn btn-success mb-3"><i class="fas fa-file-import"></i> Import</a>
                            <a href="<?= base_url('index.php/purchaseorder/export'); ?>" class="btn btn-warning mb-3"><i class="fas fa-file-export"></i> Export</a>
                            <a href="<?= base_url('index.php/purchaseorder/print'); ?>" class="btn btn-info mb-3"><i class="fas fa-print"></i> Print</a>
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>PO No.</th>
                                        <th>GL No.</th>
                                        <th>Factory</th>
                                        <th>Ship Date</th>
                                        <th>Unit Price</th>
                                        <th>PO Qty</th>
                                        <th>PO Amount</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($buyerPO as $po) : ?>
                                        <tr>
                                        <td><a href="<?= base_url('index.php/purchaseorder/' . $po['PO_No']); ?>"><?= esc($po['PO_No']); ?></a></td>
                                            <td><?= esc($po['gl_number']); ?></td>
                                            <td><?= esc($po['factory_name']); ?></td>
                                            <td><?= esc($po['shipdate']); ?></td>
                                            <td><?= esc($po['unit_price']); ?></td>
                                            <td><?= esc($po['PO_qty']); ?></td>
                                            <td><?= esc(number_to_currency($po['PO_amount'], 'IDR')); ?></td>
                                            <td><?= esc($po['created_at']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Create -->
<form action="<?= base_url('index.php/purchaseorder/store'); ?>" method="post">
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Purchase Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="PO_No">PO No.</label>
                        <input type="text" class="form-control" id="PO_No" name="PO_No" placeholder="PO No.">
                    </div>

                    <div class="form-group">
                        <label for="id">GL No.</label>
                        <select class="form-control" id="id" name="id">
                            <option value="">-- Select GL No. --</option>
                            <?php foreach ($gl as $g) : ?>
                                <option value="<?= $g['id']; ?>"><?= $g['gl_number']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="id">Factory</label>
                        <select class="form-control" id="id" name="id">
                            <option value="">-- Select Factory --</option>
                            <?php foreach ($factory as $f) : ?>
                                <option value="<?= $f['id']; ?>"><?= $f['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="shipdate">Ship Date</label>
                        <input type="date" class="form-control" id="shipdate" name="shipdate" placeholder="Ship Date">
                    </div>

                    <div class="form-group">
                        <label for="unit_price">Unit Price</label>
                        <input type="text" class="form-control" id="unit_price" name="unit_price" placeholder="Unit Price">
                    </div>

                    <div class="form-group">
                        <label for="PO_qty">PO Qty</label>
                        <input type="text" class="form-control" id="PO_qty" name="PO_qty" placeholder="PO Qty">
                    </div>

                    <div class="form-group">
                        <label for="PO_amount">PO Amount</label>
                        <input type="text" class="form-control" id="PO_amount" name="PO_amount" placeholder="PO Amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Purchase Order</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection(); ?>