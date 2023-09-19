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
                <a href="<?= url_to('pallet_transfer_create')?>" type="button" class="btn btn-success mb-2" id="btn-add-pallet">New Pallet Transfer</a>
                <table id="pallet_transfer_table" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr class="table-primary">
                            <th width="30">No</th>
                            <th width="100">Pallet SN</th>
                            <th width="">Transfer Note</th>
                            <th width="70">Total Ctn</th>
                            <th width="">From</th>
                            <th width="">To</th>
                            <th width="100">Status</th>
                            <th width="120">Action</th>
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

const index_dt_url = '<?= url_to('pallet_transfer_list')?>';


async function detail_inspection(inspection_id) {
    clear_inspection_detail_modal();

    params_data = { id : inspection_id };
    result = await using_fetch(detail_inspection_url, params_data, "GET");
    console.log(result);

    let inspection_data = result.data.carton_inspection;
    $('#inspection_detail_gl_no').text(` : ${inspection_data.gl_number}`);
    $('#inspection_detail_buyer').text(` : ${inspection_data.buyer_name}`);
    $('#inspection_detail_po_no').text(` : ${inspection_data.po_number}`);
    $('#inspection_detail_issued_by').text(` : ${inspection_data.issued_by}`);
    $('#inspection_detail_received_by').text(` : ${inspection_data.received_by}`);
    $('#inspection_detail_issued_date').text(` : ${inspection_data.issued_date}`);

    let inspection_detail_data = result.data.carton_inspection_detail;

    inspection_detail_data.forEach((data, key) => {
        let row = `
            <tr>
                <td>${key+1}</td>
                <td>${data.carton_number}</td>
                <td>${data.carton_barcode}</td>
                <td>${data.total_pcs}</td>
            </tr>
        `;
        $('#detail_inspection_table tbody').append(row);

    });

    $('#inspection_detail_total_carton').text(` : ${inspection_detail_data.length} carton`);
    $('#btn_print_transfer_note').attr('href',`<?= base_url('cartoninspection/transfernote/')?>${inspection_data.id}`)

    $('#detail_inspection_modal').modal('show');
}

const clear_inspection_detail_modal = () => {
    $('#inspection_detail_gl_no').text(` : `);
    $('#inspection_detail_buyer').text(` : `);
    $('#inspection_detail_po_no').text(` : `);
    $('#inspection_detail_issued_by').text(` : `);
    $('#inspection_detail_received_by').text(` : `);
    $('#inspection_detail_issued_date').text(` : `);
    $('#inspection_detail_total_carton').text(` : `);

    $('#detail_inspection_table tbody').html('');
}

const delete_pallet = (pallet_id) => {
    $('#delete_message').text(`Are you sure want to delete this Pallet?`);
    $('#pallet_id').val(pallet_id);
    $('#delete_modal').modal('show');
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
        { data: 'pallet_serial_number', name: 'pallet.serial_number'},
        { data: 'transfer_note', name: 'transfer_note.serial_number'},
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
</script>

<?= $this->endSection('page_script'); ?>