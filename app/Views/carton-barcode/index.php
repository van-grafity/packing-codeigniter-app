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
                            <th width="15%">PL No.</th>
                            <th width="25%">Buyer</th>
                            <th width="15%">PO No.</th>
                            <th width="15%">GL No.</th>
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
                            <td><?= $pl->PO_No; ?></td>
                            <td><?= $pl->gl_number; ?></td>
                            <td class="text-center align-middle">
                                <a class="btn btn-primary btn-sm mb-1 mr-2">Generate Carton</a>
                                <a href="<?= base_url('cartonbarcode/'.$pl->id)?>"class="btn btn-info btn-sm mb-1 mr-2">Detail</a>
                            </td>
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
<script>
$(function() {
    bsCustomFileInput.init();
});
</script>
<script type="text/javascript">

    $('#packinglist_table').DataTable({
        processing: true,
        // serverSide: true,
        // ajax: dtable_url,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'packinglist_number', name: 'packinglist_number'},
            {data: 'buyer_name', name: 'buyer_name'},
            {data: 'po_number', name: 'po_number'},
            {data: 'gl_number', name: 'gl_number'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        dom: "<'row'<'col-md-2'l><'col-md-6'B><'col-md-4'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>",
        paging: true,
        responsive: true,
        lengthChange: true,
        searching: true,
        autoWidth: false,
    });
</script>
<?= $this->endSection('page_script'); ?>