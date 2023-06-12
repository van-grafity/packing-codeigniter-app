<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
#carton_detail_table tbody td {
    vertical-align: middle
}
.product_qty,
.scanned_count,
.total_product_qty,
.total_scanned_count,
.title_total {
    font-weight: bold;
    font-size: 20px;
}
</style>

<div class="content-wrapper">
    <section class="content mb-4">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <div class="card-title">Search Carton by Barcode</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <form action="" id="carton_barcode_form">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="carton_barcode" name="carton_barcode"
                                        placeholder="Carton Barcode Here" autofocus>
                                    <div class="ml-2">
                                        <button type="submit" class="btn btn-primary" id="btn_search_carton">Search Carton</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">Carton Barcode</dt>
                            <dd class="col-md-7 col-sm-12" id="carton_barcode_show"> - </dd>
                        </dl>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">Order No</dt>
                            <dd class="col-md-7 col-sm-12" id="po_number"> - </dd>

                            <dt class="col-md-5 col-sm-12">Packinglist No</dt>
                            <dd class="col-md-7 col-sm-12" id="pl_number"> - </dd>

                            <dt class="col-md-5 col-sm-12">Buyer</dt>
                            <dd class="col-md-7 col-sm-12" id="buyer"> - </dd>
                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">Carton No</dt>
                            <dd class="col-md-7 col-sm-12" id="carton_number"> - </dd>

                            <dt class="col-md-5 col-sm-12">Total Carton</dt>
                            <dd class="col-md-7 col-sm-12" id="total_carton"> - </dd>

                            <dt class="col-md-5 col-sm-12">PCS / Carton</dt>
                            <dd class="col-md-7 col-sm-12" id="total_pcs"> - </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-info mt-2">
            <div class="card-header">
                <div class="card-title">Carton Detail</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <form action="" id="product_barcode_form">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="product_code" name="product_code"
                                        placeholder="Product Code Here">
                                    <div class="ml-2">
                                        <button type="submit" class="btn btn-info" id="btn_scan_product">Scan Product</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h6 class="text-bold">Product in Carton :</h6>
                        <div class="table-responsive p-0 ">
                            <table id="carton_detail_table" class="table table-bordered table-sm">
                                <thead class="">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th width="120">UPC</th>
                                        <th>Name</th>
                                        <th>Colour</th>
                                        <th>Size</th>
                                        <th>Order Qty</th>
                                        <th>Scanned</th>
                                        <th width="120">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td colspan="8">Empty Data</td>
                                    </tr>
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-sm-12 text-right">
                        <form action="<?= base_url('scanpack/packcarton') ?>" id="pack_carton_form" method="POST">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="carton_id" id="carton_id" value="">
                            <button type="submit" class="btn btn-success" id="btn_pack_carton">Pack Carton</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-right">
            <div class="col-12">
                <a href="" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
$(document).ready(function() {

    reset_field();

    $('#carton_barcode_form').on('submit', function(e) {
        e.preventDefault();
        let carton_barcode = $('#carton_barcode').val();
        // ## If no Entry Barcode Skip;
        if (!carton_barcode) return false;

        show_detail_carton(carton_barcode)
        $('#carton_barcode').val('');
    });

    $('#product_barcode_form').on('submit', function(e) {
        e.preventDefault();
        let product_code = $('#product_code').val();
        // ## If no Entry Barcode Skip;
        if (!product_code) return false;

        scan_product_code(product_code);
        $('#product_code').val('');
    });
    

})
</script>

<script type="text/javascript">
const detail_carton_url = '<?= base_url('scanpack/detailcarton')?>';
const pack_carton_url =  '<?= base_url('scanpack/packcarton') ?>';

async function show_detail_carton(carton_barcode) {
    params_data = {
        carton_barcode
    };
    result = await using_fetch(detail_carton_url, params_data, "GET");

    if (result.status == 'error') {
        reset_field();
        show_flash_message({ error: result.message} )
        return false;
    }

    let data_po = result.data.data_po;
    let carton_detail = result.data.carton_detail;

    set_po_detail(data_po);
    set_carton_detail(carton_detail)
    $('#carton_barcode_show').text(carton_barcode);
    
    $('#product_code').focus();
}

