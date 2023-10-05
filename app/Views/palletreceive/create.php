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
                <div class="card-title">Receive Pallet</div>
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
                        </dl>
                    </div>
                </div>

                <h4>Carton List : </h4>
                    
                <table id="pallet_transfer_detail" class="table table-sm table-bordered text-center">
                    <thead>
                        <tr>
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
                            <td colspan="8"> There's No Carton in this Pallet</td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-dark">
                        <tr>
                            <td colspan="3">Total Carton</td>
                            <td colspan="1" id="pallet_transfer_detail_total_carton"> - </td>
                            <td colspan="1">Total Pcs</td>
                            <td colspan="1" id="pallet_transfer_detail_total_pcs"> - </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
$(document).ready(function() {

    $('#pallet_barcode_form').on('submit', async function(e) {
        e.preventDefault();
        let pallet_barcode = $('#pallet_barcode').val();
        // ## If no Entry Barcode, Skip;
        if (!pallet_barcode) return false;

        let data = await get_pallet_transfer_detail(pallet_barcode)
        $('#pallet_barcode').val('');
        $('#pallet_barcode').focus();

        clear_pallet_transfer_info();
        clear_carton_list();

        if(!data) return false;

        set_pallet_transfer_info(data.pallet_transfer);
        if(data.pallet_transfer_detail) {
            set_transfer_note_carton_list(data.pallet_transfer_detail);
        }
    });

})
</script>

<script type="text/javascript">
const pallet_transfer_detail_url = '<?= url_to('pallet_receive_pallet_transfer_detail')?>';

async function get_pallet_transfer_detail(pallet_barcode) {
    params_data = {
        pallet_barcode
    };
    result = await using_fetch(pallet_transfer_detail_url, params_data, "GET");
    
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
}

function set_transfer_note_carton_list(pallet_transfer_detail){
    if(pallet_transfer_detail.length <= 0) return false;

    pallet_transfer_detail.forEach(carton_data => {
        insert_carton_to_table(carton_data);
    });
}

function insert_carton_to_table(carton_data){
    let pallet_transfer_detail_first_row = $('#pallet_transfer_detail tbody').find('td').length;
    if(pallet_transfer_detail_first_row <= 1) {
        $('#pallet_transfer_detail tbody').html('');
    };

    let row = `
        <tr class="text-center count-carton">
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
        </tr>
    `;
    $('#pallet_transfer_detail tbody').append(row);

    update_total_in_transfernote_detail();
}

function update_total_in_transfernote_detail() {
    let total_carton = $(`#pallet_transfer_detail tbody tr.count-carton`).length;
    $('#pallet_transfer_detail_total_carton').text(parseInt(total_carton));

    let array_total_pcs = $(`#pallet_transfer_detail tbody tr td.total-pcs-in-carton`).map(function() {
        return parseInt($(this).text());
    }).get();
    
    let sum_total_pcs = array_total_pcs.reduce((tempSum, next_arr) => tempSum + parseInt(next_arr), 0);
    $('#pallet_transfer_detail_total_pcs').text(sum_total_pcs);
}

function clear_pallet_transfer_info() {
    $('#pallet_number').text(': - ');
    $('#pallet_status').text(': - ');
    $('#pallet_total_carton').text(': - ');
    $('#location_from').text(': - ');
    $('#location_to').text(': - ');
}

function clear_carton_list(){
    let empty_row = `
        <tr>
            <td colspan="8"> There's No Carton</td>
        </tr>`;
    $('#pallet_transfer_detail tbody').html(empty_row);
}

</script>
<?= $this->endSection('page_script'); ?>