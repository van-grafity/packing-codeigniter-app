<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-secondary mb-2" id="btn_modal_create">Add New</button>
                <table id="table1" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%">No</th>
                            <th width="15%">PL No.</th>
                            <th width="20%">Buyer</th>
                            <th width="20%">PO No.</th>
                            <th width="15%">GL No.</th>
                            <th width="10%">Season</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($PackingList as $PL) : ?>
                            <tr>
                                <td class="text-center" scope="row"><?= $i++; ?></td>
                                <td><a href="<?= '../index.php/packinglist/' . $PL->packinglist_serial_number; ?>"><?= $PL->packinglist_serial_number; ?></a></td>
                                <td><?= $PL->buyer_name; ?></td>
                                <td><?= $PL->PO_No; ?></td>
                                <td><?= $PL->gl_number; ?></td>
                                <td><?= $PL->season; ?></td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-warning btn-sm btn-edit">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" 
                                        data-id = "<?= esc($PL->id)?>"
                                        data-pl-serial-number = "<?= esc($PL->packinglist_serial_number)?>"
                                    >Delete</a>
                                </td>
                            </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>


<!-- Modal Add and Edit Packing List -->

<div class="modal fade" id="packinglist_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="packinglist_form">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Add Packing List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="po_no">PO No :</label>
                        <select id="po_no" name="po_no" class="form-control" required>
                            <option value="">Select PO No </option>
                            <?php foreach ($po_list as $key => $po) { ?>
                                <option value="<?= esc($po->id) ?>"
                                    data-gl-number="<?= esc($po->gl_number) ?>"    
                                    data-buyer-name="<?= esc($po->buyer_name) ?>"    
                                    data-po-qty="<?= esc($po->PO_Qty) ?>"    
                                    data-shipdate="<?= esc($po->Shipdate) ?>"    
                                ><?= esc($po->PO_No) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="buyer_name">Buyer Name :</label>
                                <input type="text" readonly class="form-control" id="buyer_name" name="buyer_name" placeholder="Buyer Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_no">Order No :</label>
                                <input type="text" readonly class="form-control" id="order_no" name="order_no" placeholder="Order No">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_qty">Order Qty :</label>
                                <input type="text" readonly class="form-control" id="order_qty" name="order_qty" placeholder="Order Qty">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="shipdate">Ship Date :</label>
                                <input type="text" readonly class="form-control" id="shipdate" name="shipdate" placeholder="Ship Date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="PL_Date">Packing List Date :</label>
                                <input type="date" class="form-control" id="packinglist_date" name="packinglist_date" placeholder="Packing List Date" value="<?= date('Y-m-d'); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-submit">Add Packing List</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit Packing List -->


<!-- Modal Delete Packing List -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../index.php/packinglist/delete" method="post">
                <input type="hidden" name="packinglist_id" id ="packinglist_id" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Packing List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Packing List ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete Packing List -->

<?= $this->endSection(); ?>



<?= $this->Section('page_script'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#btn_modal_create').on('click', function(e) {
        clear_form({
            modal_id : 'packinglist_modal',
            modal_title: "Add Product",
            modal_btn_submit: "Add Product",
            form_action_url: store_url,
        });
        $('#packinglist_modal').modal('show');
        
    });

    $('.btn-delete').on('click', function() {
        let id = $(this).data('id');
        let serial_number = $(this).data('pl-serial-number');
        $('#packinglist_id').val(id);
        if (id) {
            $('#delete_message').text(`Are you sure want to delete Packing List (${serial_number})?`);
        }
        $('#deleteModal').modal('show');
    });

    $('#po_no').on('change', function(event) {

        let buyer_name = $(this).find($('option:selected')).data('buyer-name');
        let order_no = $(this).find($('option:selected')).data('gl-number');
        let order_qty = $(this).find($('option:selected')).data('po-qty');
        let shipdate = $(this).find($('option:selected')).data('shipdate');

        if ($(this).val()) {
            $('#buyer_name').val(buyer_name);
            $('#order_no').val(order_no);
            $('#order_qty').val(order_qty);
            $('#shipdate').val(shipdate);
        } else {
            $('#order_qty').val();
        }
    })
})
</script>

<script type="text/javascript">
    const store_url = "../index.php/packinglist/store";
</script>

<?= $this->endSection('page_script'); ?>

