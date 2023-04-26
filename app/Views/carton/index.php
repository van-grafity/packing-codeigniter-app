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
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="form-horizontal">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="packinglistnumber" class="col-sm-2 col-form-label">Packing List</label>
                            <div class="col-sm-4">
                                <select name="packingList" class="form-control packingListNumber" style="width: 100%;">
                                    <option selected="selected">Select Packing List No</option>
                                    <?php foreach ($carton as $c) : ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['packinglist_no']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="carton_number" class="col-sm-2 col-form-label">Carton No</label>
                            <div class="col-sm-3">
                                <select class="form-control packingCartonNumber" style="width: 100%;">
                                    <option selected="selected">Select Carton No</option>
                                    <option>1</option>
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
                <div class="card card-success">
                    <div class="card-header">
                        <h5 class="card-title">List of Carton Barcode</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
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
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($carton as $c) : ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $i++; ?></td>
                                        <td class="text-center align-middle"><?= $c['packinglist_no']; ?></td>
                                        <td class="text-center align-middle"><?= $c['PO_No']; ?></td>
                                        <td class="text-center align-middle"><?= $c['carton_no']; ?></td>
                                        <td class="text-center align-middle"><?= $c['carton_barcode']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="card-title">List of Carton Rasio</h5>
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
                                    <th rowspan="2" class="text-center align-middle" scope="col">SN</th>
                                    <th rowspan="2" class="text-center align-middle" scope="col">PL No</th>
                                    <th rowspan="2" class="text-center align-middle" scope="col">PO No</th>
                                    <th rowspan="2" class="text-center align-middle" scope="col">Carton No</th>
                                    <th colspan="5" class="text-center align-middle">Size</th>
                                </tr>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($ratio as $r) : ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $i++; ?></td>
                                        <td class="text-center align-middle"><?= $r['packinglist_no']; ?></td>
                                        <td class="text-center align-middle"><?= $r['PO_No']; ?></td>
                                        <td class="text-center align-middle"><?= $r['carton_no']; ?></td>
                                        <td class="text-center align-middle"><?= $r['size_name']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
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
                            <button type="submit" class="btn btn-primary">Save</button>
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