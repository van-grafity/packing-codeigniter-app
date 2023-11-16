<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>

// !! Katanya ini halaman mau di hapus
<style>
    #transfer_note_detail tfoot::before
    {
        content: '';
        display: table-row;
        height: 15px;
        background-color: #fff;
    }
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <form action="" id="pallet_search_form">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="pallet_serial_number" name="pallet_serial_number"
                                        placeholder="Pallet Barcode Here" autofocus>
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
                            <dd class="col-md-7 col-sm-12" id="pallet_number">: - </dd>

                            <dt class="col-md-5 col-sm-12">Status</dt>
                            <dd class="col-md-7 col-sm-12" id="pallet_status">: - </dd>

                            <dt class="col-md-5 col-sm-12">Total Carton</dt>
                            <dd class="col-md-7 col-sm-12" id="pallet_total_carton">: - </dd>
                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">From</dt>
                            <dd class="col-md-7 col-sm-12" id="location_from">: - </dd>

                            <dt class="col-md-5 col-sm-12">To</dt>
                            <dd class="col-md-7 col-sm-12" id="location_to">: - </dd>
                        </dl>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="title">Transfer Notes</h4>
                        <button type="button" class="btn btn-success mb-2 disabled" id="btn_modal_create_transfer_note" onclick="create_transfer_note()">New Transfer Note</button>
                        <table class="table table-bordered table-hover text-center" id="transfer_note_table">
                            <thead>
                                <tr class="table-primary text-center">
                                    <th width="">Transfer Note Number</th>
                                    <th width="">Issued By</th>
                                    <th width="">Authorized By</th>
                                    <th width="">Total Carton</th>
                                    <th width="">Received By</th>
                                    <th width="">Received At</th>
                                    <th width="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7">There's no Transfer Note</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-right">
                            <a href="<?= url_to('pallet_transfer') ?>" type="button" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>


<!-- Modal Add and Edit Transfer Note -->
<div class="modal fade" id="modal_transfer_note" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">New Transfer Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="transfer_note_header">
                    <div class="row">
                        <div class="col-sm-6">
                            <dl class="row">
                                <dt class="col-md-5 col-sm-12">Transfer Note No. </dt>
                                <dd class="col-md-7 col-sm-12" id="transfer_note_serial_number">: - </dd>

                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <dl class="row">
                                <dt class="col-md-5 col-sm-12">From </dt>
                                <dd class="col-md-7 col-sm-12" id="transfer_note_from">: - </dd>

                                <dt class="col-md-5 col-sm-12">To</dt>
                                <dd class="col-md-7 col-sm-12" id="transfer_note_to">: - </dd>
                            </dl>
                        </div>
                        <div class="col-sm-6">
                            <dl class="row">
                                <dt class="col-md-5 col-sm-12">Date</dt>
                                <dd class="col-md-7 col-sm-12" id="transfer_note_date">: - </dd>

                            </dl>
                        </div>
                    </div>
                </div>
                
                <form action="" method="post" id="carton_barcode_search_form">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="carton_barcode" name="carton_barcode" placeholder="Scan Carton Barcode">
                        <div class="ml-2">
                            <button class="btn btn-primary" id="carton_barcode_search">Search Carton</button>
                        </div>
                    </div>
                </form>

                <form action="" method="post" id="transfer_note_form">
                    <input type="hidden" name="edit_transfer_note_id" value="" id="edit_transfer_note_id">

                    <h4>Carton List : </h4>
                    
                    <table id="transfer_note_detail" class="table table-sm table-bordered text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="d-none">Carton ID</th>
                                <th class="d-none">Carton Barcode</th>
                                <th>Buyer</th>
                                <th>PO</th>
                                <th>GL</th>
                                <th>Carton No.</th>
                                <th>Content</th>
                                <th>Pcs</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Aero</td>
                                <td>123213</td>
                                <td>63000-01</td>
                                <td>1</td>
                                <td>S=1 | M=2 | L=2</td>
                                <td>5</td>
                                <td><button type="button" class="btn btn-sm btn-danger">Delete</button></td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-dark">
                            <tr>
                                <td colspan="4">Total Carton</td>
                                <td colspan="1" id="transfer_note_detail_total_carton">1</td>
                                <td colspan="1">Total Pcs</td>
                                <td colspan="1" id="transfer_note_detail_total_pcs">5</td>
                                <td colspan="1"></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="transfer_note_issued_by" class="col-form-label">Issued By</label>
                                <input type="text" class="form-control" id="transfer_note_issued_by" name="transfer_note_issued_by">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="transfer_note_authorized_by" class="col-form-label">Authorized By</label>
                                <input type="text" class="form-control" id="transfer_note_authorized_by" name="transfer_note_authorized_by">
                            </div>
                        </div>

                    </div>
                    <div class="row text-right">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn_submit_transfer_note">Save Transfer Note</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit Transfer Note -->

