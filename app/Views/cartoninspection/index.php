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
                <button type="button" class="btn btn-secondary mb-2" id="btn-add-carton">Add Carton</button>
                <h3 class="mb-4">Carton Inspection</h3>
                <table id="packinglist_table" class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%">No</th>
                            <th width="15%">PO Number</th>
                            <th width="25%">Packinglist SN</th>
                            <th width="15%">Carton Number</th>
                            <th width="15%">Status</th>
                            <th width="15%">Re Opened At</th>
                            <th width="15%">Re Packed at</th>
                            <th width="25%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($carton_inspection as $carton) : ?>
                        <tr class="text-center">
                            <td><?= $i++; ?></td>
                            <td><?= $carton->number; ?></td>
                            <td><?= $carton->number; ?></td>
                            <td><?= $carton->number; ?></td>
                            <td><?= $carton->number; ?></td>
                            <td><?= $carton->number; ?></td>
                            <td><?= $carton->number; ?></td>
                            <td><?= $carton->number; ?></td>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>


<!-- Modal Generate Carton -->
<div class="modal fade" id="modal_carton_inspection" tabindex="-1" role="dialog" aria-labelledby="modal_label"
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
                    <h4 id="confirm_message">Add Carton for Inspection</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Oke</button>
                    <!-- <button type="submit" class="btn btn-primary" id="modal_btn_submit">Yes</button> -->
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
</script>
<script type="text/javascript">
$('#packinglist_table').DataTable({
    processing: true,
    // serverSide: true,
    // ajax: dtable_url,
    columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'packinglist_number', name: 'packinglist_number'},
            { data: 'buyer_name', name: 'buyer_name' },
            { data: 'po_number', name: 'po_number' },
            { data: 'po_number', name: 'po_number' },
            { data: 'po_number', name: 'po_number' },
            { data: 'gl_number', name: 'gl_number' },
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

    $('#btn-add-carton').on('click', function(event) {
        // $('#ModalLabel').text("Add Carton")
        // $('#btn_submit').text("Add Carton")
        // $('#buyer_form').attr('action', store_url);
        // // $('#buyer_form').find("input[type=text], input[type=number], textarea").val("");
        // $('#buyer_form').find('select').val("").trigger('change');

        $('#modal_carton_inspection').modal('show');
    })

    $('.btn-generate-carton').on('click', function() {
        let id = $(this).data('id');
        let packinglist_number = $(this).data('packinglist-number');

        $('#confirm_message').text(
            `Are you sure want to Generate Carton from Packinglist: ${packinglist_number}`)
        $('#modal_label').text("Generate Carton")
        $('#modal_btn_submit').text("Generate")
        $('#generate_carton_form').attr('action', generate_carton_url);
        $('#packinglist_id').val(id);

        $('#generate_carton_modal').modal('show');
    })
})
</script>

<script type="text/javascript">
    const store_url = "<?php echo base_url('buyer/save'); ?>";
    const update_url = "<?php echo base_url('buyer/update'); ?>";
</script>

<?= $this->endSection('page_script'); ?>