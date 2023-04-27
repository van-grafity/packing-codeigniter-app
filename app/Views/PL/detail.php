<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
    </section>

    <!-- public function detail($packinglist_no)
    {
        $data = [
            'title' => 'Factory Packing List',
            'pl' => $this->pl->select('tblpackinglist.*, tblpurchaseorder.PO_No, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order')
                ->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->where('tblpackinglist.packinglist_no', $packinglist_no)
                ->first(),
            'plsizes' => $this->plsize->select('tblpackinglistsizes.*, tblsizes.size')
                ->join('tblsizes', 'tblsizes.id = tblpackinglistsizes.packinglistsize_size_id')
                ->where('tblpackinglistsizes.packinglistsize_pl_id', $this->pl->select('tblpackinglist.id')
                    ->where('tblpackinglist.packinglist_no', $packinglist_no)
                    ->first()['id'])
                ->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('pl/detail', $data);
    } -->

     <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3><?= $title ?></h3>
                            <table>
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
                            </table>
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
            .table {
                border-collapse: collapse;
                width: 100%;
                font-size: 14px;
                
            }

            .table,
            th,
            td {
                padding: 5px;
                font-weight: bold;
            }
        </style>
</div>
<?= $this->endSection(); ?>