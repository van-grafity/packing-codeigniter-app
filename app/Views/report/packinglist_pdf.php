<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

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
        border-spacing: 0px;
        font-weight: Normal;
    }

    table tr {
        text-align: center;
    }

    table tr td,
    table tr th {
        font-size: 8pt;
        padding: 3px 5px;
        border: .1px solid #858a8f;
    }

    .text-left {
        text-align: left;
    }

    .table-wrapper {
        border-radius: 5px;
        /* margin-bottom: 10px; */
        font-family: sans-serif;

        position: relative;
        min-height: 100vh;

        /* margin-bottom: 20px; */
    }

    .iso-number {
        text-align: right;
        top: -20;
        right: 2;
        position: absolute;
        font-size: 7pt;
    }

    .date-printed {
        text-align: right;
        top: 2;
        right: 2;
        position: absolute;
        font-size: 7pt;
    }

    .company-section {
        /* border: 2px solid #ced4da; */
    }

    .company-section td {
        padding: 10px;
    }

    .company-name {
        font-weight: bold;
        font-size: 14px;
    }

    .company-address {
        font-size: 11px;
    }

    .form-name {
        font-size: 11px;
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
        /* Footer height */
        /* padding-bottom: 2.5rem; */
    }

    .shipment-detail-row {
        width: 100%;
        border: 0;
    }

    .shipment-detail-column {
        width: 47.5%;
        margin: 0;
        padding: 0;
        border: 0;
    }

    .column-spacer {
        width: 5%;
        margin: 0;
        padding: 0;
        border: 0;
    }

    .shipment-detail-table {
        /* width: 45%; */
        width: 100%;
        margin-top: 2rem;
    }

    .shipment-detail-table th,
    .shipment-detail-table td {
        font-size: 7pt;
    }

    .shipment-detail-table th {
        background-color: #ddd;
        padding: 5px;
    }

    th.shipment-detail-title {
        font-size: 11px;
    }

    /* .assignment-section {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 2.5rem;
        } */

    .assignment-section {
        font-family : sans-serif;
        margin-top: 30px;
        margin-bottom: 3rem;
        font-weight: bold;
    }

    .assignment-section td {
        border: 0px;
    }

    .page-break {
        page-break-before: always !important;
    }
    </style>
</head>

