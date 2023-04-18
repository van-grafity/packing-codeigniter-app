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
                            <h3><?= $title ?></h3>
                            <table>
                                <table width="100%">
                                    <tr>
                                        <td width="20%">Order No.</td>
                                        <td width="16%"><?= esc($pl['packinglist_date']); ?></td>
                                        <td width="16%">Measurements</td>
                                        <td>Below</td>
                                    </tr>
                                    <tr>
                                        <td>Buyer</td>
                                        <td>AMAZON"PRESSENTIAL"</td>
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
                                        <td>395</td>
                                        <td>Description</td>
                                        <td>Amazon Essential Disnay | Marvel | Star Wars | Frozen | Princess</td>
                                    </tr>
                                    <tr>
                                        <td>Cut Qty.</td>
                                        <td>395</td>
                                        <td>Destination</td>
                                        <td>LGB1 - Long Beach, CA</td>
                                    </tr>
                                    <tr>
                                        <td>Ship Qty.</td>
                                        <td>395</td>
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

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Carton No.</th>
                                        <th>Carton Qty.</th>
                                        <th>Carton Size</th>
                                        <th>Carton Weight</th>
                                        <th>Carton Volume</th>
                                        <th>Carton Type</th>
                                        <th>Carton Color</th>
                                        <th>Carton Label</th>
                                        <th>Carton Barcode</th>
                                        <th>Carton Remark</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-footer">
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1>BARIS 1</h1>
                            <h2>Baris 2</h2>
                            <h5>Baris 3</h5>
                        </div>
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