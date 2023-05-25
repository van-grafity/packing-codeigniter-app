<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>


<style type="text/css">
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
        font-size: 18px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="row">
                    <table>
                        <tr>
                            <td width=20%><b>Buyer Name :</b></td>
                            <td><?= $purchase_order->buyer_name ?></td>
                            <td width=20%><b>GL Number</b></td>
                            <td><?= $purchase_order->gl_number ?></td>
                        </tr>
                        <tr>
                            <td><b>Total Qty :</b></td>
                            <td><?= $purchase_order->PO_Qty ?></td>
                        </tr>
                        <tr>
                            <td><b>PO Amount :</b></td>
                            <td><?= number_to_currency($purchase_order->PO_Amount , 'USD', 'en_USD', 2); ?></td>
                        </tr>
                        <tr>
                            <td><b>Required Ship Date :</b></td>
                            <td><?= $purchase_order->Shipdate ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- <div class="tab-content" id="custom-tabs-three-tabContent"> -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center align-middle">Product No.</th>
                                            <th class="text-center align-middle">Style</th>
                                            <th class="text-center align-middle">Size</th>
                                            <th class="text-center align-middle">Unit Price</th>
                                            <th class="text-center align-middle">Qty Ordered</th>
                                            <th class="text-center align-middle">Total Amount</th>
                                            <th class="text-center align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($purchase_order_details as $key => $detail) { ?>
                                            <tr>
                                                <td><?= $detail->product_code ?></td>
                                                <td><?= $detail->style_no ?></td>
                                                <td><?= $detail->size ?></td>
                                                <td><?= number_to_currency($detail->product_price, 'USD', 'en_US', 2); ?></td>
                                                <td><?= $detail->qty ?></td>
                                                <td><?= number_to_currency($detail->total_amount, 'USD', 'en_US', 2); ?></td>
                                                <td class="text-center">
                                                    <a class="btn btn-warning btn-sm btn-edit">Edit</a>
                                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $detail->id ?>" data-product-code="<?= $detail->product_code ?>">Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" card-footer">
            <div class="row">
                <div class="col-12">
                    <a href="../index.php/purchaseorder" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Modal Delete Purchase Order Detail -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../index.php/purchaseorder/deletedetail" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Purchase Order Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Product from this Purchase Order?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="po_detail_id" id ="po_detail_id" >
                    <input type="hidden" name="po_number" id ="po_number" value="<?= $purchase_order->PO_No?>" >
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete Purchase Order Detail -->

<script type="text/javascript">
$(document).ready(function() {

    // Show Delete Modal
    $('.btn-delete').on('click', function() {
        let id = $(this).data('id');
        let product_code = $(this).data('product-code');

        $('#po_detail_id').val(id);
        if (product_code) {
            $('#delete_message').text(`Are you sure want to delete this Product (${product_code}) from this Purchase Order?`);
        }

        $('#deleteModal').modal('show');
    });
})
</script>

<script type="text/javascript">
    
</script>
<?= $this->endSection(); ?>