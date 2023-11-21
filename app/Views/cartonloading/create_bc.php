<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
</style>

<div class="content-wrapper">
    <section class="content mb-4">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <div class="card-title"><?= $title ?></div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <form action="" id="pallet_barcode_form">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="pallet_barcode" name="pallet_barcode" placeholder="Pallet Barcode Here" autofocus>
                                    <div class="ml-2">
                                        <button type="submit" class="btn btn-primary" id="btn_search_pallet">Search Pallet</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">Pallet No. </dt>
                            <dd class="col-md-7 col-sm-12" id="pallet_number">:  </dd>

                            <dt class="col-md-5 col-sm-12">Status</dt>
                            <dd class="col-md-7 col-sm-12" id="pallet_status">:  </dd>

                            <dt class="col-md-5 col-sm-12">Total Carton</dt>
                            <dd class="col-md-7 col-sm-12" id="pallet_total_carton">:  </dd>
                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">From</dt>
                            <dd class="col-md-7 col-sm-12" id="location_from">:  </dd>

                            <dt class="col-md-5 col-sm-12">To</dt>
                            <dd class="col-md-7 col-sm-12" id="location_to">:  </dd>

                            <dt class="col-md-5 col-sm-12">Rack Location</dt>
                            <dd class="col-md-7 col-sm-12" id="rack_serial_number">:  </dd>
                        </dl>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title text-bold">Cartons in This Pallet :</h3>
                    </div>

                    <div class="card-body table-responsive p-0" style="max-height: 500px;">
                        <table id="pallet_transfer_detail" class="table table-sm table-bordered text-center table-head-fixed table-foot-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Buyer</th>
                                    <th>PO</th>
                                    <th width="150">GL</th>
                                    <th width="100">Carton No.</th>
                                    <th width="300">Content</th>
                                    <th>Pcs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9"> There's No Carton </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-dark">
                                <tr>
                                    <td colspan="4">Total Carton</td>
                                    <td colspan="1" id="pallet_transfer_detail_total_carton"> - </td>
                                    <td colspan="1">Total Pcs</td>
                                    <td colspan="1" id="pallet_transfer_detail_total_pcs"> - </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="progress progress-xxs mb-5">
                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">20% Complete</span>
                    </div>
                </div>
                <h3 class="text-center mb-3">Carton List for Loading</h3>
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <form action="" id="scan_carton_barcode_form">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="scan_carton_barcode" name="scan_carton_barcode"
                                        placeholder="Carton Barcode Here">
                                    <div class="ml-2">
                                        <button type="submit" class="btn btn-info" id="btn_scan_carton">Scan Carton</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-5">
                    <form action="<?= url_to('carton_loading_store') ?>" id="scanned_carton_form" method="POST">
                        <?= csrf_field(); ?>

                        <div class="card-header">
                            <h3 class="card-title text-bold">Scanned Carton :</h3>
                        </div>

                        <div class="card-body table-responsive p-0" style="max-height: 500px;">
                            <table id="scanned_carton_table" class="table table-sm table-bordered text-center table-head-fixed table-foot-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>Buyer</th>
                                        <th>PO</th>
                                        <th width="150">GL</th>
                                        <th width="100">Carton No.</th>
                                        <th width="300">Content</th>
                                        <th>Pcs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="9"> There's No Carton </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-dark">
                                    <tr>
                                        <td colspan="4">Total Scanned Carton</td>
                                        <td colspan="1" id="scanned_carton_total_carton"> - </td>
                                        <td colspan="1">Total Pcs</td>
                                        <td colspan="1" id="scanned_carton_total_pcs"> - </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-success" id="btn_load_carton">Load Cartons</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>


<script type="text/javascript">
const carton_list_by_pallet_url = '<?= url_to('carton_loading_search_carton_by_pallet')?>';

async function get_carton_by_pallet_barcode(pallet_barcode) {
    params_data = {
        pallet_barcode
    };
    result = await using_fetch(carton_list_by_pallet_url, params_data, "GET");
    
    if (result.status == 'error') {
        show_flash_message({ error: result.message} )
        return false;
    }
    
    return result.data;
}

function set_pallet_transfer_info(pallet_transfer_info) {
    $('#pallet_number').text(': ' + pallet_transfer_info.pallet_number);
    $('#pallet_status').text(': ' + pallet_transfer_info.status);
    $('#pallet_total_carton').text(': ' + pallet_transfer_info.total_carton);
    $('#location_from').text(': ' + pallet_transfer_info.location_from);
    $('#location_to').text(': ' + pallet_transfer_info.location_to);
    $('#rack_serial_number').text(': ' + pallet_transfer_info.rack_serial_number);

    $('#pallet_transfer_id').val(pallet_transfer_info.pallet_transfer_id);
}

function set_transfer_note_carton_list(pallet_transfer_detail){
    if(pallet_transfer_detail.length <= 0) return false;

    pallet_transfer_detail.forEach(carton_data => {
        insert_carton_to_table(carton_data);
    });
    update_total_in_transfernote_detail();
}

function insert_carton_to_table(carton_data){
    let pallet_transfer_detail_first_row = $('#pallet_transfer_detail tbody').find('td').length;
    if(pallet_transfer_detail_first_row <= 1) {
        $('#pallet_transfer_detail tbody').html('');
    };

    let row = `
        <tr class="text-center count-carton">
            <td class="d-none">
                <input type="text" name="carton_barcode_id[]" value="${carton_data.carton_id}">
            </td>
            <td class="carton-barcode">${carton_data.carton_barcode}</td>
            <td>${carton_data.buyer_name}</td>
            <td>${carton_data.po_number}</td>
            <td>${carton_data.gl_number}</td>
            <td>${carton_data.carton_number}</td>
            <td>${carton_data.content}</td>
            <td class="total-pcs-in-carton">${carton_data.total_pcs}</td>
        </tr>
    `;
    $('#pallet_transfer_detail tbody').append(row);
}