function reset_field() {
    $('#carton_barcode_show').text('-');
    $('#po_number').text('-');
    $('#pl_number').text('-');
    $('#buyer').text('-');
    $('#carton_number').text('-');
    $('#total_carton').text('-');
    $('#total_pcs').text('-');

    let empty_row = `
        <tr class="text-center">
            <td colspan=8">Empty Data</td>
        </tr>
    `;
    $('#carton_detail_table tbody').html(empty_row);

    $('#btn_pack_carton').attr('disabled',true);
}

function set_po_detail(data_po) {
    $('#po_number').text(data_po.po_number);
    $('#pl_number').text(data_po.pl_number);
    $('#buyer').text(data_po.buyer);
    $('#carton_number').text(data_po.carton_number);
    $('#total_carton').text(data_po.total_carton);
    $('#total_pcs').text(data_po.total_pcs);

    $('#carton_id').val(data_po.carton_id);
    $('#pack_carton_form').attr('action',pack_carton_url);
}

function set_carton_detail(carton_detail) {

    $('#carton_detail_table tbody').html('');

    let total = 0;
    carton_detail.forEach((data, key) => {
        let row = `
                <tr class="text-center">
                    <td>${key+1}</td>
                    <td class="product_code">${data.product_code}</td>
                    <td>${data.product_name}</td>
                    <td>${data.product_colour}</td>
                    <td>${data.product_size}</td>
                    <td class="product_qty">${data.product_qty}</td>
                    <td class="scanned_count"> 0 </td>
                    <td class="scanned_status"> <span class="badge bg-warning">Not Complete</span> </td>
                </tr>
            `;
        $('#carton_detail_table tbody').append(row);

        total += parseInt(data.product_qty);
    });
    let row_footer = `
            <tr>
                <td colspan="5" class="text-right title_total">Total :</td>
                <td colspan="1" class="text-center total_product_qty">${total}</td>
                <td colspan="1" class="text-center total_scanned_count">0</td>
                <td colspan="1" class="text-center all_scanned_status"><span class="badge bg-warning">Not Complete</span></td>
            </tr>
        `;
    $('#carton_detail_table tfoot').html(row_footer);
}

function scan_product_code(product_code) {
    let product_row = $("#carton_detail_table tbody .product_code").filter(function() {
        return $(this).text() == product_code;
    }).closest("tr");
    
    if(product_row.length <= 0) {
        toastr.error('Invalid Product Code!')
        return false;
    }

    let product_qty = parseInt(product_row.find('td.product_qty').text());
    let scanned_count = parseInt(product_row.find('td.scanned_count').text());
    
    if(scanned_count >= product_qty){
        alert('This Product has been Fulfilled!, please input another Product Code!');
        return false;
    }
    scanned_count++;
    product_row.find('td.scanned_count').text(scanned_count);
    

    if(scanned_count == product_qty){
        product_row.find('td.scanned_status').html(`<span class="badge bg-success">Complete</span>`)
    }

    update_total_scanned();
    check_all_status();
}

function update_total_scanned() {
    let scanned_count_data = $("#carton_detail_table tbody td.scanned_count");
    let total_scanned_count = 0;
    scanned_count_data.each((i, row) => {
        total_scanned_count += parseInt($(row).text());
    });
    $('.total_scanned_count').text(total_scanned_count);
}

function check_all_status() {
    total_row = $('#carton_detail_table tfoot');
    let total_product_qty = total_row.find('.total_product_qty').text();
    let total_scanned_count = total_row.find('.total_scanned_count').text();

    if(total_scanned_count == total_product_qty){
        total_row.find('td.all_scanned_status').html(`<span class="badge bg-success">All Complete</span>`)

        $('#btn_pack_carton').attr('disabled',false);
    } else {
        total_row.find('td.all_scanned_status').html(`<span class="badge bg-warning">Not Complete</span>`)
    }
}
</script>
<?= $this->endSection('page_script'); ?>