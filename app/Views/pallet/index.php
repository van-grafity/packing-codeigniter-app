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
                <a href="javascript:void(0)" type="button" class="btn btn-success mb-2" id="btn-add-pallet" onclick="add_new_pallet()">New Pallet</a>
                <table id="carton_inspection_table" class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%">No</th>
                            <th width="10%">Serial Number</th>
                            <th width="15%">Description</th>
                            <th width="25%">Status</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>


<!-- Modal Add and Edit Product Detail -->
<div class="modal fade" id="modal_pallet" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="pallet_form">
                <input type="hidden" name="edit_pallet_id" value="" id="edit_pallet_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Pallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="serial_number" class="col-form-label">Serial Number</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="PLT-A0001" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
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
<!-- End Modal Add and Edit Product Detail -->



<!-- Modal Delete Carton Inspection -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('pallet/delete')?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete Carton Inspection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Carton Inspection ?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="pallet_id" id="pallet_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</form>
<!-- End Modal Delete Carton Inspection -->

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
    const generate_carton_url = '<?= base_url('cartonbarcode/generatecarton')?>';
    const index_dt_url = '<?= base_url('pallet/list')?>';
    const save_url = '<?= base_url('pallet/save')?>';
    const detail_url = '<?= base_url('pallet/detail')?>';
    const update_url = '<?= base_url('pallet/update')?>';


    const add_new_pallet = () => {
        $('#pallet_form').attr('action',save_url);
        $('#modal_pallet').modal('show');
    }
    
    const edit_pallet = async (pallet_id) => {
        params_data = { id : pallet_id };
        result = await using_fetch(detail_url, params_data, "GET");

        console.log(result);

        pallet_data = result.data
        $('#serial_number').val(pallet_data.serial_number);
        $('#description').val(pallet_data.description);
        $('#edit_pallet_id').val(pallet_data.id);
        
        $('#pallet_form').attr('action',update_url);
        $('#modal_pallet').modal('show');
    }

</script>
<script type="text/javascript">
$('#carton_inspection_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: index_dt_url,
    order: [],
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        { data: 'serial_number', name: 'serial_number'},
        { data: 'description', name: 'description'},
        { data: 'flag_empty', name: 'flag_empty'},
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
<script>
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);

    // $('#table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: '/ajax-datatable/basic'
    // });

})
</script>

<script type="text/javascript">



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

<?= $this->endSection('page_script'); ?>