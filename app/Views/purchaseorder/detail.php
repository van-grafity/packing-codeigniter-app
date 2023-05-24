<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="row">
                    <table>
                        <tr>
                            <td width=20%><b>Buyer Name :</b></td>
                            <td></td>
                            <td width=20%><b>GL Number</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Total Qty :</b></td>
                            <td></td>
                            <td><b>Size Order</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>PO Amount :</b></td>
                            <td><?= number_to_currency(1, 'USD', 'en_USD', 2); ?></td>
                        </tr>
                        <tr>
                            <td><b>Required Ship Date :</b></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class=" row">
                <div class="col-12 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- <div class="tab-content" id="custom-tabs-three-tabContent"> -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center align-middle">Product No.</th>
                                            <th class="text-center align-middle">Style</th>
                                            <th class="text-center align-middle">Size</th>
                                            <th class="text-center align-middle">Unit Price</th>
                                            <th class="text-center align-middle">Qty Ordered</th>
                                            <th class="text-center align-middle">Total Amount</th>
                                            <th class="text-center align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center">
                                                <a class="btn btn-warning btn-sm btn-edit">Edit</a>
                                                <a class="btn btn-danger btn-sm btn-delete">Delete</a>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" card-footer">
            <div class="row">
                <div class="col-12">
                    <a href="../index.php/purchaseorder" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </section>
</div>

<style type="text/css">
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
        font-size: 18px;
    }
</style>
<?= $this->endSection(); ?>