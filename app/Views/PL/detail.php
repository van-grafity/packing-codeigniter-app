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
                                            <td width="20%"><b>Order No.</b></td>
                                            <td width="16%"><?= esc($pl['PO_No']); ?></td>
                                            <td><b>Master Order No.</b></td>
                                            <td><?= esc($pl['gl_number']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Buyer</b></td>
                                            <td><?= esc($pl['buyer_name']); ?></td>
                                            <td><b>Purchase Order No.</b></td>
                                            <td><?= esc($pl['PO_No']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Style No.</b></td>
                                            <td>x</td>
                                            <td><b>Description</b></td>
                                            <td><?= esc($pl['style_description']); ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><b></b></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><b>Order Qty.</b></td>
                                            <td><?= esc($pl['packinglist_qty']); ?></td>
                                            <td><b>Destination</b></td>
                                            <td><?= esc($pl['shipdate']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Cut Qty.</b></td>
                                            <td><?= esc($pl['packinglist_cutting_qty']); ?></td>
                                            <td><b>Departments</b></td>
                                            <td>x</td>
                                        </tr>
                                        <tr>
                                            <td><b>Ship Qty.</b></td>
                                            <td>290</td> <!-- esc($pl['packinglist_ship_qty']);  -->
                                            <td><b>Customer</b></td>
                                            <td>x</td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Carton</b></td>
                                            <td><?= esc($pl['packinglist_qty'] / 20); ?></td>
                                            <td><b>Ship Date</b></td>
                                            <td><?= esc($pl['shipdate']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Percentage Ship</b></td>
                                            <td>73.42%</td>
                                            <td></td>
                                            <td></td>
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
                                                    <th class="text-center align-middle">Size</th>
                                                    <th class="text-center align-middle">Qty ship</th>
                                                    <th class="text-center align-middle">Carton</th>
                                                    <th class="text-center align-middle">Amount</th>
                                                    <th class="text-center align-middle">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($plsizes as $key => $value) : ?>
                                                    <tr>
                                                        <td class="text-center align-middle"><?= $value['size']; ?></td>
                                                        <td class="text-center align-middle"><?= $value['packinglistsize_qty']; ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-right align-middle"><?= number_to_currency($value['packinglistsize_amount'], 'USD', 'en_US', 2); ?></td>
                                                        <td class="text-center align-middle">
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