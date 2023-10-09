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
                    <div class="col-sm-12 dt-custom-filter">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-8 label">
                                    <div>Status</div>
                                </div>
                                <div class="col-sm-4">
                                    <select name="rack_status" id="rack_status" class="form-control" required >
                                        <option value="">All Status</option>
                                        <option value="Y"> Empty </option>
                                        <option value="N"> Not Empty </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="rack_table" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr class="table-primary">
                            <th width="">No</th>
                            <th width="">Serial Number</th>
                            <th width="">GL No.</th>
                            <th width="">PO No.</th>
                            <th width="">Colour</th>
                            <th width="">Buyer</th>
                            <th width="">QTY CTN</th>
                            <th width="">QTY PCS</th>
                            <th width="">Level Rack</th>
                            <th width="">Action</th>
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


</script>
<script>
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);
    
    let rack_table = $('#rack_table').DataTable({
        processing: true,
        serverSide: true,
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
            { data: 'po_number'},
            { data: 'colour'},
            { data: 'buyer'},
            { data: 'total_carton'},
            { data: 'total_pcs'},
            { data: 'description', name: 'rack.description'},
            { data: 'action', name: 'action', orderable: false, searchable: false },
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
    });

    $('#rack_status').change(function(event) {
        rack_table.ajax.reload();
    });

})
</script>

<?= $this->endSection('page_script'); ?>