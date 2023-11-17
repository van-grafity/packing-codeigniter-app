<?= $this->extend('app-layout/template'); ?>

<?= $this->section('content'); ?>
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
                <h1 class='text-center'><?= $msg1; ?></h1>
                <h2 class='text-center'><?= $msg2; ?></h2>
                <h5 class='text-center'><?= $msg3; ?></h5>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- First Row -->
        <div class="row">
            <!-- List of Buyer -->
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0 card-title">List of Buyer</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="table-primary">
                                    <th width="15%" class="text-center align-middle" scope="col">SN</th>
                                    <th class="text-left align-left" scope="col">Buyer Name</th>
                                    <th class="text-left align-left" scope="col">Country</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($buyer as $b) : ?>
                                    <tr>
                                        <th class="text-center" scope="row"><?= $i++; ?></th>
                                        <td><?= $b->buyer_name; ?></td>
                                        <td><?= $b->country; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.card -->
            </div>
            <!-- /.List of Buyer -->

            <!-- List of PO -->
            <div class="col-lg-6">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h5 class="m-0 card-title">List of Product</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="table-primary">
                                    <th width="15%" class="text-center align-middle" scope="col">SN</th>
                                    <th class="text-center align-middle" scope="col">Product Code</th>
                                    <th class="text-center align-middle" scope="col">Category</th>
                                    <th class="text-center align-middle" scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($product as $p) : ?>
                                    <tr>
                                        <th class="text-center" scope="row"><?= $i++; ?></th>
                                        <td><?= $p->product_code; ?></td>
                                        <td><?= $p->category_name; ?></td>
                                        <td><?= $p->product_price; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.List of PO -->
        </div>
        <!-- /.First Row -->

        <!-- Second Row -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h5 class="m-0 card-title">List of PO</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="table-primary">
                                    <th width="15%" class="text-center align-middle" scope="col">SN</th>
                                    <th class="text-center align-middle" scope="col">Buyer</th>
                                    <th class="text-center align-middle" scope="col">Total PO</th>
                                    <th class="text-center align-middle" scope="col">Total Carton</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center align-middle" scope="col">1</td>
                                    <td class="text-left align-middle" scope="col">Amazon</td>
                                    <td class="text-center align-middle" scope="col">15</td>
                                    <td class="text-center align-middle" scope="col">1000</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle" scope="col">2</td>
                                    <td class="text-left align-middle" scope="col">Aeropostale</td>
                                    <td class="text-center align-middle" scope="col">20</td>
                                    <td class="text-center align-middle" scope="col">2700</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle" scope="col">3</td>
                                    <td class="text-left align-middle" scope="col">Chicos</td>
                                    <td class="text-center align-middle" scope="col">7</td>
                                    <td class="text-center align-middle" scope="col">3000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.List of Product -->
        </div>
        <!-- /.Second Row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection('content'); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);
</script>
<?= $this->endSection('page_script'); ?>