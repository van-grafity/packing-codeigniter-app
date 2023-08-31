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
                <a href="<?= url_to('cartoninspection/create')?>" type="button" class="btn btn-secondary mb-2" id="btn-add-carton">New Inspection</a>
                <table id="carton_inspection_table" class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%">No</th>
                            <th width="10%">PO Number</th>
                            <th width="15%">GL Number</th>
                            <th width="25%">Buyer</th>
                            <th width="10%">Total Carton</th>
                            <th width="15%">Issued Date</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($carton_inspection as $inpsection) : ?>
                        <tr class="text-center">
                            <td><?= $i++; ?></td>
                            <td><?= $inpsection->po_number; ?></td>
                            <td><?= $inpsection->gl_number; ?></td>
                            <td><?= $inpsection->buyer_name; ?></td>
                            <td><?= $inpsection->total_carton; ?></td>
                            <td><?= $inpsection->issued_date; ?></td>
                            <td>
                                <a class="btn btn-info btn-sm mb-1 mr-2" onclick="detail_inspection(<?= $inpsection->id; ?>)">Detail</a>
                                <a class="btn btn-danger btn-sm mb-1 mr-2 btn-delete-inspection <?= $action_field_class ?>"
                                     data-inspection-id="<?= $inpsection->id; ?>" 
                                     data-po-number="<?= $inpsection->po_number; ?>">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>



<!-- Modal Detail Inspection -->
<div class="modal fade" id="detail_inspection_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_label">Detail Inspection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <dl class="row">
                            <dt class="col-sm-3">Buyer PO</dt>
                            <dd class="col-sm-9" id="inspection_detail_po_no"> : - </dd>
                            <dt class="col-sm-3">GL Number</dt>
                            <dd class="col-sm-9" id="inspection_detail_gl_no"> : - </dd>
                            <dt class="col-sm-3">Buyer</dt>
                            <dd class="col-sm-9" id="inspection_detail_buyer"> : - </dd>
                            <br>
                            <br>
                            
                        </dl>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <dl class="row">
                            <dt class="col-sm-3">Issued By</dt>
                            <dd class="col-sm-9" id="inspection_detail_issued_by"> : - </dd>
                            <dt class="col-sm-3">Received By</dt>
                            <dd class="col-sm-9" id="inspection_detail_received_by"> : - </dd>
                            <dt class="col-sm-3">Received Date</dt>
                            <dd class="col-sm-9" id="inspection_detail_issued_date"> : - </dd>
                        </dl>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-sm text-center" id="detail_inspection_table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Carton No.</th>
                                    <th>Carton Barcode</th>
                                    <th>Total PCS</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <dl class="row">
                            <dt class="col-sm-2">Total Carton </dt>
                            <dd class="col-sm-3" id="inspection_detail_total_carton"> : - </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="btn_print_transfer_note" href="" target="_blank" type="button" class="btn btn-info" >Print Transfer Note</a>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Detail Inspection -->



<!-- Modal Delete Carton Inspection -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('cartoninspection/delete')?>" method="post">
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
                    <input type="hidden" name="inspection_id" id="inspection_id">
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
</script>
<script type="text/javascript">
$('#carton_inspection_table').DataTable({
    processing: true,
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
        {
            data: 'po_number',
            name: 'po_number'
        },
        {
            data: 'buyer',
            name: 'buyer'
        },
        {
            data: 'gl_number',
            name: 'gl_number'
        },
        {
            data: 'total_carton',
            name: 'total_carton'
        },
        {
            data: 'issued_date',
            name: 'issued_date'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ],
    paging: true,
    responsive: true,
    lengthChange: true,
    searching: true,
    autoWidth: false,
});
</script>
<script>
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);

})
</script>

<script type="text/javascript">
const detail_inspection_url = '<?= base_url('cartoninspection/detail')?>';

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


$('.btn-delete-inspection').on('click', function(event){
    let inspection_id = $(this).data('inspection-id');
    let po_number = $(this).data('po-number');
    if (po_number) {
        $('#delete_message').text(`Are you sure want to delete this Carton Inspection for PO ${po_number} ?`);
    }
    $('#inspection_id').val(inspection_id);
    $('#deleteModal').modal('show');
})
</script>

<?= $this->endSection('page_script'); ?>