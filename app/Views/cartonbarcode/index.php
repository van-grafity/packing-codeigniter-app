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
                <table id="packinglist_table" class="table table-bordered table-hover">
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
                        <?php $i = 1; ?>
                        <?php foreach ($packinglist as $pl) : ?>
                        <tr class="text-center">
                            <td><?= $i++; ?></td>
                            <td><?= $pl->packinglist_serial_number; ?></td>
                            <td><?= $pl->buyer_name; ?></td>
                            <td><?= $pl->po_no; ?></td>
                            <td><?= $pl->gl_number; ?></td>
                            <td class="text-center align-middle">
                                <a class="btn btn-primary btn-sm mb-1 mr-2 <?= $pl->btn_generate_class?>"
                                    data-id="<?= $pl->id ?>"
                                    data-packinglist-number="<?= $pl->packinglist_serial_number?>"
                                    onclick="generate_carton(this)"
                                    >Generate Carton</a>
                                <a href="<?= base_url('cartonbarcode/'.$pl->id)?>"
                                    class="btn btn-info btn-sm mb-1 mr-2 <?= $pl->btn_detail_class?> ">Detail</a>
                            </td>
                        </tr>
                        <?php endforeach;  ?>
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
            columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'packinglist_number', name: 'packinglist_number'},
                    { data: 'buyer_name', name: 'buyer_name' },
                    { data: 'po_number', name: 'po_number' },
                    { data: 'gl_number', name: 'gl_number' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            paging: true,
            lengthChange: true,
            searching: true,
            autoWidth: false,
        });

    });
</script>
<?= $this->endSection('page_script'); ?>