function update_total_in_transfernote_detail() {
    let total_carton = $(`#pallet_transfer_detail tbody tr.count-carton`).length;
    $('#pallet_transfer_detail_total_carton').text(parseInt(total_carton));

    let array_total_pcs = $(`#pallet_transfer_detail tbody tr td.total-pcs-in-carton`).map(function() {
        return parseInt($(this).text());
    }).get();
    
    let sum_total_pcs = array_total_pcs.reduce((tempSum, next_arr) => tempSum + parseInt(next_arr), 0);
    $('#pallet_transfer_detail_total_pcs').text(sum_total_pcs);

    let pallet_transfer_detail_row = $('#pallet_transfer_detail tbody').find('tr').length;
    if(pallet_transfer_detail_row <= 0) {
        clear_carton_list()
    } 
}

function clear_pallet_transfer_info() {
    $('#pallet_number').text(': - ');
    $('#pallet_status').text(': - ');
    $('#pallet_total_carton').text(': - ');
    $('#location_from').text(': - ');
    $('#location_to').text(': - ');
    $('#rack_serial_number').text(': - ');

    $('#pallet_transfer_id').val('');
}

function clear_carton_list(){
    let empty_row = `
        <tr>
            <td colspan="8"> There's No Carton </td>
        </tr>`;
    $('#pallet_transfer_detail tbody').html(empty_row);
    $('#pallet_transfer_detail_total_carton').text(' - ');
    $('#pallet_transfer_detail_total_pcs').text(' - ');
}

const get_carton_in_pallet = (carton_barcode) => {
    let product_row = $("#pallet_transfer_detail tbody .carton-barcode").filter(function() {
        return $(this).text() == carton_barcode;
    }).closest("tr");

    if(product_row.length <= 0) {
        return false;
    } else {
        return product_row;
    }
}

const insert_carton_to_scanned_table = (carton_data) => {
    let scanned_carton_table_first_row = $('#scanned_carton_table tbody').find('td').length;
    if(scanned_carton_table_first_row <= 1) {
        $('#scanned_carton_table tbody').html('');
    };
    $('#scanned_carton_table tbody').append(carton_data);

    update_total_scanned_carton();
}

const update_total_scanned_carton = () => {
    let total_carton = $(`#scanned_carton_table tbody tr.count-carton`).length;
    $('#scanned_carton_total_carton').text(parseInt(total_carton));

    let array_total_pcs = $(`#scanned_carton_table tbody tr td.total-pcs-in-carton`).map(function() {
        return parseInt($(this).text());
    }).get();
    
    let sum_total_pcs = array_total_pcs.reduce((tempSum, next_arr) => tempSum + parseInt(next_arr), 0);
    $('#scanned_carton_total_pcs').text(sum_total_pcs);

    if(total_carton > 0) {
        $('#btn_load_carton').attr('disabled', false);
    }
}

const clear_scanned_carton = () => {
    let empty_row = `
        <tr>
            <td colspan="8"> There's No Carton </td>
        </tr>`;
    $('#scanned_carton_table tbody').html(empty_row);
    $('#scanned_carton_total_carton').text(' - ');
    $('#scanned_carton_total_pcs').text(' - ');

    $('#btn_load_carton').attr('disabled', true);
}

</script>


<script type="text/javascript">
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);

    clear_scanned_carton();

    $('#pallet_barcode_form').on('submit', async function(e) {
        e.preventDefault();
        let pallet_barcode = $('#pallet_barcode').val();
        // ## If no Entry Barcode, Skip;
        if (!pallet_barcode) return false;

        let data = await get_carton_by_pallet_barcode(pallet_barcode)
        $('#pallet_barcode').val('');

        clear_pallet_transfer_info();
        clear_carton_list();
        clear_scanned_carton();

        if(!data) return false;

        set_pallet_transfer_info(data.pallet_transfer);
        if(data.pallet_transfer_detail) {
            set_transfer_note_carton_list(data.pallet_transfer_detail);
        }

        $('#scan_carton_barcode').focus();
    });

    $('#scan_carton_barcode_form').on('submit', function(e) {
        e.preventDefault();
        let scan_carton_barcode = $('#scan_carton_barcode').val();

        // ## If no Entry Barcode, Skip;
        if (!scan_carton_barcode) return false;

        let carton_data = get_carton_in_pallet(scan_carton_barcode)
        if(!carton_data){ 
            toastr.error('Invalid Product Code!');
            $('#scan_carton_barcode').val('');
            return false;
        }
        
        insert_carton_to_scanned_table(carton_data[0]);
        $('#scan_carton_barcode').val('');
        $('#scan_carton_barcode').focus();
        
        update_total_in_transfernote_detail();

    });

    $('#scanned_carton_form').on('submit', async function(e) {
        e.preventDefault();
        let total_carton = parseInt($('#scanned_carton_total_carton').text());
        let data = {
            title: `Load ${total_carton} Cartons?`,
            confirm_button: 'Yes',
        }
        let confirm_action = await swal_confirm(data);
        if(!confirm_action) { return false; };

        $(this).unbind('submit').submit();
    })
})
</script>
<?= $this->endSection('page_script'); ?>