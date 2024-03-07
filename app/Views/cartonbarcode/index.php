<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
#packinglist_table tbody td {
    vertical-align: middle
}
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <h3 class="mb-4">Packing List</h3>
                <table id="packinglist_table" class="table table-bordered table-striped table-hover text-center">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%">No</th>
                            <th width="15%">Packing List SN</th>
                            <th width="25%">Buyer</th>
                            <th width="15%">PO Number</th>
                            <th width="15%">GL Number</th>
                            <th width="25%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>


<!-- Modal Generate Carton -->
<div class="modal fade" id="generate_carton_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="generate_carton_form">
                <input type="hidden" name="packinglist_id" id="packinglist_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">Generate Carton</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="confirm_message">Are you sure want to Generate Carton from this Packinglist?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="modal_btn_submit">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Generate Carton -->

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
    const generate_carton_url = '<?= base_url('cartonbarcode/generatecarton')?>';
    const index_dt_url = '<?= url_to('cartonbarcode_list')?>';
    

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);

    const generate_carton = (e) => {
        let id = $(e).data('id');
        let packinglist_number = $(e).data('packinglist-number');

        $('#confirm_message').text(
            `Are you sure want to Generate Carton from Packinglist: ${packinglist_number}`)
        $('#modal_label').text("Generate Carton")
        $('#modal_btn_submit').text("Generate")
        $('#generate_carton_form').attr('action', generate_carton_url);
        $('#packinglist_id').val(id);

        $('#generate_carton_modal').modal('show');
    }

    
</script>

<script type="text/javascript">
    $(function() {
        $('#packinglist_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: index_dt_url,
            order: [],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'packinglist_serial_number', name: 'pl.packinglist_serial_number'},
                { data: 'buyer_name', name: 'sync_po.buyer_name' },
                { data: 'po_no', name: 'po.po_no' },
                { data: 'gl_number', name: 'sync_po.gl_number' },
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
            dom: "<'row'<'col-md-2'l><'col-md-6'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    }
                },
            ]
        });

    });
</script>
<?= $this->endSection('page_script'); ?>