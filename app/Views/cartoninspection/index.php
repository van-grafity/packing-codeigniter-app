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
                <h3 class="mb-4">Carton Inspection</h3>
                <table id="carton_inspection_table" class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%">No</th>
                            <th width="15%">PO Number</th>
                            <th width="25%">Packinglist SN</th>
                            <th width="15%">Total Carton</th>
                            <th width="15%">Issued By</th>
                            <th width="15%">Received By</th>
                            <th width="15%">Issued Date</th>
                            <th width="25%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($carton_inspection as $inpsection) : ?>
                        <tr class="text-center">
                            <td><?= $i++; ?></td>
                            <td><?= $inpsection->po_number; ?></td>
                            <td><?= $inpsection->pl_number; ?></td>
                            <td><?= $inpsection->total_carton; ?></td>
                            <td><?= $inpsection->issued_by; ?></td>
                            <td><?= $inpsection->received_by; ?></td>
                            <td><?= $inpsection->issued_date; ?></td>
                            <td><a class="btn btn-info btn-sm mb-1 mr-2" onclick="detail_inspection(<?= $inpsection->id; ?>)" >Detail</a></td>
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
                        <div class="col-sm-12">
                            <table class="table" id="detail_inspection_table">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Detail Inspection -->

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
    const generate_carton_url = '<?= base_url('cartonbarcode/generatecarton')?>';
</script>
<script type="text/javascript">
$('#carton_inspection_table').DataTable({
    processing: true,
    // serverSide: true,
    // ajax: dtable_url,
    columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'po_number', name: 'po_number' },
            { data: 'packinglist_number', name: 'packinglist_number'},
            { data: 'total_carton', name: 'total_carton' },
            { data: 'issued_by', name: 'issued_by' },
            { data: 'received_by', name: 'received_by' },
            { data: 'issued_date', name: 'issued_date' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
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
    const detail_inspection_url = '<?= base_url('inspection/detail')?>';

    async function detail_inspection(carton_id) {
        // $('#detail_inspection_table tbody').html('');
        // let total = 0;
        
        // params_data = { id : carton_id };
        // result = await using_fetch(detail_inspection_url, params_data, "GET");
        // result.data.forEach((data, key) => {
        //     let row = `
        //         <tr>
        //             <td>${key+1}</td>
        //             <td>${data.product_code}</td>
        //             <td>${data.product_name}</td>
        //             <td>${data.product_colour}</td>
        //             <td>${data.product_size}</td>
        //             <td>${data.product_qty}</td>
        //         </tr>
        //     `;
        //     $('#detail_inspection_table tbody').append(row);
            
        //     total += parseInt(data.product_qty);
        // });
        // let row_footer = `
        //     <tr>
        //         <td colspan="5" class="text-right">Total PCS :</td>
        //         <td colspan="1">${total}</td>
        //     </tr>
        // `;
        // $('#detail_inspection_table tfoot').html(row_footer);

        $('#detail_inspection_modal').modal('show');
    }
</script>

<?= $this->endSection('page_script'); ?>