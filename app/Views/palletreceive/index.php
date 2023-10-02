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


<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>

<script type="text/javascript">

const index_dt_url = '<?= url_to('pallet_receive_list')?>';

</script>

<script type="text/javascript">

// ## Show Flash Message
let session = <?= json_encode(session()->getFlashdata()) ?>;
show_flash_message(session);

$('#pallet_receive_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: index_dt_url,
    order: [],
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'pallet_serial_number', name: 'pallet.serial_number'},
        { data: 'transfer_note', name: 'transfer_note.serial_number'},
        { data: 'total_carton', name: 'total_carton', orderable: false, searchable: false },
        { data: 'location_from', name: 'location_from.location_name' },
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

</script>

<?= $this->endSection('page_script'); ?>