<body>
    <div class="table-wrapper">
        <div class="iso-number">
            <div>FM-GLA-PAC-002</div>
            <i>Rev 0</i>
        </div>
        <div class="date-printed">
            Date Printed: <?= $date_printed ?>
        </div>
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
                        <td> - </td>
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
                        <td> <?= esc($packinglist->packinglist_cutting_qty); ?> </td>
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
                        <th rowspan="2" colspan="1" style="<?= $asin_style ?>">ASIN</th>
                        <th rowspan="2" colspan="1">PID/UPC</th>
                        <th rowspan="2" colspan="1">Colour Code/Name</th>
                        <th rowspan="<?= $size_rowspan ?>" colspan="<?= $size_colspan; ?>">Size</th>
                        <th rowspan="2" colspan="1">Total (Pcs)</th>
                        <th rowspan="2" colspan="1">Total CTN</th>
                        <th rowspan="2" colspan="1">Ship Qty</th>
                        <th rowspan="2" colspan="1">G.W. (LBS)</th>
                        <th rowspan="2" colspan="1">N.W. (LBS)</th>
                        <th rowspan="2" colspan="1">G.W. (KG)</th>
                        <th rowspan="2" colspan="1">N.W. (KG)</th>
                        <th rowspan="2" colspan="1">Measurement CTN</th>
                    </tr>
                    <tr class="text-center">
                        <th>From</th>
                        <th>To</th>
                        <?php foreach ($packinglist_size_list as $key => $size) { ?>
                            <th style="width:30px;"><?= $size->size ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $count_tr_page = 0;?>
                    <?php $estimate_tr = 0;?>

                    <?php $is_first_page = true;?>
                    <?php $max_tr_first_page = 16;?>
                    <?php $max_tr_first_page = ($size_colspan <= 5) ? 16 : 12;?>
                    <?php $max_tr_next_page = 28;?>
                    <?php $max_tr_page = $max_tr_first_page;?>
                    <?php foreach ($packinglist_carton as $key => $carton) { ?>
                    <tr class="text-center">
                        <td class="" rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->carton_number_from ?></td>
                        <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->carton_number_to ?> </td>
                        <?php foreach ($carton->products_in_carton as $key_product => $product) { ?>
                            <?php if ($key_product == 0) { ?>
                                <td style="<?= $asin_style ?>"> <?= $carton->products_in_carton[$key_product]->product_asin_id ?> </td>
                                <td> <?= $carton->products_in_carton[$key_product]->product_code ?> </td>
                                <td style="font-size:7pt;"> <?= $carton->products_in_carton[$key_product]->colour ?> </td>
                                <?php foreach ($product->ratio_by_size_list as $key_size => $size) : ?>
                                    <td> <?= $size->size_qty ?> </td>
                                <?php endforeach ?>
                            <?php } ?>
                        <?php } ?>
                        <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->pcs_per_carton ?> </td>
                        <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->carton_qty ?> </td>
                        <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->ship_qty ?> </td>
                        <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->gross_weight_lbs ?> </td>
                        <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->net_weight_lbs ?> </td>
                        <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->gross_weight ?> </td>
                        <td rowspan="<?= $carton->number_of_product_per_carton; ?>"> <?= $carton->net_weight ?> </td>
                        <td rowspan="<?= $carton->number_of_product_per_carton; ?>" style="font-size:7pt;"> <?= $carton->measurement_ctn ?> </td>
                    </tr>
                    <?php $count_tr_page++;?>

                    <?php if ($carton->number_of_product_per_carton > 1) :  ?>
                        <?php foreach ($carton->products_in_carton as $key_product => $product) : ?>
                            <?php if ($key_product > 0) : ?>

                                <tr class="text-center">
                                    <td style="<?= $asin_style ?>"> <?= $carton->products_in_carton[$key_product]->product_asin_id ?> </td>
                                    <td> <?= $carton->products_in_carton[$key_product]->product_code ?> </td>
                                    <td style="font-size:7pt;"> <?= $carton->products_in_carton[$key_product]->colour ?> </td>
                                    <?php foreach ($product->ratio_by_size_list as $key_size => $size) { ?>
                                        <td> <?= $size->size_qty ?> </td>
                                    <?php } ?>
                                </tr>
                                <?php $count_tr_page++;?>

                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>

                    <?php 
                        $estimate_tr = $count_tr_page + $carton->number_of_product_per_carton;
                        if($estimate_tr > $max_tr_page && $is_first_page ) { ?>
                            <div class="page-break"></div>
                            <?php 
                                $is_first_page = false;
                                $max_tr_page = $max_tr_next_page;
                                $count_tr_page = 0;
                        } elseif($estimate_tr > $max_tr_page) {
                            $count_tr_page = 0; ?>
                            <div class="page-break"></div>
                            <?php
                        }
                    } ?>

                </tbody>
                <tfoot class="footer">
                    <tr class="text-center">
                        <th colspan="<?= 4 + $size_colspan + 1; ?>" class="text-right">Total : </th>
                        <th colspan=""><?= $packinglist_carton_total->total_carton ?></th>
                        <th colspan=""><?= $packinglist_carton_total->total_ship ?></th>
                        <th colspan="6"></th>
                    </tr>
                </tfoot>
            </table>

            <table class="shipment-detail-row">
                <tbody>
                    <tr>
                        <td class="shipment-detail-column">
                            <table class="shipment-detail-table">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="shipment-detail-title">Shipment Detail per UPC</th>
                                    </tr>
                                    <tr>
                                        <th>UPC</th>
                                        <th>Colour</th>
                                        <th>Size</th>
                                        <th>Ship Qty</th>
                                        <th>PO Qty</th>
                                        <th>Ship Percentage / UPC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($shipment_percentage_each_upc_part1 as $key => $product) { ?>
                                    <tr>
                                        <td><?= $product->upc ?></td>
                                        <td><?= $product->colour ?></td>
                                        <td><?= $product->size ?></td>
                                        <td><?= $product->shipment_qty ?></td>
                                        <td><?= $product->po_qty ?></td>
                                        <td><?= $product->percentage ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </td>
                        <td class="column-spacer"></td>
                        <td class="shipment-detail-column">
                            <?php if(count($shipment_percentage_each_upc_part2) > 0) :?>
                            <table class="shipment-detail-table">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="shipment-detail-title">Shipment Detail per UPC</th>
                                    </tr>
                                    <tr>
                                        <th>UPC</th>
                                        <th>Colour</th>
                                        <th>Size</th>
                                        <th>Ship Qty</th>
                                        <th>PO Qty</th>
                                        <th>Ship Percentage / UPC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($shipment_percentage_each_upc_part2 as $key => $product) { ?>
                                    <tr>
                                        <td><?= $product->upc ?></td>
                                        <td><?= $product->colour ?></td>
                                        <td><?= $product->size ?></td>
                                        <td><?= $product->shipment_qty ?></td>
                                        <td><?= $product->po_qty ?></td>
                                        <td><?= $product->percentage ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php endif ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="assignment-section">
        <table class="">
            <tbody>
                <tr>
                    <td>Prepared By </td>
                    <td>Packing Supervisor</td>
                    <td>Asst Manager</td>
                    <td>Prod Manager</td>
                    <td>Asst GM (Production)</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>