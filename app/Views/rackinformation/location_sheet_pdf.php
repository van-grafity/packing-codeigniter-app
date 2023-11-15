<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>

        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script> -->

        <style type="text/css">
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
                font-family: sans-serif;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 2cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 3cm;
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

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
            }

            .table-wrapper {
                border-radius: 5px;

                position: relative;
                min-height: 100vh;
            }

            .iso-number {
                text-align: right;
                top: 10;
                right: 1cm;
                position: absolute;
                font-size: 7pt;
            }
            .company-name {
                text-align: left;
                top: 10;
                left: 1cm;
                position: absolute;
                font-size: 12pt;
            }

            .date-printed {
                text-align: right;
                bottom: 10;
                right: 1cm;
                position: absolute;
                font-size: 7pt;
            }

            .form-name {
                margin-top: 1cm;
                text-align: center;
                font-size: 14pt;
                font-weight: bold;
            }

            .assignment-section {
                margin-top: 20px;
                margin-bottom: 3rem;
                font-weight: bold;
            }

            .assignment-section td {
                border: 0px;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <div class="company-name">PT. GHIM LI INDONESIA</div>
            <div class="iso-number">
                <div>RP-GLA-SHP-007</div>
                <i>Rev 0</i>
            </div>
            <div class="form-name">Rack Location Sheet</div>
        </header>

        <footer>
            <div class="assignment-section">
                <table class="">
                    <tbody>
                        <tr>
                            <td>Prepared By </td>
                            <td>Acknowledge by</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="date-printed">
                Date Printed: <?= $date_printed ?>
            </div>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div class="table-wrapper">
                <div class="content-wrap">
                    <div class="rack_location_table_wrapper">
                        <table id="rack_location_table_wrapper">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>GL NO.</th>
                                    <th>PO NO.</th>
                                    <th>COLOUR</th>
                                    <th>BUYER</th>
                                    <th>QTY CTN</th>
                                    <th>QTY PCS</th>
                                    <th>RACK</th>
                                    <th>LEVEL RACK</th>
                                    <th style="display:none">TRANSFER NOTE</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($rack_list as $key => $rack) : ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $rack->gl_number ?></td>
                                    <td><?= $rack->po_no ?></td>
                                    <td><?= $rack->colour ?></td>
                                    <td><?= $rack->buyer_name ?></td>
                                    <td><?= $rack->total_carton ?></td>
                                    <td><?= $rack->total_pcs ?></td>
                                    <td><?= $rack->serial_number ?></td>
                                    <td><?= $rack->level ?></td>
                                    <td style="display:none"><?= $rack->transfer_note ?></td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </body>
</html>
