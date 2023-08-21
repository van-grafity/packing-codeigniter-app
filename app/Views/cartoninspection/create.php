<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
#carton_inspection_table tbody td {
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
                <div class="card-title">Inspection Form</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <form action="" id="carton_barcode_form">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="carton_barcode" name="carton_barcode" placeholder="Carton Barcode Here" autofocus>
                                    <div class="ml-2">
                                        <button type="submit" class="btn btn-primary" id="btn_search_carton">Search Carton</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <form action="<?= base_url('cartoninspection/store')?>" method="post" id="carton_inspection_form">

                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="title">Carton List : </h4>
                            <div class="table-responsive p-0 ">
                                <table id="carton_inspection_table" class="table table-bordered table-sm">
                                    <thead class="">
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Order No.</th>
                                            <th>GL Number</th>
                                            <th>Buyer</th>
                                            <th>Carton No.</th>
                                            <th>Pcs / Ctn</th>
                                            <th class="d-none">Carton ID</th>
                                            <th class="d-none">Carton Barcode</th>
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

                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="issued_by" class="col-form-label">Issued By : </label>
                                        <input type="text" class="form-control" id="issued_by" name="issued_by" placeholder="Issued By" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="received_by" class="col-form-label">Received By :</label>
                                        <input type="text" class="form-control" id="received_by" name="received_by" placeholder="Received By" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="received_date" class="col-form-label">Received Date :</label>
                                        <input type="text" class="form-control" id="received_date" name="received_date" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-right">
                                        <a href="<?= base_url('cartoninspection') ?>" type="button" class="btn btn-secondary">Back</a>
                                        <button type="submit" class="btn btn-primary" id="btn_submit">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
        <!-- <div class="card card-info mt-2 d-none">
            <div class="card-header">
                <div class="card-title">Inspection Form</div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('cartoninspection/store')?>" method="post" id="carton_inspection_form">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="issued_by" class="col-form-label">Issued By</label>
                                <input type="text" class="form-control" id="issued_by" name="issued_by" placeholder="Issued By">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="received_by" class="col-form-label">Received By :</label>
                                <input type="text" class="form-control" id="received_by" name="received_by" placeholder="Received By">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="received_date" class="col-form-label">Received Date :</label>
                                <input type="text" class="form-control" id="received_date" name="received_date" disabled>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btn_submit">Save</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div> -->

        <div class="row text-right">
            <div class="col-12">
            </div>

        </div>
    </section>
</div>

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
$(document).ready(function() {

    $('#carton_barcode_form').on('submit', function(e) {
        e.preventDefault();
        let carton_barcode = $('#carton_barcode').val();
        // ## If no Entry Barcode, Skip;
        if (!carton_barcode) return false;

        show_detail_carton(carton_barcode)
        $('#carton_barcode').val('');

    });

    $('#received_date').val(moment().format('YYYY-MM-DD'));

})
</script>

<script type="text/javascript">
const detail_carton_url = '<?= base_url('cartoninspection/detailcarton')?>';

async function show_detail_carton(carton_barcode) {

    if (is_already_inputed(carton_barcode)) {
        show_flash_message({
            error: "This Carton has been inputed!"
        });
        return false;
    };

    params_data = {
        carton_barcode
    };
    result = await using_fetch(detail_carton_url, params_data, "GET");

    if (result.status == 'error') {
        show_flash_message({
            error: result.message
        })
        return false;
    }

    let carton_info = result.data.carton_info;
    let is_packed = carton_info.flag_packed == 'Y' ? true : false;
    let carton_detail = result.data.carton_detail;

    console.log(carton_info);
    add_carton_to_table(carton_info);


    // set_carton_info(carton_info);
    // set_carton_detail(carton_detail, is_packed)

    // $('#carton_barcode_show').text(carton_barcode);

    // if (carton_info.flag_packed == 'N') {
    //     $('#product_code').attr('disabled', false);
    //     $('#product_code').focus();
    // } else {
    //     $('#product_code').attr('disabled', true);
    //     $('#btn_pack_carton').attr('disabled', true);
    // }
}

