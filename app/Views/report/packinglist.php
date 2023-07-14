<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
    .table-wrapper {
        border: 1px solid #ced4da;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    #packinglist_carton_table th,
    #packinglist_carton_table td {
        vertical-align: middle !important;
    }
</style>
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
                        <td><?= $packinglist->gl_number ?></td>
                        <td colspan="2" class="text-bold">Buyer PO:</td>
                        <td><?= $packinglist->po_no ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Buyer:</td>
                        <td colspan="4"><?= $packinglist->buyer_name ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Style:</td>
                        <td><?= $packinglist->style_no ?></td>
                        <td colspan="2" class="text-bold">Description:</td>
                        <td><?= $packinglist->style_description ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Order Qty:</td>
                        <td><?= $packinglist->po_qty ?></td>
                        <td colspan="2" class="text-bold">Destination:</td>
                        <td><?= $packinglist->destination ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Cut Qty:</td>
                        <td><?= $packinglist->packinglist_cutting_qty ?></td>
                        <td colspan="2" class="text-bold">Customer Code:</td>
                        <td> xxxxx </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Ship Qty:</td>
                        <td><?= $packinglist->packinglist_ship_qty ?></td>
                        <td colspan="2" class="text-bold">Department:</td>
                        <td> <?= esc($packinglist->department); ?> </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Total Carton:</td>
                        <td> <?= esc($packinglist->total_carton); ?> </td>
                        <td colspan="2" class="text-bold">Ship Date:</td>
                        <td><?= esc($packinglist->shipdate); ?></td>
                        
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Total Pieces:</td>
                        <td> <?= esc($packinglist->packinglist_qty); ?> </td>
                        <td colspan="2" class="text-bold">Contract Qty:</td>
                        <td><?= esc($packinglist->contract_qty); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Percentage Ship:</td>
                        <td> <?= esc($packinglist->percentage_ship); ?> </td>
                        <td colspan="3" rowspan="2" class="text-bold">Remarks:</td>
                    </tr>
                </table>
                <table class="table table-bordered" id="packinglist_carton_table">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="1" colspan="2">Carton Number</th>
                            <th rowspan="2" colspan="1">ASIN</th>
                            <th rowspan="2" colspan="1">PID/UPC</th>
                            <th rowspan="2" colspan="1">Colour Code/Name</th>
                            <th rowspan="<?= $size_rowspan ?>" colspan="<?= $size_colspan; ?>">Size</th>
                            <th rowspan="2" colspan="1">Total (Pcs)</th>
                            <!-- <th rowspan="2" colspan="1">Contract Qty</th> -->
                            <!-- <th rowspan="2" colspan="1">Cut Qty</th> -->
                            <th rowspan="2" colspan="1">Total CTN</th>
                            <th rowspan="2" colspan="1">Ship Qty</th>
                            <th rowspan="2" colspan="1">G.W. (Kgs)</th>
                            <th rowspan="2" colspan="1">N.W. (Kgs)</th>
                            <th rowspan="2" colspan="1">Measurement CTN</th>
                            <th rowspan="2" colspan="1">+/-</th>
                        </tr>
                        <tr class="text-center">
                            <th>From</th>
                            <th>To</th>
                            <?php foreach ($packinglist_size_list as $key => $size) { ?>
                                <th><?= $size->size ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($packinglist_carton as $key => $carton) { ?>
                            <tr class="text-center">
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->carton_number_from ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->carton_number_to ?> </td>
                                <?php foreach ($carton->products_in_carton as $key_product => $product) { ?>
                                    <?php if ($key_product == 0) { ?>
                                        <td> <?= $carton->products_in_carton[$key_product]->product_asin_id ?> </td>
                                        <td> <?= $carton->products_in_carton[$key_product]->product_code ?> </td>
                                        <td> <?= $carton->products_in_carton[$key_product]->colour ?> </td>
                                        <?php foreach ($product->ratio_by_size_list as $key_size => $size) : ?>
                                            <td> <?= $size->size_qty ?> </td>
                                        <?php endforeach ?>
                                    <?php } ?>
                                <?php } ?>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->pcs_per_carton ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->carton_qty ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->ship_qty ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->gross_weight ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->net_weight ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> xxxxx </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> xxxxx </td>
                            </tr>
                            <?php if ($carton->number_of_product_per_carton > 1) :  ?>
                                <?php foreach ($carton->products_in_carton as $key_product => $product) : ?>
                                    <?php if ($key_product > 0) : ?>
                                        <tr class="text-center">
                                            <td> <?= $carton->products_in_carton[$key_product]->product_code ?> </td>
                                            <td> <?= $carton->products_in_carton[$key_product]->colour ?> </td>
                                            <?php foreach ($product->ratio_by_size_list as $key_size => $size) { ?>
                                                <td> <?= $size->size_qty ?> </td>
                                            <?php } ?>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        <?php } ?>
                    </tbody>
                    <tfoot class="footer">
                        <tr class="text-center">
                            <td colspan="<?= 5 + $size_colspan + 1; ?>" class="text-right">Total : </td>
                            <td colspan=""><?= $packinglist_carton_total->total_carton ?></td>
                            <td colspan=""><?= $packinglist_carton_total->total_ship ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.section -->
</div>

<?= $this->endSection(); ?>