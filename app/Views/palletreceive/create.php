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

                            <dt class="col-md-5 col-sm-12">Total All Carton</dt>
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

                <div id="transfer_note_list_area" class="mb-5">
                    <h4 class="title mb-3">Transfer Note List : </h4>
                </div>

                <form action="<?= url_to('pallet_receive_store') ?>" method="post" id="pallet_receive_form">
                    <?= csrf_field(); ?>
                    <input type="hidden" id="pallet_transfer_id" name="pallet_transfer_id">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="received_by" class="col-form-label mr-2">Received By :</label>
                                    <input type="text" class="form-control" id="received_by" name="received_by">
                                </div>
                            </div>    
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="rack" class="col-form-label mr-2">Rack :</label>
                                    <select id="rack" name="rack" class="form-control select2" required disabled="disabled">
                                        <option value=""> Select Rack </option>
                                        <?php foreach ($racks as $rack) : ?>
                                            <option value="<?= $rack->id; ?>"><?= $rack->serial_number; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary ml-2" id="btn_pallet_to_rack" disabled="disabled">Send Pallet to Rack</button>
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
$(document).ready(function() {

    $('#rack.select2').select2({});

    $('#rack.select2').on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

    
    $('#pallet_barcode_form').on('submit', async function(e) {
        e.preventDefault();
        let pallet_barcode = $('#pallet_barcode').val();
        // ## If no Entry Barcode, Skip;
        if (!pallet_barcode) return false;

        let data = await get_pallet_transfer_detail(pallet_barcode)
        $('#pallet_barcode').val('');

        clear_pallet_transfer_info();
        clear_transfer_note_list();

        if(!data) return false;

        if(data.pallet_transfer.flag_transferred == 'Y') {
            show_flash_message({ error: "Pallet already at warehouse!"} )
        } else {
            $('#btn_pallet_to_rack').attr('disabled', false);
            $('#rack').prop('disabled', false);
        }

        set_pallet_transfer_info(data.pallet_transfer);
        if(data.transfer_note_list) {
            set_transfer_note_list(data.transfer_note_list);
        }
    });

    clear_pallet_transfer_info();

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

    $('#pallet_transfer_id').val(pallet_transfer_info.pallet_transfer_id);
}

function clear_pallet_transfer_info() {
    $('#pallet_number').text(': - ');
    $('#pallet_status').text(': - ');
    $('#pallet_total_carton').text(': - ');
    $('#location_from').text(': - ');
    $('#location_to').text(': - ');

    $('#pallet_transfer_id').val('');
    $('#btn_pallet_to_rack').attr('disabled', true);
    $('#rack').prop('disabled', true);
}

const clear_transfer_note_list = () => {
    $('#transfer_note_list_area').children(':not(.title.mb-3)').remove();
};

const set_transfer_note_list = (transfer_note_data_list) => {
    let transfer_note_list_area = $('#transfer_note_list_area');

    transfer_note_data_list.forEach(transfer_note_data => {

        let cartons_list = transfer_note_data.carton_in_transfer_note.map(carton => `
            <tr>
                <td>${carton.buyer_name}</td>
                <td>${carton.po_number}</td>
                <td>${carton.gl_number}</td>
                <td>${carton.carton_number}</td>
                <td>${carton.content}</td>
                <td>${carton.total_pcs}</td>
            </tr>`
        ).join('');

        let total_cartons = transfer_note_data.carton_in_transfer_note.length;
        let total_pcs = transfer_note_data.carton_in_transfer_note.reduce((total, carton) => {
            return total + carton.total_pcs;
        }, 0);

        let card_element = `
            <div class="card mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="">Transfer Note : ${transfer_note_data.serial_number}</h5>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="max-height: 500px;">
                    <table class="table table-sm table-bordered text-center table-head-fixed table-foot-fixed text-nowrap">
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
                            ${cartons_list}
                        </tbody>
                        <tfoot class="bg-dark">
                            <tr>
                                <td colspan="3">Total Carton</td>
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

</script>
<?= $this->endSection('page_script'); ?>