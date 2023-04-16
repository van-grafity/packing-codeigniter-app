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
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="form-horizontal">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="packinglistnumber" class="col-sm-2 col-form-label">Packing List</label>
                            <div class="col-sm-4">
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
                            <label for="carton_number" class="col-sm-2 col-form-label">Carton No</label>
                            <div class="col-sm-3">
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
                            <label for="barcodenumber" class="col-sm-2 col-form-label">Barcode</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="InputBarcodeNumber" placeholder="Carton Barcode Number">
                                <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#ratioModal">Carton Ratio</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
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

        <!-- Modal Ratio Carton Ratio-->
        <form action="" method="post">
            <div class="modal fade" id="ratioModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Carton Ratio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Carton No</label>
                                <input disabled type="text" class="form-control carton_no" name="carton_n0" placeholder="Carton Number (diambil dari input sebelumnya)">
                            </div>
                            <div class="form-group">
                                <label>Size</label>
                                <select class="form-control size" style="width: 100%;">
                                    <option selected="selected">Size</option>
                                    <option>XS</option>
                                    <option>S</option>
                                    <option>M</option>
                                    <option>L</option>
                                    <option>XL</option>
                                    <option>XXL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" class="form-control quantity" name="quantity" placeholder="Quantity">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="product_id" class="product_id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Modal Carton Ratio-->
    </section>
    <!-- /.content -->


</div>
<?= $this->endSection('content'); ?>