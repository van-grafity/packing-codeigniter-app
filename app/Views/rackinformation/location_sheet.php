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
                    <div class="col-sm-8 col-md-10 dt-custom-filter">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 label">
                                            <div>Area</div>
                                        </div>
                                        <div class="col-md-9 col-sm-6">
                                            <select name="filter_rack_area" id="filter_rack_area" class="form-control select2">
                                                <option value=""> Choose Rack Area </option>
                                                <?php foreach ($rack_area_list as $rack_area) : ?>
                                                    <option value="<?= $rack_area->area; ?>"> Area <?= $rack_area->area; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 label">
                                            <div>Level</div>
                                        </div>
                                        <div class="col-md-9 col-sm-6">
                                            <select name="filter_rack_level" id="filter_rack_level" class="form-control select2">
                                                <option value=""> Choose Rack Level </option>
                                                <?php foreach ($rack_level_list as $rack_level) : ?>
                                                    <option value="<?= $rack_level->level; ?>"> Level <?= $rack_level->level; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <a href="javascript:void(0)" type="button" class="btn btn-info mb-2" onclick="print_location_sheet()">Print Location Sheet</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="rack_table" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr class="table-primary">
                                    <th width="20px">No</th>
                                    <th width="100px">Rack Number</th>
                                    <th width="100px">GL Number</th>
                                    <th width="">PO Number</th>
                                    <th width="">Colour</th>
                                    <th width="">Buyer</th>
                                    <th width="20px">QTY CTN</th>
                                    <th width="20px">QTY PCS</th>
                                    <th width="20px">Level</th>
                                    <th width="100px">Transfer Note</th>
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
    const index_rack_location_list_url = '<?= url_to('rack_information_location_sheet_list')?>';
    const remove_pallet_from_rack_url = '<?= url_to('remove_pallet_from_rack')?>';
    const location_sheet_print_url = '<?= url_to('rack_information_location_sheet_print')?>';

    const remove_pallet = async (rack_id) => {
        params_data = { id : rack_id };
        result = await using_fetch(remove_pallet_from_rack_url, params_data, "GET");
        if(result.status == 'success') {
            swal_data = {
                'title' : result.message,
                'reload_option' : true,
            }
            swal_info(swal_data);
        } else {
            swal_data = {
                'title' : result.message,
            }
            swal_warning(swal_data);
        }
    }

    const print_location_sheet = () => {
        filter_rack_area = $('#filter_rack_area').val();
        filter_rack_level = $('#filter_rack_level').val();


        if(!filter_rack_area){
            data_alert = {
                title: 'Please select the Area first'
            }
            swal_warning(data_alert);
            return false;
        }

        let filter = {
            area : filter_rack_area,
            level : filter_rack_level,
        }

        filter_query_string = new URLSearchParams(filter).toString();
        url_with_params = `${location_sheet_print_url}?${filter_query_string}`;
        window.open(url_with_params, "_blank");
    }

</script>

<script>
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);
    

    $('#filter_rack_area, #filter_rack_level').select2();
    $('select.select2').on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

    let rack_table = $('#rack_table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: index_rack_location_list_url,
            data: function (d) {
                d.filter_rack_area = $('#filter_rack_area').val();
                d.filter_rack_level = $('#filter_rack_level').val();
            }
        },
        order: [],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'serial_number', name: 'rack.serial_number'},
            { data: 'gl_number'},
            { data: 'po_no'},
            { data: 'colour'},
            { data: 'buyer_name'},
            { data: 'total_carton', orderable: false, searchable: false},
            { data: 'total_pcs', orderable: false, searchable: false},
            { data: 'level', name: 'rack.level', orderable: false, searchable: false},
            { data: 'transfer_note', name: 'transfer_note'},
        ],
        columnDefs: [
            { targets: [0], orderable: false, searchable: false },
        ],
        paging: true,
        responsive: true,
        lengthChange: true,
        searching: true,
        autoWidth: false,
        orderCellsTop: true,
        dom: "<'row'<'col-md-2'l><'col-md-6'B><'col-md-4'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>",
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
                }
            },
        ]
    });

    $('#filter_rack_area, #filter_rack_level').change(function(event) {
        rack_table.ajax.reload();
    });

})
</script>

<?= $this->endSection('page_script'); ?>