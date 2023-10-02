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
        font-family: sans-serif;

        position: relative;
        min-height: 100vh;

    }

    .iso-number {
        text-align: right;
        top: -20;
        right: 2;
        position: absolute;
        font-size: 7pt;
        display: none;
    }

    .date-printed {
        text-align: right;
        top: 2;
        right: 2;
        position: absolute;
        font-size: 7pt;
    }

    .company-section {
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
        font-weight: bold;
        font-size: 12px;
    }


    .table-section {
        margin-bottom: 20px;
    }

    #transfer_note_information th,
    #transfer_note_information td {
        text-align:left;
        border: none !important;
    }

    .information-title {
        width:100px;
    }

    #transfer_note_detail thead,
    #transfer_note_detail tfoot {
        background-color: #ddd;
    }

    .assignment-section {
        font-family: sans-serif;
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
            <table class="company-section table-section">
                <thead>
                    <tr class="">
                        <td>
                            <div class="company-name">PT. GHIM LI INDONESIA</div>
                            <div class="company-address">Tunas Industrial Estate Block 3A - 3D</div>
                            <div class="company-address">Batam Center - Indonesia</div>
                            <div class="form-name">Carton Inspection Transfer Note</div>
                        </td>
                    </tr>
                </thead>
            </table>

            <table id="transfer_note_information" class="table-section">
                <thead>
                    <tr>
                        <th class="text-bold information-title">SN</th>
                        <th> : <?= $transfer_note->transfer_note_number ?></th>
                    </tr>
                    <tr>
                        <th class="text-bold information-title">Pallet No.</th>
                        <th> : <?= $transfer_note->pallet_number ?></th>
                        <th class="text-bold information-title">From</th>
                        <th> : <?= $transfer_note->location_from ?></th>
                    </tr>
                    <tr>
                        <th class="text-bold information-title">Issued Date</th>
                        <th> : <?= $transfer_note->issued_date ?></th>
                        <th class="text-bold information-title">To</th>
                        <th> : <?= $transfer_note->location_to ?></th>
                    </tr>
                </thead>
            </table>

            <table id="transfer_note_detail" class="table-section">
                <thead>
                    <tr>
                        <th rowspan="2" colspan="1">PO</th>
                        <th rowspan="2" colspan="1">Buyer</th>
                        <th rowspan="2" colspan="1">GL</th>
                        <th rowspan="1" colspan="3">Carton Content</th>
                        <th rowspan="2" colspan="1">Qty/Carton</th>
                        <th rowspan="2" colspan="1">Total Carton</th>
                        <th rowspan="2" colspan="1">Total Pieces</th>
                    </tr>
                    <tr>
                        <th rowspan="1" >Color</th>
                        <th rowspan="1" >Size</th>
                        <th rowspan="1" >Qty</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($transfer_note_detail as $key_transfer_note => $detail) { ?>
                        <tr>
                            <td rowspan="<?= $detail->total_detail?>" ><?= $detail->po_number ?></td>
                            <td rowspan="<?= $detail->total_detail?>" ><?= $detail->buyer_name ?></td>
                            <td rowspan="<?= $detail->total_detail?>" ><?= $detail->gl_number ?></td>
                            <?php if ($key_transfer_note <= 0) { ?>
                                <td><?= $detail->carton_content[$key_transfer_note]->colour ?></td>
                                <td><?= $detail->carton_content[$key_transfer_note]->size ?></td>
                                <td><?= $detail->carton_content[$key_transfer_note]->qty ?></td>
                            <?php }?>
                            <td rowspan="<?= $detail->total_detail?>" ><?= $detail->qty_each_carton ?></td>
                            <td rowspan="<?= $detail->total_detail?>" ><?= $detail->total_carton ?></td>
                            <td rowspan="<?= $detail->total_detail?>" ><?= $detail->total_pcs ?></td>
                        </tr>
                        <?php foreach ($detail->carton_content as $key_detail => $product) { ?>
                            <?php if ($key_detail > 0) { ?>
                                <tr>
                                    <td><?= $detail->carton_content[$key_detail]->colour ?></td>
                                    <td><?= $detail->carton_content[$key_detail]->size ?></td>
                                    <td><?= $detail->carton_content[$key_detail]->qty ?></td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="assignment-section">
        <table class="">
            <tbody>
                <tr>
                    <td>Issued By </td>
                    <td>Authorised By</td>
                    <td>Received By</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>