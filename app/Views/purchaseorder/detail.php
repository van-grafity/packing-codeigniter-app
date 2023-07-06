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
                            <td width=20%><b>PO Number :</b></td>
                            <td><?= $purchase_order->po_no ?></td>
                        </tr>
                        <tr>
                            <td><b>Total Qty :</b></td>
                            <td><?= $purchase_order->po_qty ?></td>
                            <td width=20%><b>GL Number :</b></td>
                            <td><?= $purchase_order->gl_number ?></td>
                        </tr>
                        <tr>
                            <td><b>PO Amount :</b></td>
                            <td><?= number_to_currency($purchase_order->po_amount, 'USD', 'en_USD', 2); ?></td>
                        </tr>
                        <tr>
                            <td><b>Required Ship Date :</b></td>
                            <td><?= $purchase_order->shipdate ?></td>
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
                                <button type="button" class="btn btn-secondary mb-2" id="btn-add-detail">Add Product</button>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center align-middle">Product No.</th>
                                            <th class="text-center align-middle">Product Type</th>
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
                                                <td><?= $detail->category_name ?></td>
                                                <td><?= $detail->style_no ?></td>
                                                <td><?= $detail->size ?></td>
                                                <td><?= number_to_currency($detail->product_price, 'USD', 'en_US', 2); ?></td>
                                                <td><?= $detail->qty ?></td>
                                                <td><?= number_to_currency($detail->total_amount, 'USD', 'en_US', 2); ?></td>
                                                <td class="text-center">
                                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $detail->id ?>" data-product-id="<?= $detail->product_id ?>" data-product-code="<?= $detail->product_code ?>" data-product-name="<?= $detail->product_name ?>" data-order-qty="<?= $detail->qty ?>" data-total-amount="<?= $detail->total_amount ?>">Edit</a>
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
                    <a href="<?= base_url('purchaseorder')?>" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Modal Add and Edit Purchase Order Detail -->
<div class="modal fade" id="modal_po_detail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="po_detail_form">
                <input type="hidden" name="order_id" value="<?= $purchase_order->id ?>">
                <input type="hidden" name="po_number" value="<?= $purchase_order->po_no ?>">
                <input type="hidden" name="edit_po_detail_id" value="" id="edit_po_detail_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product">Product</label>
                        <select id="product" name="product" class="form-control" required>
                            <option value="">-Select Product Code-</option>
                            <?php foreach ($products as $product) : ?>
                                <option value="<?= $product->id; ?>" 
                                data-product-name="<?= $product->product_name; ?>" 
                                data-product-price="<?= $product->product_price; ?>" 
                                data-product-size="<?= $product->product_size; ?>"
                                ><?= $product->product_code; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" readonly class="form-control" id="product_name" name="product_name" placeholder="Please Select Product Code">
                    </div>
                    <div class="form-group">
                        <label for="product_price">Unit Price</label>
                        <input type="text" readonly class="form-control" id="product_price" name="product_price" placeholder="Please Select Product Code">
                    </div>
                    <div class="form-group">
                        <label for="product_size">Unit Size</label>
                        <input type="text" readonly class="form-control" id="product_size" name="product_size" placeholder="Please Select Product Code">
                    </div>
                    <div class="form-group">
                        <label for="order_qty">Order Qty</label>
                        <input type="number" class="form-control" id="order_qty" name="order_qty" placeholder="Order Qty" required>
                    </div>
                    <div class="form-group">
                        <label for="total_amount">Total Amount</label>
                        <input type="text" readonly class="form-control" id="total_amount" name="total_amount" placeholder="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_submit">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit Purchase Order Detail -->

<!-- Modal Delete Purchase Order Detail -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('purchaseorder/deletedetail')?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Product from this Purchase Order?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="po_detail_id" id="po_detail_id">
                    <input type="hidden" name="order_id" value="<?= $purchase_order->id ?>">
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

        $('#product').on('change', function(event) {

            let product_name = $(this).find($('option:selected')).data('product-name');
            let product_price = $(this).find($('option:selected')).data('product-price');
            let product_size = $(this).find($('option:selected')).data('product-size');

            if ($(this).val()) {
                $('#product_name').val(product_name);
                $('#product_price').val(product_price);
                $('#product_size').val(product_size);

                let total_amount = $('#order_qty').val() * $('#product_price').val();
                $('#total_amount').val(total_amount);
            } else {
                $('#product_name').val();
                $('#product_price').val();
                $('#product_size').val();
            }
        })

        $('#order_qty').on('keyup', function(event) {
            let total_amount = $('#order_qty').val() * $('#product_price').val();
            $('#total_amount').val(total_amount);
        })

        $('#btn-add-detail').on('click', function(event) {

            $('#ModalLabel').text("Add Product")
            $('#btn_submit').text("Add Product")
            $('#po_detail_form').attr('action', store_url);
            $('#po_detail_form').find("input[type=text], input[type=number], textarea").val("");
            $('#po_detail_form').find('select').val("").trigger('change');

            $('#modal_po_detail').modal('show');
        })

        $('.btn-delete').on('click', function() {
            let id = $(this).data('id');
            let product_code = $(this).data('product-code');

            $('#po_detail_id').val(id);
            if (product_code) {
                $('#delete_message').text(`Are you sure want to delete this Product (${product_code}) from this Purchase Order?`);
            }

            $('#deleteModal').modal('show');
        });

        $('.btn-edit').on('click', function() {
            let id = $(this).data('id');
            let product_id = $(this).data('product-id');
            let product_code = $(this).data('product-code');
            let product_name = $(this).data('product-name');
            let product_price = $(this).data('product-price');
            let order_qty = $(this).data('order-qty');
            let total_amount = $(this).data('total-amount');

            $('#ModalLabel').text("Edit Product")
            $('#btn_submit').text("Edit Product")
            $('#po_detail_form').attr('action', update_url);

            $('#edit_po_detail_id').val(id);
            $('#product').val(product_id).trigger('change');
            $('#order_qty').val(order_qty);
            $('#total_amount').val(total_amount);

            $('#modal_po_detail').modal('show');
        })
    })
</script>

<script type="text/javascript">
    const store_url = "<?= base_url('purchaseorder/adddetail')?>";
    const update_url = "<?= base_url('purchaseorder/updatedetail')?>";
</script>

<?= $this->endSection(); ?>