<?= $this->endSection(); ?>



<?= $this->Section('page_script'); ?>
<script type="text/javascript">
const pallet_detail_url = '<?= url_to('pallet_transfer_pallet_detail')?>';
const carton_detail_url = '<?= url_to('pallet_transfer_carton_detail')?>';
const transfer_note_detail_url = '<?= url_to('pallet_transfer_transfer_note_detail')?>';

let is_pallet_selected = false;
let pallet_transfer_from = '-';
let pallet_transfer_to = '-';
let pallet_transfer_id = null;


async function get_pallet_detail(pallet_serial_number) {
    params_data = {
        pallet_serial_number
    };
    result = await using_fetch(pallet_detail_url, params_data, "GET");

    if (result.status == 'error') {
        clear_pallet_info();
        show_flash_message({ error: result.message} )
        return false;
    }

    return result.data;
    
}

async function get_carton_detail(carton_barcode){
    params_data = {
        carton_barcode
    };
    result = await using_fetch(carton_detail_url, params_data, "GET");

    if (result.status == 'error') {
        clear_pallet_info();
        show_flash_message({ error: result.message} )
        return false;
    }
    
    return result.data;
}

async function get_transfer_note(transfer_note_id){
    params_data = {
        transfer_note_id
    };
    result = await using_fetch(transfer_note_detail_url, params_data, "GET");

    if (result.status == 'error') {
        clear_pallet_info();
        show_flash_message({ error: result.message} )
        return false;
    }
    
    return result.data;
}

function clear_pallet_info() {
    $('#pallet_number').text(': -');
    $('#pallet_status').text(': -');
    $('#pallet_total_carton').text(': -');
    $('#location_from').text(': -');
    $('#location_to').text(': -');

    let empty_row = `
        <tr class="text-center">
            <td colspan=7">Empty Data</td>
        </tr>
    `;
    $('#transfer_note_table tbody').html(empty_row);
    $('#transfer_note_table tfoot').html('');

}

function clear_transfer_note_form(){
    $('#transfer_note_serial_number').text(': -');
    $('#carton_barcode').val('');
    $('#transfer_note_issued_by').val('');
    $('#transfer_note_authorized_by').val('');

    clear_transfer_note_detail();
}

function clear_transfer_note_detail(){
    let empty_row = `
        <tr class="text-center">
            <td colspan=8">There's no Carton</td>
        </tr>
    `;
    $('#transfer_note_detail tbody').html(empty_row);

    $('#transfer_note_detail_total_carton').text('0')
    $('#transfer_note_detail_total_pcs').text('0')
}

function check_selected_pallet(){
    let pallet_number = $('#pallet_number').text();
    console.log(pallet_number);
}

function set_pallet_info(pallet_info) {
    $('#pallet_number').text(': ' + pallet_info.pallet_number);
    $('#pallet_status').text(': ' + pallet_info.status);
    $('#location_from').text(': ' + pallet_info.location_from);
    $('#location_to').text(': ' + pallet_info.location_to);

    pallet_transfer_from = pallet_info.location_from;
    pallet_transfer_to = pallet_info.location_to;
    // pallet_transfer_id = pallet_info.id;
    console.log(pallet_info);

    is_pallet_selected = true;
    $('#btn_modal_create_transfer_note').removeClass('disabled');
}

function set_transfer_note_info(transfer_note_info) {
    $('#transfer_note_serial_number').text(': ' + transfer_note_info.serial_number);
    $('#transfer_note_issued_by').val(transfer_note_info.issued_by);
    $('#transfer_note_authorized_by').val(transfer_note_info.authorized_by);
}

