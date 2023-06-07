<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
    #packinglist_table tbody td {
        vertical-align: middle
    }
</style>

<div class="content-wrapper">
    <section class="content mb-4">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <div class="card-title">Packing List Information</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-bold">SN : <?= esc($packinglist->packinglist_serial_number); ?></h5>
                        <table width="100%">
                            <tr>
                                <td width="20%"><b>Order No.</b></td>
                                <td width="16%"><?= esc($packinglist->gl_number); ?></td>
                                <td><b>Master Order No.</b></td>
                                <td><?= esc($packinglist->PO_No); ?></td>
                            </tr>
                            <tr>
                                <td><b>Buyer</b></td>
                                <td><?= esc($packinglist->buyer_name); ?></td>
                                <td><b>Purchase Order No.</b></td>
                                <td><?= esc($packinglist->PO_No); ?></td>
                            </tr>
                            <tr>
                                <td><b>Style No.</b></td>
                                <td> xxxxx </td>
                                <td><b>Description</b></td>
                                <td> xxxxx </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><b></b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Order Qty.</b></td>
                                <td><?= esc($packinglist->packinglist_qty); ?></td>
                                <td><b>Destination</b></td>
                                <td> <?= esc($packinglist->destination); ?> </td>
                            </tr>
                            <tr>
                                <td><b>Cut Qty.</b></td>
                                <td><?= esc($packinglist->packinglist_cutting_qty); ?></td>
                                <td><b>Departments</b></td>
                                <td> <?= esc($packinglist->department); ?> </td>
                            </tr>
                            <tr>
                                <td><b>Ship Qty.</b></td>
                                <td><?= esc($packinglist->packinglist_ship_qty); ?></td>
                                <td><b>Customer</b></td>
                                <td> xxxxx </td>
                            </tr>
                            <tr>
                                <td><b>Total Carton</b></td>
                                <td> <?= esc($packinglist->total_carton); ?> </td>
                                <td><b>Ship Date</b></td>
                                <td><?= esc($packinglist->shipdate); ?></td>
                            </tr>
                            <tr>
                                <td><b>Percentage Ship</b></td>
                                <td> <?= esc($packinglist->percentage_ship); ?> </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-info mt-2">
            <div class="card-header">
                <div class="card-title">Carton List</div>
            </div>
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-sm-6">
                        <form action="<?= base_url('cartonbarcode/import_excel')?>" method="post" id="packinglist_form" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="packinglist_id" value="<?= $packinglist->id?>">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Update Barcode via CSV</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="file_excel" name="file_excel">
                                                <label class="custom-file-label" for="file_excel">Choose CSV file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success btn-sm" id="btn_submit_form">Upload Bercode</button>
                            </div>
                        </form>
                    </div>
                </div>

                <table id="carton_table" class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%">No</th>
                            <th width="15%">Carton Number</th>
                            <th width="15%">Total PCS</th>
                            <th width="15%">Barcode</th>
                            <th width="25%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($carton_list as $carton) : ?>
                        <tr class="text-center">
                            <td><?= $i++; ?></td>
                            <td><?= $carton->carton_number; ?></td>
                            <td>100</td>
                            <td><?= $carton->barcode; ?></td>
                            <td class="text-center align-middle">
                                <a class="btn btn-info btn-sm mb-1 mr-2">Detail</a>
                            </td>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row text-right">
            <div class="col-12">
                <a href="<?= base_url('cartonbarcode')?>" class="btn btn-secondary">Back</a>
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

    $('#carton_table').DataTable({
        processing: true,
        // serverSide: true,
        // ajax: dtable_url,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'carton_number', name: 'carton_number'},
            {data: 'total_pcs', name: 'total_pcs'},
            {data: 'barcode', name: 'barcode'},
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