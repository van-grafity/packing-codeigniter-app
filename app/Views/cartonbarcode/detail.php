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
                                <td><?= esc($packinglist->po_no); ?></td>
                            </tr>
                            <tr>
                                <td><b>Buyer</b></td>
                                <td><?= esc($packinglist->buyer_name); ?></td>
                                <td><b>Purchase Order No.</b></td>
                                <td><?= esc($packinglist->po_no); ?></td>
                            </tr>
                            <tr>
                                <td><b>Style No.</b></td>
                                <td> <?= esc($packinglist->style_no); ?> </td>
                                <td><b>Description</b></td>
                                <td> <?= esc($packinglist->style_description); ?> </td>
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
                        <form action="<?= base_url('cartonbarcode/importexcel')?>" method="post" id="packinglist_form" enctype="multipart/form-data">
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
                            <th width="25%">Carton Number</th>
                            <th width="25%">Total PCS / Carton</th>
                            <th width="25%">Carton Barcode</th>
                            <th width="25%">Packed Status</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($carton_list as $carton) : ?>
                        <tr class="text-center">
                            <td><?= $i++; ?></td>
                            <td><?= $carton->carton_number; ?></td>
                            <td><?= $carton->pcs_per_carton; ?></td>
                            <td><?= $carton->barcode; ?></td>
                            <td><?= $carton->packed_status; ?></td>
                            <td class="text-center align-middle">
                                <a class="btn btn-info btn-sm mb-1 mr-2" onclick="detail_carton(<?= $carton->id ?>)">Detail</a>
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

<!-- Modal Detail Carton -->
<div class="modal fade" id="detail_carton_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">Detail Carton</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table" id="detail_carton_table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>UPC</th>
                                        <th>Name</th>
                                        <th>Colour</th>
                                        <th>Size</th>
                                        <th>Qty</th>
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
<!-- End Modal Detail Carton -->

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script>

$(document).ready(function(){
    bsCustomFileInput.init();

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);

})
</script>
<script type="text/javascript">
    const detail_carton_url = '<?= base_url('cartonbarcode/detailcarton')?>';



    $('#carton_table').DataTable({
        processing: true,
        // serverSide: true,
        // ajax: dtable_url,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'carton_number', name: 'carton_number'},
            {data: 'total_pcs', name: 'total_pcs'},
            {data: 'barcode', name: 'barcode'},
            {data: 'packed_status', name: 'packed_status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        paging: true,
        responsive: true,
        lengthChange: true,
        searching: true,
        autoWidth: false,
    });

    async function detail_carton(carton_id) {
        $('#detail_carton_table tbody').html('');
        let total = 0;
        
        params_data = { id : carton_id };
        result = await using_fetch(detail_carton_url, params_data, "GET");
        result.data.forEach((data, key) => {
            let row = `
                <tr>
                    <td>${key+1}</td>
                    <td>${data.product_code}</td>
                    <td>${data.product_name}</td>
                    <td>${data.product_colour}</td>
                    <td>${data.product_size}</td>
                    <td>${data.product_qty}</td>
                </tr>
            `;
            $('#detail_carton_table tbody').append(row);
            
            total += parseInt(data.product_qty);
        });
        let row_footer = `
            <tr>
                <td colspan="5" class="text-right">Total PCS :</td>
                <td colspan="1">${total}</td>
            </tr>
        `;
        $('#detail_carton_table tfoot').html(row_footer);

        $('#detail_carton_modal').modal('show');
    }
</script>
<?= $this->endSection('page_script'); ?>