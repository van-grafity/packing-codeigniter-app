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

                <div id="transfer_note_list_area" class="mb-5">
                    <h4 class="title mb-3">Transfer Note List : </h4>
                </div>

                <div class="progress progress-xxs mb-5">
                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">20% Complete</span>
                    </div>
                </div>
                <h3 class="mb-3">Carton List for Loading : </h3>
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
                    <div class="col-lg-6 col-md-4 col-sm-12">
                        <div class="ml-2">
                            <button type="button" class="btn bg-navy btn-select-carton" onclick="select_all_carton()" >Select All Carton</button>
                        </div>
                    </div>
                </div>

                <div class="card mb-5">
                    <form action="<?= url_to('carton_loading_store') ?>" id="scanned_carton_form" method="POST">
                        <?= csrf_field(); ?>
                        <input type="hidden" id="rack_id" name="rack_id">
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

    $('#rack_id').val(pallet_transfer_info.rack_id);
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

const get_carton_in_pallet = (carton_barcode) => {
    let product_row = $("#transfer_note_list_area table tbody .carton-barcode").filter(function() {
        return $(this).text() == carton_barcode;
    }).closest("tr");

    if(product_row.length <= 0) {
        return false;
    } else {
        return product_row;
    }
}

const get_transfer_note_table = (carton_barcode) => {
    let transfer_note_table = $("#transfer_note_list_area table tbody .carton-barcode").filter(function() {
        return $(this).text() == carton_barcode;
    }).closest("table");

    if(transfer_note_table.length <= 0) {
        return false;
    } else {
        return transfer_note_table;
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


const clear_transfer_note_list = () => {
    $('#transfer_note_list_area').children(':not(.title.mb-3)').remove();
};

const set_transfer_note_list = (transfer_note_data_list) => {
    let transfer_note_list_area = $('#transfer_note_list_area');

    transfer_note_data_list.forEach(transfer_note_data => {

        // ## skip iterations if no carton in transfer note
        if(!transfer_note_data.carton_in_transfer_note) { return; }

        let cartons_list = transfer_note_data.carton_in_transfer_note.map(carton => `
            <tr class="text-center count-carton">
                <td class="d-none">
                    <input type="text" name="carton_barcode_id[]" value="${carton.carton_id}">
                </td>
                <td class="carton-barcode">${carton.carton_barcode}</td>
                <td>${carton.buyer_name}</td>
                <td>${carton.po_number}</td>
                <td>${carton.gl_number}</td>
                <td>${carton.carton_number}</td>
                <td>${carton.content}</td>
                <td class="total-pcs-in-carton">${carton.total_pcs}</td>
            </tr>`
        ).join('');

        let total_cartons = transfer_note_data.carton_in_transfer_note.length;
        let total_pcs = transfer_note_data.carton_in_transfer_note.reduce((total, carton) => {
            return total + carton.total_pcs;
        }, 0);


        // todo : ini ada sedikit keraguan. apakah perlu untuk menampilkan tabel dari transfer note yang sudah kosong? karena kalau tidak di tampilkan makan tidak perlu menambahkan attr disabled di sini

        // ## set btn for select carton to disabled if no carton in transfer note
        let disabled_attr = (total_cartons <= 0) ? 'disabled="disabled"' : '';

        let card_element = `
            
            <div class="card mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="">Transfer Note : ${transfer_note_data.serial_number}</h5>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn bg-navy btn-select-carton" onclick="select_carton_in_transfer_note(this)" ${disabled_attr} >Select Transfer Note</button>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="max-height: 500px;">
                    <table class="table table-sm table-bordered text-center table-head-fixed table-foot-fixed text-nowrap">
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
                            ${cartons_list}
                        </tbody>
                        <tfoot class="bg-dark">
                            <tr>
                                <td colspan="4">Total Carton</td>
                                <td colspan="1"> ${total_cartons} </td>
                                <td colspan="1">Total Pcs</td>
                                <td colspan="1"> ${total_pcs} </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        `;

        transfer_note_list_area.append(card_element);
    });
}


// ## function for update total carton and pcs in transfer note table
const update_total_each_transfernote = (table) => {
    table = $(table);
    let tbody = table.find('tbody');
    let tfoot = table.find('tfoot');
    let total_row = tbody.children('tr').length;

    // ## Update total carton at footer depand on tbody row length
    tfoot.find('tr td:eq(1)').text(`${total_row}`);
    

    let array_total_pcs = table.find(`tbody tr td.total-pcs-in-carton`).map(function() {
        return parseInt($(this).text());
    }).get();
    
    // ## update total pcs at footer, get sum from column with .total-pcs-in-carton class
    let total_pcs = array_total_pcs.reduce((tempSum, next_arr) => tempSum + parseInt(next_arr), 0);
    tfoot.find('tr td:eq(3)').text(`${total_pcs}`);
    

    // ## show default tbody if no carton
    let transfernote_table_first_row = table.find('tbody td').length;
    if(transfernote_table_first_row <= 1) {
        let empty_row = `
            <tr>
                <td colspan="7"> There's No Carton </td>
            </tr>
        `;
        table.find('tbody').html(empty_row);
    };
};


// ## Select all carton on the pallet and move to scanned carton list
const select_all_carton = () => {
    let all_carton_in_pallet = $("#transfer_note_list_area table tbody tr");
    all_carton_in_pallet.each((index, carton_tr) => {
        // ## avoid insert empty data row
        if($(carton_tr).find('td').length > 1){
            insert_carton_to_scanned_table(carton_tr)
        }
    });
    
    // ## select all table transfer note and update total on footer
    let transfer_note_table_list = $("#transfer_note_list_area table");
    transfer_note_table_list.each((index, transfer_note_table) => {
        update_total_each_transfernote(transfer_note_table)
    });

    disabled_select_carton_button();
}

const select_carton_in_transfer_note = (element) => {
    let card_element = $(element).parents()[2];
    let all_carton_in_transfer_note = $(card_element).find('table tbody tr');
    all_carton_in_transfer_note.each((index, carton_tr) => {
        insert_carton_to_scanned_table(carton_tr)
    });

    let transfer_note_table = $(card_element).find('table');
    transfer_note_table.each((index, table) => {
        update_total_each_transfernote(table)
    });

    disabled_select_carton_button(element);
    
    check_all_transfer_note_table();
}


const disabled_select_carton_button = (btn_element = false) => {
    // ## disables the select carton button. this function has optional parameters, if no options/params are entered, all buttons will be disabled
    if(!btn_element) {
        $('.btn-select-carton').attr('disabled', true);
    }
    $(btn_element).attr('disabled', true);
}

const enabled_select_carton_button = (btn_element = false) => {
    if(!btn_element) {
        $('.btn-select-carton').attr('disabled', false);
    }
    $(btn_element).attr('disabled', false);
}

const is_table_empty = (table) => {
    // ## check the table are empty or not. the method is just count td element. if only 1 or less it means no data in the table
    let count_td = $(table).find('tbody td').length;
    if (count_td <= 1) {
        return true;
    }
    return false;
}

const check_all_transfer_note_table = () => {
    let flag_empty = true;
    let transfer_note_table_list = $("#transfer_note_list_area table");
    transfer_note_table_list.each((index, transfer_note_table) => {
        if(!is_table_empty(transfer_note_table)){
            flag_empty = false;
        }
    });

    if(flag_empty){
        disabled_select_carton_button()
    }
}

</script>


<script type="text/javascript">
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);

    // ## Default Page Condition
    disabled_select_carton_button();

    // ## Scan Pallet for search carton on the pallet
    $('#pallet_barcode_form').on('submit', async function(e) {
        e.preventDefault();
        let pallet_barcode = $('#pallet_barcode').val();
        // ## If no Entry Barcode, Skip;
        if (!pallet_barcode) return false;

        let data = await get_carton_by_pallet_barcode(pallet_barcode)
        $('#pallet_barcode').val('');

        clear_pallet_transfer_info();
        clear_transfer_note_list();
        clear_scanned_carton();

        if(!data) return false;

        set_pallet_transfer_info(data.pallet_transfer);
        
        if(data.transfer_note_list) {
            set_transfer_note_list(data.transfer_note_list);
        }

        $('#scan_carton_barcode').focus();

        enabled_select_carton_button()
    });

    // ## Scan Carton Barcode for Loading
    $('#scan_carton_barcode_form').on('submit', function(e) {
        e.preventDefault();
        let scan_carton_barcode = $('#scan_carton_barcode').val();

        // ## If no Entry Barcode, Skip;
        if (!scan_carton_barcode) return false;

        let carton_data = get_carton_in_pallet(scan_carton_barcode)
        if(!carton_data){ 
            toastr.error('Invalid Carton Barcode!');
            $('#scan_carton_barcode').val('');
            return false;
        }
        let transfer_note_table = get_transfer_note_table(scan_carton_barcode);
        
        insert_carton_to_scanned_table(carton_data[0]);
        update_total_each_transfernote(transfer_note_table[0]);
        
        $('#scan_carton_barcode').val('');
        $('#scan_carton_barcode').focus();

        check_all_transfer_note_table();
    });

    // ## load all selection carton
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