const create_element_tr = (carton_info) => {
    let element_tr = `
        <tr class="text-center">
            <td>[]</td>
            <td>${carton_info.po_number}</td>
            <td>${carton_info.gl_number}</td>
            <td>${carton_info.buyer_name}</td>
            <td>${carton_info.carton_number}</td>
            <td>${carton_info.total_pcs}</td>
            <td class="info d-none">
                <input name="carton_ids[]" type="text" value="${carton_info.carton_id}">
            </td>
            <td class="carton-barcode d-none">${carton_info.carton_barcode}</td>
        </tr>
    `;
    return element_tr;
}

const add_carton_to_table = (carton_info) => {
    let element_tr = create_element_tr(carton_info);
    if (is_empty_table()) {
        $('#carton_inspection_table tbody').html(element_tr);
    } else {
        $('#carton_inspection_table tbody').append(element_tr);
    }

    refresh_table_number();
}

const is_empty_table = () => {
    let count_first_element = $(`#carton_inspection_table tbody tr td`).length;
    if (count_first_element <= 1) {
        return true;
    }
    return false;
}

const refresh_table_number = () => {
    $('#carton_inspection_table tr:not(.info)>td:first-child').each(function(i) {
        $(this).text(i + 1);
    });
}

const is_already_inputed = (carton_barcode) => {
    if ($(`#carton_inspection_table tr td.carton-barcode:contains(${carton_barcode})`).length > 0) {
        return true;
    } else {
        return false;
    }
}





function set_carton_detail(carton_detail, is_packed = false) {

    $('#carton_inspection_table tbody').html('');

    let total = 0;
    carton_detail.forEach((data, key) => {
        let row;
        if (!is_packed) {
            row = `
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
        } else {
            row = `
                <tr class="text-center">
                    <td>${key+1}</td>
                    <td class="product_code">${data.product_code}</td>
                    <td>${data.product_name}</td>
                    <td>${data.product_colour}</td>
                    <td>${data.product_size}</td>
                    <td class="product_qty">${data.product_qty}</td>
                    <td class="scanned_count"> ${data.product_qty} </td>
                    <td class="scanned_status"> <span class="badge bg-success">Complete</span> </td>
                </tr>
            `;
        }
        $('#carton_inspection_table tbody').append(row);

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
    $('#carton_inspection_table tfoot').html(row_footer);

    update_total_scanned();
    check_all_status();
}

function scan_product_code(product_code) {
    let product_row = $("#carton_inspection_table tbody .product_code").filter(function() {
        return $(this).text() == product_code;
    }).closest("tr");

    if (product_row.length <= 0) {
        toastr.error('Invalid Product Code!')
        return false;
    }

    let product_qty = parseInt(product_row.find('td.product_qty').text());
    let scanned_count = parseInt(product_row.find('td.scanned_count').text());

    if (scanned_count >= product_qty) {
        swal_warning({
            title: "This Product has been Fulfilled!"
        })
        return false;
    }
    scanned_count++;
    product_row.find('td.scanned_count').text(scanned_count);


    if (scanned_count == product_qty) {
        product_row.find('td.scanned_status').html(`<span class="badge bg-success">Complete</span>`)
    }

    update_total_scanned();
    check_all_status();
}

function update_total_scanned() {
    let scanned_count_data = $("#carton_inspection_table tbody td.scanned_count");
    let total_scanned_count = 0;
    scanned_count_data.each((i, row) => {
        total_scanned_count += parseInt($(row).text());
    });
    $('.total_scanned_count').text(total_scanned_count);
}

function check_all_status() {
    total_row = $('#carton_inspection_table tfoot');
    let total_product_qty = total_row.find('.total_product_qty').text();
    let total_scanned_count = total_row.find('.total_scanned_count').text();

    if (total_scanned_count == total_product_qty) {
        total_row.find('td.all_scanned_status').html(`<span class="badge bg-success">All Complete</span>`)

        $('#btn_pack_carton').attr('disabled', false);
    } else {
        total_row.find('td.all_scanned_status').html(`<span class="badge bg-warning">Not Complete</span>`)
    }
}
</script>
<?= $this->endSection('page_script'); ?>