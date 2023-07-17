<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factory Packing List</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <style type="text/css">
        @page {
            margin-top: 1cm;
            margin-left: 1cm;
            margin-bottom: 0cm;
        }

        body {
            height: 100%;
        }

        table {
            width: 100%;
            /* border-collapse: collapse; */
            border-spacing: 0px;
            font-weight: Normal;
        }

        table tr {
            text-align: center;
        }

        table tr td,
		table tr th {
			font-size: 9pt;
            padding: 5px 7px;
            border: .1px solid  #858a8f;
		}

        .text-left {
            text-align:left;
        }

        .table-wrapper {
            border-radius: 5px;
            margin-bottom: 10px;
            font-family: sans-serif;
            
            position: relative;
            min-height: 100vh;
        }

        .company-section {
            /* border: 2px solid #ced4da; */
        }

        .company-section td {
            padding: 10px;
        }

        .company-name {
            font-weight: bold;
            font-size: 18px;
        }

        .company-address {
            font-size: 14px;
        }

        .form-name {
            font-size: 14px;
        }

        .packinglist-info-section tr {
            text-align: left;
        }

        .packinglist-carton-section {
            margin-top: 15px;
        }

        .packinglist-carton-section thead,
        .packinglist-carton-section tfoot {
            background-color: #ddd;
        }

        .content-wrap {
            padding-bottom: 5.5rem;    /* Footer height */
        }
        .assignment-section {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 2.5rem;
        }

        .assignment-section td {
            border: 0px;
        }

        

	</style>
</head>
<body>
    <div class="table-wrapper">
        <div class="content-wrap">
            <table class="company-section">
                <thead>
                    <tr class="">
                        <td>
                            <div class="company-name">PT. GHIM LI INDONESIA</div>
                            <div class="company-address">Tunas Industrial Estate Block 3A - 3D</div>
                            <div class="company-address">Batam Center - Indonesia</div>
                            <div class="form-name">Factory Packing List</div>
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="packinglist-info-section">
                <tbody>
                    <tr>
                        <td colspan="2" class="text-bold">GL Number:</td>
                        <td><?= $packinglist->gl_number ?></td>
                        <td colspan="2" class="text-bold">Buyer PO:</td>
                        <td><?= $packinglist->po_no ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-bold">Buyer:</td>
                        <td colspan="4" class="text-left"><?= $packinglist->buyer_name ?></td>
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
                        <td colspan="3" rowspan="1" class="text-bold">Remarks:</td>
                    </tr>
                </tbody>
            </table>
            <table class="packinglist-carton-section" id="packinglist_carton_table">
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
                            <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->measurement_ctn ?> </td>
                            <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> xxxxx </td>
                        </tr>
                        <?php if ($carton->number_of_product_per_carton > 1) :  ?>
                            <?php foreach ($carton->products_in_carton as $key_product => $product) : ?>
                                <?php if ($key_product > 0) : ?>
                                    <tr class="text-center">
                                        <td> <?= $carton->products_in_carton[$key_product]->product_asin_id ?> </td>
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
                        <th colspan="<?= 5 + $size_colspan + 1; ?>" class="text-right">Total : </th>
                        <th colspan=""><?= $packinglist_carton_total->total_carton ?></th>
                        <th colspan=""><?= $packinglist_carton_total->total_ship ?></th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="assignment-section">
            <table class="">
                <tbody>
                    <tr>
                        <td>Prepared By: </td>
                        <td>Packing Supervisor</td>
                        <td>Asst Manager</td>
                        <td>Prod Manager</td>
                        <td>Asst GM (Production)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>