function set_transfer_note_list(transfer_note_list) {
    let total = 0;
    $('#pallet_total_carton').text(': ' + total);

    if(transfer_note_list.length <= 0) {
        let empty_row = `
            <tr class="text-center">
                <td colspan="7">There's no Transfer Note</td>
            </tr>`
        $('#transfer_note_table tbody').html(empty_row);
        return;
    }
    $('#transfer_note_table tbody').html('');


    transfer_note_list.forEach((data, key) => {
        
        let row = `
            <tr class="text-center">
                <td class="product_code">${data.serial_number}</td>
                <td>${data.issued_by}</td>
                <td>${data.authorized_by}</td>
                <td>${data.total_carton}</td>
                <td>${data.received_by}</td>
                <td>${data.received_at}</td>
                <td><button type="button" class="btn btn-sm btn-info" onclick="edit_transfer_note(${data.id})">Detail</button></td>
            </tr>
        `;
        $('#transfer_note_table tbody').append(row);

        total += parseInt(data.total_carton);
    });
    $('#pallet_total_carton').text(': ' + total);
}

function create_transfer_note(){
    if(!is_pallet_selected){
        alert('Please scan pallet first');
        return false;
    }
    clear_transfer_note_form();
    $('#transfer_note_from').text(': ' + pallet_transfer_from);
    $('#transfer_note_to').text(': ' + pallet_transfer_to);
    $('#transfer_note_date').text(': ' + moment().format('YYYY-MM-DD'));
    

    $('#modal_transfer_note').modal('show');
}

async function edit_transfer_note(transfer_note_id){

    //## get transfer note data
    let transfer_note = await get_transfer_note(transfer_note_id);
    set_transfer_note_info(transfer_note)


    $('#modal_transfer_note').modal('show');
}

function insert_carton_to_table(carton_data){
    
    let transfer_note_detail_first_row = $('#transfer_note_detail tbody').find('td').length;
    if(transfer_note_detail_first_row <= 1) {
        $('#transfer_note_detail tbody').html('');
    };

    let row = `
        <tr class="text-center">
            <td>1</td>
            <td class="d-none"><input type="text" id="carton_barcode_id" name="carton_barcode_id" value="${carton_data.carton_id}"></td>
            <td class="d-none">${carton_data.carton_barcode}</td>
            <td>${carton_data.buyer_name}</td>
            <td>${carton_data.po_number}</td>
            <td>${carton_data.gl_number}</td>
            <td>${carton_data.carton_number}</td>
            <td>${carton_data.content}</td>
            <td>${carton_data.total_pcs}</td>
            <td><button type="button" class="btn btn-sm btn-danger">Delete</button></td>
        </tr>
    `;
    $('#transfer_note_detail tbody').append(row);
}


</script>
<script type="text/javascript">
// $('#modal_transfer_note').modal('show');

$('body').on('shown.bs.modal', '#modal_transfer_note', function () {
    $('input:visible:enabled:first', this).focus();
})


// ## Searching Pallet Info and Transfer Note inside Pallet by Pallet Barcode
$('#pallet_search_form').on('submit', async function(e){
    e.preventDefault();
    let pallet_serial_number = $('#pallet_serial_number').val();
    // ## If no Entry Barcode Skip;
    if (!pallet_serial_number) return false;
    
    let pallet_detail = await get_pallet_detail(pallet_serial_number);

    $('#pallet_serial_number').val('');
    if(!pallet_detail) return false; 

    set_pallet_info(pallet_detail.pallet_info);
    set_transfer_note_list(pallet_detail.transfer_note_list)

})

// ## Searching Carton by Carton Barcode and Insert into Transfer Note
$('#carton_barcode_search_form').on('submit', async function(e){
    e.preventDefault();
    let carton_barcode = $('#carton_barcode').val();
    let carton_detail = await get_carton_detail(carton_barcode);

    if(carton_detail){
        insert_carton_to_table(carton_detail);
    }

    // $('#carton_barcode').val('');
})

// ## Submit Data Transfer Note
$('#transfer_note_form').on('submit', async function(e){
    e.preventDefault();

    let transfer_note_issued_by = $('#transfer_note_issued_by').val();
    let transfer_note_authorized_by = $('#transfer_note_authorized_by').val();
    // let carton_detail = await get_carton_detail(carton_barcode);

    // if(carton_detail){
    //     insert_carton_to_table(carton_detail);
    // }

    // $('#carton_barcode').val('');
})


</script>
<?= $this->endSection('page_script'); ?>
