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
        font-weight: bold;
        font-size: 12px;
    }


    .table-section {
        margin-bottom: 20px;
    }

    /* #inspection_information {
        border:none;
    } */
    #inspection_information th,
    #inspection_information td {
        text-align:left;
        border: none !important;
    }

    .information-title {
        width:100px;
    }

    #inspection_detail thead,
    #inspection_detail tfoot {
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

            <table id="inspection_information" class="table-section">
                <thead>
                    <tr>
                        <th class="text-bold information-title">Buyer PO</th>
                        <th> : <?= $carton_inspection->po_number ?></th>
                        <th class="text-bold information-title">Issued By</th>
                        <th> : <?= $carton_inspection->issued_by ?></th>
                    </tr>
                    <tr>
                        <th class="text-bold information-title">Buyer</th>
                        <th> : <?= $carton_inspection->buyer_name ?></th>
                        <th class="text-bold information-title">Received By</th>
                        <th> : <?= $carton_inspection->received_by ?></th>
                    </tr>
                    <tr>
                        <th class="text-bold information-title">GL Number</th>
                        <th> : <?= $carton_inspection->gl_number ?></th>
                        <th class="text-bold information-title">Issued Date</th>
                        <th> : <?= $carton_inspection->issued_date ?></th>

                    </tr>
                </thead>
            </table>

            <h3 class="">Carton List :</h3>
            <table id="inspection_detail" class="table-section">
                <thead>
                    <tr>
                        <th>No. </th>
                        <th>Carton No.</th>
                        <th>Carton Barcode</th>
                        <th>Size</th>
                        <th>Total pcs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carton_inspection_detail as $key => $carton) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $carton->carton_number ?></td>
                            <td><?= $carton->carton_barcode ?></td>
                            <td><?= $carton->size_list ?></td>
                            <td><?= $carton->total_pcs ?></td>
                            <!-- <td>S = 1 | L = 4</td> -->
                        </tr>
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