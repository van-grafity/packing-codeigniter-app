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
                <table class="table table-bordered mb-2">
                    <tr class="table-primary text-center">
                        <h2 colspan="15" class="text-center">PT. GHIM LI INDONESIA</h2>
                        <h4 colspan="15" class="text-center">Tunas Industrial Estate Block 3A - 3D</h4>
                        <h5 colspan="15" class="text-center">Batam Center - Indonesia</h5><br>
                        <h3 colspan="15" class="text-center">Factory Packing List</h3>
                    </tr>
                    <tr>
                        <td colspan="3">GL Number:</td>
                        <td></td>
                        <td colspan="3">Buyer PO:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">Buyer:</td>
                        <td></td>
                        <td colspan="3">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">Style:</td>
                        <td></td>
                        <td colspan="3">:</td>
                        <td></td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">Carton Number</th>
                            <th rowspan="2" class="text-center align-middle">UPC</th>
                            <th rowspan="2" class="text-center align-middle">Colour Code/Name</th>
                            <th colspan="4" class="text-center align-middle">Size</th>
                            <th rowspan="2" class="text-center align-middle">Total (Pcs)</th>
                            <th rowspan="2" class="text-center align-middle">Cont Qty</th>
                            <th rowspan="2" class="text-center align-middle">Cut Qty</th>
                            <th rowspan="2" class="text-center align-middle">Ship Qty</th>
                            <th rowspan="2" class="text-center align-middle">Total CTN</th>
                            <th rowspan="2" class="text-center align-middle">G.W. (LBS)</th>
                            <th rowspan="2" class="text-center align-middle">N.W. (LBS)</th>
                        </tr>
                        <tr>
                            <td>From</td>
                            <td>To</td>
                            <td>XS</td>
                            <td>X</td>
                            <td>M</td>
                            <td>L</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
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