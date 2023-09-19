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
                        <button type="button" class="btn btn-success mb-2" id="btn_modal_create">New Transfer Note</button>
                        <table class="table table-bordered table-hover text-center" id="transfer_note_table">
                            <thead>
                                <tr class="table-primary text-center">
                                    <th width="">Transfer Note Number</th>
                                    <th width="">Issued By</th>
                                    <th width="">Authorized By</th>
                                    <th width="">Received By</th>
                                    <th width="">Received At</th>
                                    <th width="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<?= $this->endSection(); ?>



<?= $this->Section('page_script'); ?>
<script type="text/javascript">
const pallet_detail_url = '<?= url_to('pallet_transfer_pallet_detail')?>';


async function show_pallet_detail(pallet_serial_number) {
    params_data = {
        pallet_serial_number
    };
    result = await using_fetch(pallet_detail_url, params_data, "GET");

    if (result.status == 'error') {
        reset_pallet_info();
        show_flash_message({ error: result.message} )
        return false;
    }
    
    let pallet_info = result.data.pallet_info;
    // let is_packed = pallet_info.flag_packed == 'Y' ? true : false;
    let transfer_notes = result.data.transfer_notes;

    set_pallet_info(pallet_info);
    set_transfer_notes(transfer_notes)

    // $('#carton_barcode_show').text(pallet_serial_number);
    
    // if(carton_info.flag_packed == 'N') {
    //     $('#product_code').attr('disabled',false);
    //     $('#product_code').focus();
    // } else {
    //     $('#product_code').attr('disabled',true);
    //     $('#btn_pack_carton').attr('disabled',true);
    // }
}

function reset_pallet_info() {
    $('#pallet_number').text(': -');
    $('#pallet_status').text(': -');
    $('#location_from').text(': -');
    $('#location_to').text(': -');

    // let empty_row = `
    //     <tr class="text-center">
    //         <td colspan=8">Empty Data</td>
    //     </tr>
    // `;
    // $('#carton_detail_table tbody').html(empty_row);
    // $('#carton_detail_table tfoot').html('');

    // $('#product_code').attr('disabled',true);
    // $('#btn_pack_carton').attr('disabled',true);
}

function set_pallet_info(pallet_info) {
    $('#pallet_number').text(': ' + pallet_info.pallet_number);
    $('#pallet_status').text(': ' + pallet_info.status);
    $('#location_from').text(': ' + pallet_info.location_from);
    $('#location_to').text(': ' + pallet_info.location_to);
}

function set_transfer_notes(transfer_notes) {
    $('#transfer_note_table tbody').html('');

    let total = 0;
    transfer_notes.forEach((data, key) => {
        
        let row = `
            <tr class="text-center">
                <td class="product_code">${data.serial_number}</td>
                <td>${data.issued_by}</td>
                <td>${data.authorized_by}</td>
                <td>${data.received_by}</td>
                <td>${data.received_at}</td>
                <td>${data.received_at}</td>
            </tr>
        `;


        // if(!is_packed) {
        //     row = `
        //         <tr class="text-center">
        //             <td>${key+1}</td>
        //             <td class="product_code">${data.product_code}</td>
        //             <td>${data.product_name}</td>
        //             <td>${data.product_colour}</td>
        //             <td>${data.product_size}</td>
        //             <td class="product_qty">${data.product_qty}</td>
        //             <td class="scanned_count"> 0 </td>
        //             <td class="scanned_status"> <span class="badge bg-warning">Not Complete</span> </td>
        //         </tr>
        //     `;
        // } else {
        //     row = `
        //         <tr class="text-center">
        //             <td>${key+1}</td>
        //             <td class="product_code">${data.product_code}</td>
        //             <td>${data.product_name}</td>
        //             <td>${data.product_colour}</td>
        //             <td>${data.product_size}</td>
        //             <td class="product_qty">${data.product_qty}</td>
        //             <td class="scanned_count"> ${data.product_qty} </td>
        //             <td class="scanned_status"> <span class="badge bg-success">Complete</span> </td>
        //         </tr>
        //     `;
        // }
        $('#transfer_note_table tbody').append(row);

        // total += parseInt(data.product_qty);
    });
    // let row_footer = `
    //         <tr>
    //             <td colspan="5" class="text-right title_total">Total :</td>
    //             <td colspan="1" class="text-center total_product_qty">${total}</td>
    //             <td colspan="1" class="text-center total_scanned_count">0</td>
    //             <td colspan="1" class="text-center all_scanned_status"><span class="badge bg-warning">Not Complete</span></td>
    //         </tr>
    //     `;
    // $('#carton_detail_table tfoot').html(row_footer);

    // update_total_scanned();
    // check_all_status();
}


</script>
<script type="text/javascript">
$('#pallet_search_form').on('submit', function(e){
    e.preventDefault();
    let pallet_serial_number = $('#pallet_serial_number').val();
    // ## If no Entry Barcode Skip;
    if (!pallet_serial_number) return false;

    show_pallet_detail(pallet_serial_number);
    $('#pallet_serial_number').val('');
})
</script>
<?= $this->endSection('page_script'); ?>
