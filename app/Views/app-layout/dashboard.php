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

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h1><?= $msg1; ?></h1>
                <h2><?= $msg2; ?></h2>
                <h5><?= $msg3; ?></h5>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="row">
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center align-middle" scope="col">1</td>
                                    <td class="text-left align-middle" scope="col">Amazon</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle" scope="col">2</td>
                                    <td class="text-left align-middle" scope="col">Aeropostale</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle" scope="col">3</td>
                                    <td class="text-left align-middle" scope="col">Chicos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
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
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection('content'); ?>