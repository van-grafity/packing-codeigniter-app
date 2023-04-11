<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    <!-- /.content header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- /.card -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h3>Buyer PO Lists</h3>
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addModal">Add New</button>

                            <table id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="text-center align-middle" scope="col">SN</th>
                                        <th class="text-center align-middle" scope="col">Buyer</th>
                                        <th class="text-center align-middle" scope="col">Order No</th>
                                        <th class="text-center align-middle" scope="col">Product</th>
                                        <th class="text-center align-middle" scope="col">Unit Price</th>
                                        <th class="text-center align-middle" scope="col">Order Qty</th>
                                        <th class="text-center align-middle" scope="col">Amount</th>
                                        <th class="text-center align-middle" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($buyerPO as $row) : ?>
                                        <tr>
                                            <th class="text-center" scope="row"><?= $row->PO_buyer_id; ?></th>
                                            <td><?= $row->buyer_name; ?></td>
                                            <td><?= $row->PO_No; ?></td>
                                            <td><?= $row->product_name; ?></td>
                                            <td class="text-right"><?= number_to_currency($row->unit_price, 'USD', 'en_US', 2); ?></td>
                                            <td class="text-right"><?= $row->PO_qty; ?></td>
                                            <td class="text-right"><?= number_to_currency($row->unit_price * $row->PO_qty, 'USD', 'en_US', 2); ?></td>
                                            <td>
                                                <a class="btn btn-success btn-sm btn-detail" data-id="<?= $row->id; ?>" data-buyer_id="<?= $row->PO_buyer_id; ?>" data-po_no="<?= $row->PO_No; ?>" data-name="<?= $row->product_name; ?>" data-style="<?= $row->style; ?>" data-unit_price="<?= $row->unit_price; ?>" data-po_qty="<?= $row->PO_qty; ?>" data-buyer_name="<?= $row->buyer_name; ?>">Details</a>
                                                <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $row->id; ?>" data-buyer_id="<?= $row->PO_buyer_id; ?>" data-po_no="<?= $row->PO_No; ?>" data-name="<?= $row->product_name; ?>" data-style="<?= $row->style; ?>" data-unit_price="<?= $row->unit_price; ?>" data-po_qty="<?= $row->PO_qty; ?>" data-buyer_name="<?= $row->buyer_name; ?>">Edit</a>
                                                <a class="btn btn-danger btn-sm btn-delete">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Details Buyer PO -->
        <form action="" method="post">
            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">PO Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Buyer</label>
                                <select name="buyer_name" class="form-control buyer_name">
                                    <option value="" disabled>-Select-</option>
                                    <?php foreach ($buyer as $row) : ?>
                                        <option value="<?= $row->buyer_id; ?>"><?= $row->buyer_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>PO No</label>
                                <input type="text" disabled class="form-control po_no" name="po_no" placeholder="Po number">
                            </div>

                            <div class="form-group">
                                <label>Product</label>
                                <input type="text" disabled class="form-control name" name="name" placeholder="Product Name">
                            </div>

                            <div class="form-group">
                                <label>Style</label>
                                <input type="text" disabled class="form-control style" name="style" placeholder="Style">
                            </div>

                            <div class="form-group">
                                <label>Unit Price</label>
                                <input type="text" disabled class="form-control unit_price" name="unit_price" placeholder="Unit Price">
                            </div>

                            <div class="form-group">
                                <label>Qty Order</label>
                                <input type="text" disabled class="form-control po_qty" name="po_qty" placeholder="Ordered Qty">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" class="id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Modal Details Buyer PO -->

        <!-- Modal Edit Buyer PO -->
        <form action="../index.php/po/update" method="post">
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">PO Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Buyer</label>
                                <select name="buyer_name" class="form-control buyer_name">
                                    <option value="">-Select-</option>
                                    <?php foreach ($buyer as $row) : ?>
                                        <option value="<?= $row->buyer_id; ?>"><?= $row->buyer_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>PO No</label>
                                <input type="text" class="form-control po_no" name="po_no" placeholder="Po number">
                            </div>

                            <div class="form-group">
                                <label>Product</label>
                                <input type="text" class="form-control name" name="name" placeholder="Product Name">
                            </div>

                            <div class="form-group">
                                <label>Style</label>
                                <input type="text" class="form-control style" name="style" placeholder="Style">
                            </div>

                            <div class="form-group">
                                <label>Unit Price</label>
                                <input type="text" class="form-control unit_price" name="unit_price" placeholder="Unit Price">
                            </div>

                            <div class="form-group">
                                <label>Qty Order</label>
                                <input type="text" class="form-control po_qty" name="po_qty" placeholder="Ordered Qty">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" class="id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Modal Edit Buyer PO -->

        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                // get Buyer PO Detail
                $('.btn-detail').on('click', function() {
                    // get data from button detail
                    const id = $(this).data('id');
                    const buyer_name = $(this).data('buyer_id');
                    const po_no = $(this).data('po_no');
                    const name = $(this).data('name');
                    const style = $(this).data('style');
                    const unit_price = $(this).data('unit_price');
                    const po_qty = $(this).data('po_qty');
                    
                    // Set data to Form Detail
                    $('.id').val(id);
                    $('.po_no').val(po_no);
                    $('.buyer_name').val(buyer_name).trigger('change');
                    $('.name').val(name);
                    $('.style').val(style);
                    $('.unit_price').val(unit_price);
                    $('.po_qty').val(po_qty);
                    
                    // Call Modal Detail
                    $('#detailModal').modal('show');
                });
                // get Buyer PO Edit
                $('.btn-edit').on('click', function() {
                    // get data from button edit
                    const id = $(this).data('id');
                    const buyer_name = $(this).data('buyer_id');
                    const po_no = $(this).data('po_no');
                    const name = $(this).data('name');
                    const style = $(this).data('style');
                    const unit_price = $(this).data('unit_price');
                    const po_qty = $(this).data('po_qty');
                    // Set data to Form Edit
                    $('.id').val(id);
                    $('.po_no').val(po_no);
                    $('.buyer_name').val(buyer_name).trigger('change');
                    $('.name').val(name);
                    $('.style').val(style);
                    $('.unit_price').val(unit_price);
                    $('.po_qty').val(po_qty);
                    // Call Modal Edit
                    $('#editModal').modal('show');
                });
            });
        </script>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>