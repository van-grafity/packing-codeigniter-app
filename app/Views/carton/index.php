<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card card-primary">
            <!-- card-header -->
            <div class="card-header">
                <h3 class="card-title">Carton Barcode Setup</h3>
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
                <form class="form-horizontal">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="packinglistnumber" class="col-sm-1 col-form-label">Packing List</label>
                            <div class="col-sm-10">
                                <select class="form-control packingListNumber" style="width: 100%;">
                                    <option selected="selected">Select Packing List No</option>
                                    <option>PL-GLA-001</option>
                                    <option>PL-GLA-002</option>
                                    <option>PL-GLA-003</option>
                                    <option>PL-GLA-004</option>
                                    <option>PL-GLA-005</option>
                                    <option>PL-GLA-006</option>
                                    <option>PL-GLA-007</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="carton_number" class="col-sm-1 col-form-label">Carton No</label>
                            <div class="col-sm-10">
                                <select class="form-control packingListNumber" style="width: 100%;">
                                    <option selected="selected">Select Carton No</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="barcodenumber" class="col-sm-1 col-form-label">Barcode</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="InputBarcodeNumber" placeholder="Carton Barcode Number">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">List of Carton Barcode</h5>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="table-primary">
                                    <th class="text-center align-middle" scope="col">SN</th>
                                    <th class="text-center align-middle" scope="col">PL No</th>
                                    <th class="text-center align-middle" scope="col">PO No</th>
                                    <th class="text-center align-middle" scope="col">Carton No</th>
                                    <th class="text-center align-middle" scope="col">Carton Barcode</th>
                                </tr>
                            </thead>
                            <tr>
                                <td class="text-center align-middle" scope="col">1</td>
                                <td class="text-center align-middle" scope="col"></td>
                                <td class="text-center align-middle" scope="col">8X8WFHBM</td>
                                <td class="text-center align-middle" scope="col">1</td>
                                <td class="text-center align-middle" scope="col">909111887766</td>
                            </tr>
                            <tr>
                                <td class="text-center align-middle" scope="col">2</td>
                                <td class="text-center align-middle" scope="col"></td>
                                <td class="text-center align-middle" scope="col">8X8WFHBM</td>
                                <td class="text-center align-middle" scope="col">2</td>
                                <td class="text-center align-middle" scope="col">118111887767</td>
                            </tr>
                            <tr>
                                <td class="text-center align-middle" scope="col">3</td>
                                <td class="text-center align-middle" scope="col"></td>
                                <td class="text-center align-middle" scope="col">8X8WFHBM</td>
                                <td class="text-center align-middle" scope="col">3</td>
                                <td class="text-center align-middle" scope="col">787111887768</td>
                            </tr>
                        </table>
                    </div>
                </div><!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">List of Carton Rasio</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tr class="table-primary">
                                <th class="text-center align-middle" scope="col">SN</th>
                                <th class="text-center align-middle" scope="col">PL No</th>
                                <th class="text-center align-middle" scope="col">PO No</th>
                                <th class="text-center align-middle" scope="col">Carton No</th>
                                <th class="text-center align-middle" scope="col">XS</th>
                                <th class="text-center align-middle" scope="col">S</th>
                                <th class="text-center align-middle" scope="col">M</th>
                                <th class="text-center align-middle" scope="col">L</th>
                                <th class="text-center align-middle" scope="col">XL</th>
                            </tr>
                            <tr>
                                <td class="text-center align-middle" scope="col">1</td>
                                <th class="text-center align-middle" scope="col"></th>
                                <th class="text-center align-middle" scope="col">8X8WFHBM</th>
                                <td class="text-center align-middle" scope="col">1</td>
                                <td class="text-center align-middle" scope="col">1</td>
                                <td class="text-center align-middle" scope="col">2</td>
                                <td class="text-center align-middle" scope="col">2</td>
                                <td class="text-center align-middle" scope="col">2</td>
                                <td class="text-center align-middle" scope="col">1</td>
                            </tr>
                            <tr>
                                <td class="text-center align-middle" scope="col">2</td>
                                <th class="text-center align-middle" scope="col"></th>
                                <th class="text-center align-middle" scope="col">8X8WFHBM</th>
                                <td class="text-center align-middle" scope="col">2</td>
                                <td class="text-center align-middle" scope="col">1</td>
                                <td class="text-center align-middle" scope="col">1</td>
                                <td class="text-center align-middle" scope="col">1</td>
                                <td class="text-center align-middle" scope="col">2</td>
                                <td class="text-center align-middle" scope="col">1</td>
                            </tr>
                            <tr>
                                <td class="text-center align-middle" scope="col">3</td>
                                <th class="text-center align-middle" scope="col"></th>
                                <th class="text-center align-middle" scope="col">8X8WFHBM</th>
                                <td class="text-center align-middle" scope="col">3</td>
                                <td class="text-center align-middle" scope="col">1</td>
                                <td class="text-center align-middle" scope="col">1</td>
                                <td class="text-center align-middle" scope="col">3</td>
                                <td class="text-center align-middle" scope="col">2</td>
                                <td class="text-center align-middle" scope="col">1</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection('content'); ?>