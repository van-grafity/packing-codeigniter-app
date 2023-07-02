<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card card-primary">
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered mb-2">
                    <tr class="table-primary text-center">
                        <h2 colspan="15" class="text-center">PT. GHIM LI INDONESIA</h2>
                        <h4 colspan="15" class="text-center">Tunas Industrial Estate Block 3A - 3D</h4>
                        <h5 colspan="15" class="text-center">Batam Center - Indonesia</h5><br>
                        <h3 colspan="15" class="text-center">Factory Packing List</h3>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">GL Number:</td>
                        <td>87001-00</td>
                        <td colspan="2" class="text-bold">Buyer PO:</td>
                        <td>TJKM90812309</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Buyer:</td>
                        <td colspan="4">Batam Retails Store</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Style:</td>
                        <td>BRS-WQ087896</td>
                        <td colspan="2" class="text-bold">Description:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Order Qty:</td>
                        <td>1000 pcs</td>
                        <td colspan="2" class="text-bold">Destination:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Cut Qty:</td>
                        <td>1010 pcs</td>
                        <td colspan="2" class="text-bold">Customer Code:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Ship Qty:</td>
                        <td>1000 pcs</td>
                        <td colspan="2" class="text-bold">Department:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Total Carton:</td>
                        <td>100 ctn</td>
                        <td colspan="2" class="text-bold">Ship Date:</td>
                        <td>2023-07-01</td>

                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Total Pieces:</td>
                        <td>1000 pcs</td>
                        <td colspan="3" rowspan="2" class="text-bold">Remarks:</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Percentage Ship:</td>
                        <td>100%</td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Carton Number</th>
                                <th rowspan="2" class="text-center align-middle">ASIN</th>
                                <th rowspan="2" class="text-center align-middle">PID/UPC</th>
                                <th rowspan="2" class="text-center align-middle">Colour Code/Name</th>
                                <th colspan="3" class="text-center align-middle">Size</th>
                                <th rowspan="2" class="text-center align-middle">Total (Pcs)</th>
                                <th rowspan="2" class="text-center align-middle">Contract Qty</th>
                                <th rowspan="2" class="text-center align-middle">Cut Qty</th>
                                <th rowspan="2" class="text-center align-middle">Ship Qty</th>
                                <th rowspan="2" class="text-center align-middle">Total CTN</th>
                                <th rowspan="2" class="text-center align-middle">G.W. (Kgs)</th>
                                <th rowspan="2" class="text-center align-middle">N.W. (Kgs)</th>
                                <th rowspan="2" class="text-center align-middle">Measurement CTN</th>
                                <th rowspan="2" class="text-center align-middle">+/-</th>
                            </tr>
                            <tr>
                                <td>From</td>
                                <td>To</td>
                                <td>S</td>
                                <td>M</td>
                                <td>L</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.section -->
</div>

<?= $this->endSection(); ?>