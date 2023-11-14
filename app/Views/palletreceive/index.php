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
                <table id="pallet_receive_table" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr class="table-primary">
                            <th width="30">No</th>
                            <th width="100">Pallet SN</th>
                            <th width="">Transfer Note</th>
                            <th width="70">Total Ctn</th>
                            <th width="">From</th>
                            <th width="100">Status</th>
                            <th width="100">Rack</th>
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

<!-- Modal Receive Pallet -->
<div class="modal fade" id="modal_rack_pallet" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="rack_pallet_form">
                <input type="hidden" name="pallet_transfer_id" value="" id="pallet_transfer_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Receive Pallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rack" class="col-form-label">Rack :</label>
                        <select id="rack" name="rack" class="form-control select2" required>
                            <option value=""> Select Rack </option>
                            <?php foreach ($racks as $rack) : ?>
                                <option value="<?= $rack->id; ?>"><?= $rack->serial_number; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Receive Pallet -->


<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>



<script type="text/javascript">
    const index_dt_url = '<?= url_to('pallet_receive_list')?>';
    const store_url = '<?= url_to('pallet_receive_store')?>';

    function receive_pallet(pallet_transfer_id){
        $('#pallet_transfer_id').val(pallet_transfer_id);
        $('#rack_pallet_form').attr('action', store_url);
        $('#modal_rack_pallet').modal('show');
    }
</script>


<script type="text/javascript">

// ## Show Flash Message
let session = <?= json_encode(session()->getFlashdata()) ?>;
show_flash_message(session);

$('#rack.select2').select2({
    dropdownParent: $('#modal_rack_pallet')
});

$('#rack.select2').on('select2:open', function (e) {
    document.querySelector('.select2-search__field').focus();
});

$('#pallet_receive_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: index_dt_url,
    order: [],
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'pallet_serial_number', name: 'pallet.serial_number'},
        { data: 'transfer_note', name: 'transfer_note.serial_number', orderable: false, searchable: false},
        { data: 'total_carton', name: 'total_carton', orderable: false, searchable: false },
        { data: 'location_from', name: 'location_from.location_name' },
        { data: 'status', name: 'status', orderable: false, searchable: false},
        { data: 'rack', name: 'rack.serial_number' },
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

</script>

<?= $this->endSection('page_script'); ?>