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
                                    <?php foreach ($packinglist as $pl) : ?>
                                        <option value="<?= $pl['id']; ?>"><?= $pl['packinglist_no']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="carton_number" class="col-sm-2 col-form-label">Carton No</label>
                            <div class="col-sm-3">
                                <select class="form-control packingCartonNumber" style="width: 100%;">
                                    <option selected="selected">Select Carton No</option>
                                    <?php foreach ($carton as $c) : ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['carton_no']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="barcodenumber" class="col-sm-2 col-form-label">Barcode</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="InputBarcodeNumber" placeholder="Carton Barcode Number" name="barcodeNumber" value="<?= old('barcodeNumber'); ?>">
                            </div>
                        </div>

                        <!-- Table List Size -->
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6">
                                <label for="fabric_type" class="form-label">List Size</label>
                                <table id="table_ratio_size" class="table table-bordered align-middle">
                                    <thead class="thead">
                                        <tr>
                                            <th class="text-center">Size</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center" width="150">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center align-middle" colspan="3">No Selected Size</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="bg-dark">
                                        <tr>
                                            <th class="text-center">Total</th>
                                            <th class="" id="total_size_qty" colspan="2">: </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.Table List Size -->
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <label for="select_size" class="form-label">Add Size</label>
                                <select class="form-control" id="select_size" name="select_size" style="width: 100%;" data-placeholder="Select Size">
                                    <option value="">Select Size</option>
                                    <?php foreach ($size as $s) : ?>
                                        <option value="<?= $s['id']; ?>"><?= $s['size']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-4">
                                <div class="form-group">
                                    <label for="size_qty" class="form-label">Size Qty</label>
                                    <input type="number" class="form-control" id="size_qty" name="size_qty" min="0">
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-2">
                                <div class="form-group">
                                    <label for="" class="" style="color: rgba(255, 255, 255, 0)">.</label>
                                    <a id="btn_add_ratio_size" class="btn btn-success form-control">Add Size</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.Table List Size -->
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
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">
    let element_html;
    let data_row_count = $('#table_ratio_size > tbody tr').length;
    let detached_options = [];

    // ## memeriksa jika di dalam tabel belum ada size yang dipilih
    function is_table_empty_data(table_selector) {
        let data_row = $('#table_ratio_size > tbody tr td').length;
        if (data_row <= 1) {
            return true;
        } else {
            return false;
        }
    }

    // ## memeriksa jika input form untuk menambahkan size dan quantitynya masih kosong atau tidak
    function is_select_size_empty() {
        if (!$('#select_size').val()) {
            swal_warning({
                title: "Please select size"
            })
            return false;
        }
        if (!$('#size_qty').val()) {
            swal_warning({
                title: "Please select size quantity"
            })
            return false;
        }
        return true;
    }

    // ##membuat baris baru untuk setiap size yang telah dipilih
    function create_tr_element() {
        let select_size_value = $('#select_size').val();
        let select_size_text = $('#select_size_option:selected').text();
        let size_qty = $('#size_qty').val();
        let element = `
        <tr>
            <td lass="text-center align-middle">
                <input type="hidden" name="ratio_size_id[]" value="${select_size_value}">
                ${select_size_text}
            </td>
            <td lass="text-center align-middle">
                <input type="hidden" name="ratio_size_qty[]" value="${size_qty}">
                ${size_qty}
            </td>
            <td lass="text-center align-middle">
                <a class="btn btn-sm btn-danger btn-delete-size" data-id="${select_size_value}">Delete</a>
            </td>
        </tr>`
        return element;
    }

    // ## memeriksa apakah size yang akan ditambahkan sudah ada di dalam tabel
    function is_size_already_added() {
        var get_size = $("input[name='ratio_size_id[]']").map(function() {
            return $(this).val();
        }).get();
        let select_size_value = $('#select_size').val();
        if (get_size.includes(select_size_value)) {
            return true;
        }
        return false;
    }

    // ## menjumlahkan quantity tiap size
    function sum_size_qty() {
        var get_size_qty = $("input[name='ratio_size_qty[]']").map(function() {
            return $(this).val();
        }).get();
        const sum = get_size_qty.reduce((tempSum, next_arr) => tempSum + parseInt(next_arr), 0);
        return sum;
    }

    // ## user add size ke table list size
    $('#btn_add_ratio_size').on('click', function(e) {
        if (!is_select_size_empty()) { // jika form untuk nambah size ada yang belum di isi, maka aksi gagal
            return false;
        }
        element_html = create_tr_element();
        if (is_table_empty_data()) {
            $('#table_ratio_size > tbody').html(element_html);
        } else {
            if (is_size_already_added()) {
                swal_warning({
                    title: "Size already added"
                })
            } else {
                $('#table_ratio_size > tbody').append(element_html);
                data_row_count++;
            }
        }
        $('#select_size').val('');
        $('#select_size').trigger('change')
        $('#size_qty').val('');
        $('#total_size_qty').html(': ' + sum_size_qty());
    });
</script>
<?= $this->endSection('content'); ?>