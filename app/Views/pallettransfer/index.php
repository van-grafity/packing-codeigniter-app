<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <a href="javascript:void(0)" type="button" class="btn btn-success mb-2" id="btn_new_pallet_transfer">New Pallet Transfer</a>
                <table id="pallet_transfer_table" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr class="table-primary">
                            <th width="30">No</th>
                            <th width="120">Transaction No.</th>
                            <th width="100">Pallet No.</th>
                            <th width="">Transfer Note</th>
                            <th width="70">Total Ctn</th>
                            <th width="">From</th>
                            <th width="">To</th>
                            <th width="100">Status</th>
                            <th width="170">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>


<!-- Modal Add and Edit Pallet Transfer -->
<div class="modal fade" id="modal_pallet_transfer" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="pallet_transfer_form">
                <input type="hidden" name="edit_pallet_transfer_id" value="" id="edit_pallet_transfer_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">New Pallet Transfer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pallet_serial_number" class="col-form-label">Pallet Number</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="pallet_serial_number" name="pallet_serial_number" placeholder="Pallet Barcode Here" onkeydown="search_pallet_input(this)">
                            <div class="ml-2">
                                <button type="button" class="btn btn-primary" id="btn_search_pallet" onclick="search_pallet(this);">Search Pallet</button>
                            </div>
                        </div>
                        <span id="pallet_serial_number_message" class="input-feedback d-none"></span>
                    </div>
                    <div class="form-group">
                        <label for="location_from" class="col-form-label">From :</label>
                        <select id="location_from" name="location_from" class="form-control" required disabled>
                            <option value="">Select Location From </option>
                            <?php foreach ($location as $location_from) : ?>
                                <option value="<?= $location_from->id; ?>"><?= $location_from->location_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location_to" class="col-form-label">To :</label>
                        <select id="location_to" name="location_to" class="form-control" required disabled>
                            <option value="">Select Location To </option>
                            <?php foreach ($location as $location_to) : ?>
                                <option value="<?= $location_to->id; ?>"><?= $location_to->location_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary disabled" disabled id="btn_submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit Pallet Transfer -->


<!-- Modal Delete Pallet Transfer-->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= url_to('pallet_transfer_delete')?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete Pallet Transfer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Data ?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="pallet_transfer_id" id="pallet_transfer_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete Pallet Transfer-->

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>

<script type="text/javascript">

const index_dt_url = '<?= url_to('pallet_transfer_list')?>';
const store_url = '<?= url_to('pallet_transfer_store')?>';
const update_url = '<?= url_to('pallet_transfer_update')?>';
const pallet_availability_url = '<?= url_to('pallet_transfer_check_pallet_availability')?>';
const detail_url = '<?= url_to('pallet_transfer_detail')?>';

let is_pallet_available = false;

//## function from js/utils.js
avoid_submit_on_enter();

async function get_pallet_detail(pallet_serial_number) {
    params_data = {
        pallet_serial_number
    };
    result = await using_fetch(pallet_availability_url, params_data, "GET");

    if (result.status == 'error') {
        is_pallet_available = false;
        toastr.error(result.message);
        $('#pallet_serial_number').val('');
        return false;
    }
    return result.data;
}

async function search_pallet(e){
    if($(e).hasClass('disabled')){ return false;} // ## avoid action when search button is disabled
    
    let pallet_serial_number = $('#pallet_serial_number').val();
    if(pallet_serial_number.length <= 0) {
        show_flash_message({ error: 'Please provide the Pallet Number'} )
        return false;
    }
    
    let pallet_detail = await get_pallet_detail(pallet_serial_number);

    $('#pallet_serial_number_message').removeClass('d-none');
    
    if(pallet_detail.pallet_status == true){
        is_pallet_available = true;

        $('#pallet_serial_number').addClass('is-valid');
        $('#pallet_serial_number').removeClass('is-invalid');
        
        $('#pallet_serial_number_message').addClass('success');
        $('#pallet_serial_number_message').removeClass('error');
        $('#pallet_serial_number_message').text(pallet_detail.feedback_title);

        enable_pallet_transfer_form();
        
        $('#location_from').focus();
    }

    if(pallet_detail.pallet_status == false){
        is_pallet_available = true;

        $('#pallet_serial_number').removeClass('is-valid');
        $('#pallet_serial_number').addClass('is-invalid');
        
        $('#pallet_serial_number_message').removeClass('success');
        $('#pallet_serial_number_message').addClass('error');
        $('#pallet_serial_number_message').text(pallet_detail.feedback_title + '. ' + pallet_detail.feedback_message)
        disable_pallet_transfer_form();
    }
}


