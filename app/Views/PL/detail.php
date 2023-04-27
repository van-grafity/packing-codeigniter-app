<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
    </section>
    
     <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h3><?= $title ?></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <br>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h4>Packing List No.</h4>
                                        </div>
                                    </div>
                                    <h1><?= esc($pl['packinglist_no']); ?></h1>
                                    <table width="100%">
                                        <tr>
                                            <td width="20%">Order No.</td>
                                            <td width="16%"><?= esc($pl['packinglist_no']); ?></td>
                                            <td width="16%">Measurements</td>
                                            <td>Below</td>
                                        </tr>
                                        <tr>
                                            <td>Buyer</td>
                                            <td><?= esc($pl['buyer_name']); ?></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Style No.</td>
                                            <td>AE-M-FW20-SHR-127</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Master Order No.</td>
                                            <td>8X8WFHBM</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Purchase Order No.</td>
                                            <td>8X8WFHBM</td>
                                        </tr>
                                        <tr>
                                            <td>Order Qty.</td>
                                            <td><?= esc($pl['packinglist_qty']); ?></td>
                                            <td>Description</td>
                                            <td>Amazon Essential Disnay | Marvel | Star Wars | Frozen | Princess</td>
                                        </tr>
                                        <tr>
                                            <td>Cut Qty.</td>
                                            <td><?= esc($pl['packinglist_cutting_qty']); ?></td>
                                            <td>Destination</td>
                                            <td>LGB1 - Long Beach, CA</td>
                                        </tr>
                                        <tr>
                                            <td>Ship Qty.</td>
                                            <td><?= esc($pl['packinglist_ship_qty']); ?></td>
                                            <td>Departments</td>
                                            <td>Row 1</td>
                                        </tr>
                                        <tr>
                                            <td>Total Carton</td>
                                            <td>21</td>
                                            <td>Customer</td>
                                            <td>Row 1</td>
                                        </tr>
                                        <tr>
                                            <td>Percentage Ship</td>
                                            <td>100.000%</td>
                                            <td>Ship Date</td>
                                            <td>16 AUG - 24 AUG 2022</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h5 class="card-title">List of Packing List Size</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>Size</th>
                                                    <th>Qty</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($plsizes as $key => $value) : ?>
                                                    <tr>
                                                        <td><?= $value['size']; ?></td>
                                                        <td><?= $value['packinglistsize_qty']; ?></td>
                                                        <td><?= $value['packinglistsize_amount']; ?></td>
                                                        <td>
                                                            <a href="<?= base_url('#' . $value['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                            <a href="<?= base_url('#' . $value['id']); ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style type="text/css">
        table {
        border-collapse: collapse;
        width: 100%;
        }
        
        th,
        td {
            text-align: left;
            padding: 8px;
            font-size: 18px;
        }
        </style>
</div>
<?= $this->endSection(); ?>