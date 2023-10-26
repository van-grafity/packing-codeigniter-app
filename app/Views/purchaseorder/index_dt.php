<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addModal">Add New</button>
                <button type="button" class="btn btn-success ml-2 mb-2" onclick="show_import_modal()">Add PO via Import</button>

                <table id="purchase_order_table" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="table-primary">
                            <th class="" width="50px">SN</th>
                            <th class="">PO No.</th>
                            <th class="">Buyer</th>
                            <th class="">GL No.</th>
                            <th class="">Ship Date</th>
                            <th class="">Total Qty</th>
                            <th class=" <?= $action_field_class; ?>">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="<?= base_url('purchaseorder/savePO')?>" method="post" id="purchase_order_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Purchase Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="po_no">PO No.</label>
                        <input type="text" class="form-control" id="po_no" name="po_no" placeholder="PO No." required>
                    </div>
                    <div class="form-group">
                        <label>GL Number</label>
                        <select id="gl_no" name="gl_no[]" class="form-control select2" multiple="multiple" data-placeholder="Choose GL" placeholder="Choose GL" required>
                            <?php foreach ($GL as $g) : ?>
                                <option value="<?= $g->id; ?>"><?= $g->gl_number; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!-- <select class="select2bs4" multiple="multiple" data-placeholder="Select a State"
                          style="width: 100%;"> -->
                    </div>
                    <div class="form-group">
                        <label for="shipdate">Ship Date</label>
                        <input type="date" class="form-control" id="shipdate" name="shipdate" placeholder="Ship Date" required onclick="this.showPicker()">
                    </div>
                    <div class="form-group">
                        <label for="total_order_qty">Total Qty</label>
                        <input type="text" readonly class="form-control" id="total_order_qty" name="total_order_qty" placeholder="Total Order Qty">
                    </div>
                    <div class="form-group">
                        <label for="total_amount">PO Amount</label>
                        <input type="text" readonly class="form-control" id="total_amount" name="total_amount" placeholder="Total Amount">
                    </div>
                    <div class="form-group">
                        <label>Order Details</label>
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered" id="po_detail_table">
                            <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th width="30%">Product Name</th>
                                    <th width="15%">Unit Price</th>
                                    <th>Size</th>
                                    <th width="15%">Order Qty</th>
                                    <th colspan="2" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Purchase Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Purchase Order -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('purchaseorder/delete')?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Purchase Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Purchase Order ?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="po_id" id="po_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete Purchase Order -->

<?= $this->include('purchaseorder/modal_import_excel') ?>

<script>
    const index_dt_url = '<?= url_to('purchase_order_list')?>';

    function count_po_details() {
        return $('#po_detail_table tbody tr').length;
    }

    function add_po_detail() {
        let element = create_blank_element_tr();
        $('#po_detail_table tbody').append(element);
        update_total_order_qty();
    }

    function delete_po_detail(element) {
        if (count_po_details() > 1) {
            $(element).parents('tr').remove();
        } else {
            alert('Purchase Order Detail cannot be less than 1');
        }

        $("#po_detail_table tbody tr").find('.btn-detail-delete').first().trigger("focus");
        update_total_order_qty();
    }

    function set_product_info() {
        let optionElement = $(event.target);
        let productData = $(event.target).find($('option:selected')).data();

        if (optionElement.val()) {
            optionElement.parents('tr').find('input[name="product_name[]"]').val(productData.productName);
            optionElement.parents('tr').find('input[name="product_price[]"]').val(productData.productPrice);
            optionElement.parents('tr').find('input[name="product_size[]"]').val(productData.productSize);
        } else {
            optionElement.parents('tr').find('input[name="product_name[]"]').val('');
            optionElement.parents('tr').find('input[name="product_price[]"]').val('');
            optionElement.parents('tr').find('input[name="product_size[]"]').val('');
        }
    }

    function update_total_order_qty() {
        let total_order_qty = 0;
        $('input[name="order_qty[]"]').each(function() {
            total_order_qty += parseFloat($(this).val()) || 0;
        });
        $('#total_order_qty').val(total_order_qty);
        update_po_amout();
    }

    function update_po_amout() {
        let all_po_detail = $('#po_detail_table > tbody tr');
        let total_amount = 0;

        all_po_detail.each(function() {
            product_price = parseFloat($(this).find('input[name="product_price[]"]').val()) || 0;
            order_qty = parseInt($(this).find('input[name="order_qty[]"]').val()) || 0;
            total_amount += product_price * order_qty;
        });
        $('#total_amount').val(total_amount.toFixed(2));
    }

    function create_blank_element_tr() {
        let element = `
        <tr>
            <td>
                <select class="form-control" type="text" name="product_code[]" onchange="javascript:set_product_info();" required>
                    <option value="">-Product Code-</option>
                    <?php foreach ($Product as $p) : ?>
                        <option value="<?= $p->id; ?>" data-product-name="<?= $p->product_name; ?>" data-product-price="<?= $p->product_price; ?>" data-product-size="<?= $p->product_size; ?>"><?= $p->product_code; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="text" readonly name="product_name[]" class="form-control" placeholder="Product Name"/></td>
            <td><input type="text" readonly name="product_price[]" class="form-control" placeholder="Unit Price" /></td>
            <td><input type="text" readonly name="product_size[]" class="form-control" placeholder="Product Size" /></td>
            <td><input type="number" class="form-control" name="order_qty[]" placeholder="Order Qty" onkeydown="if(event.key==='.'){event.preventDefault();}" required></td>
            <td style="text-align: center;">
                <a type="button" href="javascript:void(0);" onclick="delete_po_detail(this);" class="btn btn-danger btn-sm btn-detail-delete"><i class="fas fa-minus"></i></a>
            </td>
            <td style="text-align: center;">
                <a type="button" href="javascript:void(0);" onclick="add_po_detail();" class="btn btn-success btn-sm"><i class="fas fa-plus" ></i></a>
            </td>
        </tr>
        `
        return element;
    }
</script>

<script>
    $(document).ready(function() {

        // ## Show Flash Message
        let session = <?= json_encode(session()->getFlashdata()) ?>;
        show_flash_message(session);
        
        //## Check PO Details, at least 1 product
        if (count_po_details() <= 0) {
            add_po_detail();
        }

        // ## prevent submit form when keyboard press enter
        $('#purchase_order_form input').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        // ## Shipdate Field show date picker when focus and enter is pressed
        $('#shipdate').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                $('#shipdate').trigger('click')
            }
        })

        // Show Delete Modal
        $('.btn-delete').on('click', function() {
            let id = $(this).data('id');
            let po_number = $(this).data('po-number');

            $('#po_id').val(id);
            if (po_number) {
                $('#delete_message').text(`Are you sure want to delete this Purchase Order (${po_number}) ?`);
            }

            $('#deleteModal').modal('show');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#gl_no.select2').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#addModal')
        });

        $('#purchase_order_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: index_dt_url,
            order: [],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'po_no', name: 'po.po_no'},
                { data: 'buyer_name', name: 'sync_po.buyer_name' },
                { data: 'gl_number', name: 'sync_po.gl_number' },
                { data: 'shipdate', name: 'po.shipdate' },
                { data: 'po_qty', name: 'po.po_qty' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            columnDefs: [
                { targets: [0,-1], orderable: false, searchable: false },
            ],
            paging: true,
            responsive: true,
            lengthChange: true,
            searching: true,
            autoWidth: false,
            orderCellsTop: true,
            dom: "<'row'<'col-md-2'l><'col-md-6'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
            buttons: ["excel", "pdf", "print"],
        });
    });
</script>
<?= $this->endSection(); ?>