const edit_pallet_transfer = async (pallet_transfer_id) => {
    params_data = { id : pallet_transfer_id };
    result = await using_fetch(detail_url, params_data, "GET");

    pallet_transfer_data = result.data
    $('#edit_pallet_transfer_id').val(pallet_transfer_data.id);
    $('#pallet_serial_number').val(pallet_transfer_data.pallet_serial_number);
    $('#location_from').val(pallet_transfer_data.location_from_id);
    $('#location_to').val(pallet_transfer_data.location_to_id);
    
    $('#pallet_transfer_form').attr('action',update_url);
    $('#modal_pallet_transfer').modal('show');
    
    is_pallet_available = true;
    disable_search_pallet();
    enable_pallet_transfer_form();
}

const delete_pallet_transfer = (pallet_transfer_id) => {
    $('#delete_message').text(`Are you sure want to delete this Pallet?`);
    $('#pallet_transfer_id').val(pallet_transfer_id);
    $('#delete_modal').modal('show');
}

// ## For Searching Pallet when Entered
function search_pallet_input(e) {
    if(event.key === 'Enter') {
        search_pallet();
        return false;   
    }
}

//## Toggling Form
function enable_pallet_transfer_form() {
    $('#location_from').attr('disabled', false);
    $('#location_to').attr('disabled', false);
    $('#btn_submit').attr('disabled', false);
    $('#btn_submit').removeClass('disabled');
}

function disable_pallet_transfer_form() {
    $('#location_from').attr('disabled', true);
    $('#location_to').attr('disabled', true);
    $('#btn_submit').attr('disabled', true);
    $('#btn_submit').addClass('disabled');
}

function enable_search_pallet() {
    $('#pallet_serial_number').attr('disabled', false);
    $('#btn_submit').attr('disabled', false);
    $('#btn_search_pallet').removeClass('disabled');
}

function disable_search_pallet() {
    $('#pallet_serial_number').attr('disabled', true);
    $('#btn_submit').attr('disabled', true);
    $('#btn_search_pallet').addClass('disabled');
}

function is_location_valid() {
    let location_from = $('#location_from').val();
    let location_to = $('#location_to').val();

    if(location_from == location_to) {
        return false;
    }
    return true;
}


</script>

<script type="text/javascript">

// ## Show Flash Message
let session = <?= json_encode(session()->getFlashdata()) ?>;
show_flash_message(session);

$('#pallet_transfer_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: index_dt_url,
    order: [],
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'transaction_number', name: 'tblpallettransfer.transaction_number'},
        { data: 'pallet_serial_number', name: 'pallet.serial_number'},
        { data: 'transfer_note', name: 'transfer_note.serial_number', orderable: false, searchable: false},
        { data: 'total_carton', name: 'total_carton', orderable: false, searchable: false },
        { data: 'location_from', name: 'location_from.location_name' },
        { data: 'location_to', name: 'location_to.location_name' },
        { data: 'status', name: 'status', orderable: false, searchable: false},
        { data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    columnDefs: [
        { targets: [0,-1], orderable: false, searchable: false },
    ],
    paging: true,
    responsive: true,
    lengthChange: true,
    searching: true,
    autoWidth: false,
    orderCellsTop: true,
    initComplete: function( settings, json ) 
    {
        var indexColumn = 0;
        this.api().columns().every(function () 
        {
            var column      = this;
            var input       = document.createElement("input");
            if(indexColumn > 0 && indexColumn < 7) {
                $(input).attr( 'placeholder', 'Search' )
                        .addClass('form-control form-control-sm')
                        .appendTo( $('.filterhead:eq('+indexColumn+')').empty() )
                        .on('input', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
            }
            indexColumn++;
        });
    },
});

$('#btn_new_pallet_transfer').on('click', function (){
    clear_form({
        modal_id: 'modal_pallet_transfer',
        modal_title: "New Pallet Transfer",
        modal_btn_submit: "Save",
        form_action_url: store_url,
    });
    $('#modal_pallet_transfer').modal('show');
    
    is_pallet_available = false;
    enable_search_pallet();
    disable_pallet_transfer_form();
})

$('#modal_pallet_transfer').on('hidden.bs.modal', function () {

    $('#pallet_serial_number').removeClass('is-invalid is-valid');

    $('#pallet_serial_number_message').removeClass('success');
    $('#pallet_serial_number_message').removeClass('error');
    $('#pallet_serial_number_message').addClass('d-none');
    $('#pallet_serial_number_message').text('');

});

$('body').on('shown.bs.modal', '#modal_pallet_transfer', function () {
    $('input:visible:enabled:first', this).focus();
})

$('#pallet_transfer_form').on('submit', function () {
    if(!is_pallet_available) { return false; }
    if(!is_location_valid()){
        show_flash_message({ error: 'The origin location and destination location cannot be the same'} )
        return false;
    }
})
</script>

<?= $this->endSection('page_script'); ?>