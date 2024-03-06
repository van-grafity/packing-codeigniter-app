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
                            <th width="100px">Pallet</th>
                            <th width="100px">Transfer Note</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
    const index_dt_url = '<?= url_to('rack_information_list')?>';
    const remove_pallet_from_rack_url = '<?= url_to('remove_pallet_from_rack')?>';

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

</script>

<script>
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);
    
    let rack_table = $('#rack_table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: index_dt_url,
            data: function (d) {
                d.rack_status = $('#rack_status').val();
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
            { data: 'pallet_serial_number', name: 'pallet.serial_number'},
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
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                }
            },
        ]
    });

    $('#rack_status').change(function(event) {
        rack_table.ajax.reload();
    });

})
</script>

<?= $this->endSection('page_script'); ?>