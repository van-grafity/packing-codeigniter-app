<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
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
                    <div class="col-sm-6">
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">Pallet No. </dt>
                            <dd class="col-md-7 col-sm-12" id="pallet_number">: <?= $pallet_transfer->pallet_serial_number ?> </dd>

                            <dt class="col-md-5 col-sm-12">Status</dt>
                            <dd class="col-md-7 col-sm-12" id="pallet_status">: <?= $pallet_transfer->status ?> </dd>

                            <dt class="col-md-5 col-sm-12">Total Carton</dt>
                            <dd class="col-md-7 col-sm-12" id="pallet_total_carton">: <?= $pallet_transfer->total_carton ?> </dd>
                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">From</dt>
                            <dd class="col-md-7 col-sm-12" id="location_from">: <?= $pallet_transfer->location_from ?> </dd>

                            <dt class="col-md-5 col-sm-12">To</dt>
                            <dd class="col-md-7 col-sm-12" id="location_to">: <?= $pallet_transfer->location_to ?> </dd>
                        </dl>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="title">Transfer Notes</h4>
                        <button type="button" class="btn btn-success mb-2 <?= $btn_transfer_note_class ?>" id="btn_modal_create_transfer_note" onclick="create_transfer_note(this)">New Transfer Note</button>
                        <button type="button" class="btn btn-info mb-2 <?= $btn_transfer_note_class ?>" id="btn_modal_complete_preparation" onclick="complete_preparation(this)">Completing Preparation</button>
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
                                <?php if(!$transfer_note_list) :?>
                                    <tr>
                                        <td colspan="7">There's no Transfer Note</td>
                                    </tr>
                                <?php endif?>
                                <?php foreach ($transfer_note_list as $key => $transfer_note) : ?>
                                    <tr class="text-center">
                                        <td class="product_code"><?= $transfer_note->serial_number ?></td>
                                        <td><?= $transfer_note->issued_by ?></td>
                                        <td><?= $transfer_note->authorized_by ?></td>
                                        <td><?= $transfer_note->total_carton ?></td>
                                        <td><?= $transfer_note->received_by ?></td>
                                        <td><?= $transfer_note->received_at ?></td>
                                        <td>
                                            <button type="button" 
                                                class="btn btn-sm btn-primary <?= $btn_transfer_note_class ? 'd-none' : '' ?>" 
                                                onclick="edit_transfer_note(<?= $transfer_note->id ?>)">
                                                Edit
                                            </button>
                                            <button type="button" 
                                                class="btn btn-sm btn-danger <?= $btn_transfer_note_class ? 'd-none' : '' ?>" 
                                                onclick="delete_transfer_note(<?= $transfer_note->id ?>)">
                                                Delete
                                            </button>
                                            <a type="button" href="<?= url_to('pallet_transfer_transfer_note_print',$transfer_note->id)?>" class="btn btn-sm btn-info" target="_blank">Print</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
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
                                <dd class="col-md-7 col-sm-12" id="transfer_note_from">: <?= $pallet_transfer->location_from ?> </dd>

                                <dt class="col-md-5 col-sm-12">To</dt>
                                <dd class="col-md-7 col-sm-12" id="transfer_note_to">: <?= $pallet_transfer->location_to ?> </dd>
                            </dl>
                        </div>
                        <div class="col-sm-6">
                            <dl class="row">
                                <dt class="col-md-5 col-sm-12">Date</dt>
                                <dd class="col-md-7 col-sm-12" id="transfer_note_date">: <?= date('Y-m-d') ?> </dd>

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
                    <input type="hidden" name="pallet_transfer_id" value="<?= $pallet_transfer->id ?>" id="pallet_transfer_id">

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


<!-- Modal Delete Transfer Note-->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= url_to('pallet_transfer_transfer_note_delete')?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete Transfer Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Transfer Note ?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="delete_transfer_note_id" id="delete_transfer_note_id">
                    <input type="hidden" name="transfer_note_pallet_transfer_id" value="<?= $pallet_transfer->id ?>" id="transfer_note_pallet_transfer_id">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete Transfer Note-->

<?= $this->endSection(); ?>

<?= $this->Section('page_script'); ?>
<script type="text/javascript">

const carton_detail_url = '<?= url_to('pallet_transfer_carton_detail')?>';
const transfer_note_store_url = '<?= url_to('pallet_transfer_transfer_note_store')?>';
const transfer_note_update_url = '<?= url_to('pallet_transfer_transfer_note_update')?>';
const transfer_note_detail_url = '<?= url_to('pallet_transfer_transfer_note_detail')?>';
const complete_preparation_url = '<?= url_to('pallet_transfer_complete_preparation')?>';


async function get_carton_detail(carton_barcode){
    params_data = {
        carton_barcode
    };
    result = await using_fetch(carton_detail_url, params_data, "GET");

    if (result.status == 'error') {
        show_flash_message({ error: result.message} )
        return false;
    }
    
    return result.data;
}

function create_transfer_note(element){
    if($(element).hasClass('disabled')){ return false };

    clear_transfer_note_form();
    clear_form({
        modal_id: 'modal_transfer_note',
        modal_title: "New Transfer Note",
        modal_btn_submit: "Create Transfer Note",
        form_action_url: transfer_note_store_url,
    });
    $('#modal_transfer_note').modal('show');
}

