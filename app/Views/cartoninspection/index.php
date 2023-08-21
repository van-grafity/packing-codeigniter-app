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
                            <td><?= $carton['carton_number']; ?></td>
                            <td><?= $carton['carton_number']; ?></td>
                            <td><?= $carton['carton_number']; ?></td>
                            <td><?= $carton['carton_number']; ?></td>
                            <td><?= $carton['carton_number']; ?></td>
                            <td><?= $carton['carton_number']; ?></td>
                            <td><?= $carton['carton_number']; ?></td>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

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

})
</script>

<script type="text/javascript">
    const store_url = "<?php echo base_url('buyer/save'); ?>";
    const update_url = "<?php echo base_url('buyer/update'); ?>";
</script>

<?= $this->endSection('page_script'); ?>