async function complete_preparation(element){
    if($(element).hasClass('disabled')){ return false };

    let data = {
        title: 'Are preparations complete?',
        text: 'After compliting preparation, you cannot change any data on this pallet',
        confirm_button: 'Yes Complete',
    }
    let confirm_action = await swal_confirm(data);
    if(!confirm_action) { return false; };

    let params_data = { 
        pallet_transfer_id : '<?= $pallet_transfer->id ?>', 
    };
    result = await using_fetch(complete_preparation_url, params_data, "GET");

    if(result.status == "success"){
        swal_info({
            title : result.message,
            reload_option : true,
        });
        $(element).addClass('disabled');
    } else {
        swal_failed({ title: result.message, text:result.data.message_text });
    }
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


function insert_carton_to_table(carton_data){
    
    let transfer_note_detail_first_row = $('#transfer_note_detail tbody').find('td').length;
    if(transfer_note_detail_first_row <= 1) {
        $('#transfer_note_detail tbody').html('');
    };

    let row = `
        <tr class="text-center count-carton">
            <td></td>
            <td class="d-none">
                <input type="text" id="carton_barcode_id" name="carton_barcode_id[]" value="${carton_data.carton_id}">
            </td>
            <td class="d-none carton-barcode">${carton_data.carton_barcode}</td>
            <td>${carton_data.buyer_name}</td>
            <td>${carton_data.po_number}</td>
            <td>${carton_data.gl_number}</td>
            <td>${carton_data.carton_number}</td>
            <td>${carton_data.content}</td>
            <td class="total-pcs-in-carton">${carton_data.total_pcs}</td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="delete_carton(this)">Delete</button></td>
        </tr>
    `;
    $('#transfer_note_detail tbody').append(row);

    update_total_in_transfernote_detail();
}

function is_already_inputed(carton_barcode){
    if ($(`#transfer_note_detail tr td.carton-barcode:contains(${carton_barcode})`).length > 0) {
        return true;
    } else {
        return false;
    }
}

function delete_carton(element) {
    $(element).parents('tr').remove();
    update_total_in_transfernote_detail();
    if (is_table_empty()) {
        clear_transfer_note_detail();
    }
}

function update_total_in_transfernote_detail() {
    let total_carton = $(`#transfer_note_detail tbody tr.count-carton`).length;
    $('#transfer_note_detail_total_carton').text(parseInt(total_carton));

    let array_total_pcs = $(`#transfer_note_detail tbody tr td.total-pcs-in-carton`).map(function() {
        return parseInt($(this).text());
    }).get();
    
    let sum_total_pcs = array_total_pcs.reduce((tempSum, next_arr) => tempSum + parseInt(next_arr), 0);
    $('#transfer_note_detail_total_pcs').text(sum_total_pcs);

    update_row_numbers({table_id : 'transfer_note_detail'});
}

function is_table_empty() {
    let count_first_element = $(`#transfer_note_detail tbody tr td`).length;
    if (count_first_element <= 1) {
        return true;
    }
    return false;
}


async function edit_transfer_note(transfer_note_id){
    clear_transfer_note_form();

    clear_form({
        modal_id: 'modal_transfer_note',
        modal_title: "Edit Transfer Note",
        modal_btn_submit: "Update Transfer Note",
        form_action_url: transfer_note_update_url,
    });

    //## get transfer note data
    let transfer_note = await get_transfer_note(transfer_note_id);
    
    set_transfer_note_info(transfer_note.transfer_note);
    if(transfer_note.transfer_note_detail) {
        set_transfer_note_carton_list(transfer_note.transfer_note_detail);
    }

    $('#modal_transfer_note').modal('show');
}

function delete_transfer_note(transfer_note_id){
    $('#delete_transfer_note_id').val(transfer_note_id);
    $('#delete_modal').modal('show');
}

async function get_transfer_note(transfer_note_id){
    params_data = {
        transfer_note_id
    };
    result = await using_fetch(transfer_note_detail_url, params_data, "GET");

    if (result.status == 'error') {
        show_flash_message({ error: result.message} )
        return false;
    }
    
    return result.data;
}

function set_transfer_note_info(transfer_note_info) {
    $('#edit_transfer_note_id').val(transfer_note_info.id);
    $('#transfer_note_serial_number').text(': ' + transfer_note_info.serial_number);
    $('#transfer_note_issued_by').val(transfer_note_info.issued_by);
    $('#transfer_note_authorized_by').val(transfer_note_info.authorized_by);
}

function set_transfer_note_carton_list(transfer_note_detail){
    if(transfer_note_detail.length <= 0) return false;

    transfer_note_detail.forEach(carton_data => {
        insert_carton_to_table(carton_data);
    });
}

</script>

<script type="text/javascript">
$(document).ready(function() {
    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);

    // ## Searching Carton by Carton Barcode and Insert into Transfer Note
    $('#carton_barcode_search_form').on('submit', async function(e){
        e.preventDefault();
        let carton_barcode = $('#carton_barcode').val();

        if (!carton_barcode) {
            show_flash_message({ error: "Please input Carton Barcode!" });
            return false;
        };
        if (is_already_inputed(carton_barcode)) {
            show_flash_message({ error: "This Carton has been inputed!" });
            return false;
        };

        let carton_detail = await get_carton_detail(carton_barcode);
        if(carton_detail){
            insert_carton_to_table(carton_detail);
        }

        $('#carton_barcode').val('');
    })

})

</script>
<?= $this->endSection('page_script'); ?>
