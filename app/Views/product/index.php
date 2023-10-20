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
                <button type="button" class="btn btn-secondary mb-2 btn-success" id="btn-add-product" onclick="add_new_product()" >Add New</button>
                <button type="button" class="btn btn-success ml-2 mb-2 d-none" id="btn-import-product" onclick="show_import_modal()">Add Product via Import</button>
                <table id="product_table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class=" table-primary">
                            <th class="text-center align-middle" width="5%">SN</th>
                            <th class="text-center align-middle" width="10%">Prod Code</th>
                            <th class="text-center align-middle" width="10%">ASIN #</th>
                            <th class="text-center align-middle" width="10%">Category</th>
                            <th class="text-center align-middle" width="22%">Style</th>
                            <th class="text-center align-middle" width="20%">Description</th>
                            <th class="text-center align-middle" width="8%">Price</th>
                            <th class="text-center align-middle" width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.section -->
</div>

<!-- Modal Add and Edit Product Detail -->
<div class="modal fade" id="product_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="product_form">
                <input type="hidden" name="edit_product_id" value="" id="edit_product_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product_code" class="col-form-label">Product Code</label>
                        <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Product Code" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="asin" class="col-form-label">Product ASIN #</label>
                        <input type="text" class="form-control" id="product_asin" name="product_asin_id" placeholder="Product ASIN #">
                    </div>
                    <div class="form-group">
                        <label for="product_category" class="col-form-label">Product Type</label>
                        <select id="product_category_id" name="product_category" class="form-control">
                            <option value="">-Select Product Type-</option>
                            <?php foreach ($category as $cat) : ?>
                                <option value="<?= $cat->id; ?>"><?= $cat->category_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_style" class="col-form-label">Style</label>
                        <select id="product_style_id" name="product_style_id" class="form-control">
                            <option value="">-Select Style-</option>
                            <?php foreach ($style as $s) : ?>
                                <option value="<?= $s->id; ?>"><?= $s->style_description; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="colour" class="col-form-label">Colour</label>
                        <select id="product_colour_id" name="product_colour_id" class="form-control">
                            <option value="">-Select Colour-</option>
                            <?php foreach ($colour as $c) : ?>
                                <option value="<?= $c->id; ?>"><?= $c->colour_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="size" class="col-form-label">Size</label>
                        <select id="product_size_id" name="product_size_id" class="form-control">
                            <option value="">-Select Size-</option>
                            <?php foreach ($size as $sz) : ?>
                                <option value="<?= $sz->id; ?>"><?= $sz->size; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_name" class="col-form-label">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name">
                    </div>
                    <div class="form-group">
                        <label for="product_price" class="col-form-label">Price</label>
                        <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Product Price">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit Product Detail -->

<!-- Modal Delete Product-->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= url_to('product_delete')?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this product?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="product_id" id="product_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete Product-->


<?= $this->include('product/modal_import_excel') ?>

<?= $this->endSection('content'); ?>



<?= $this->Section('page_script'); ?>

<script type="text/javascript">
    const store_url = "<?php echo url_to('product_store') ?>";
    const update_url = "<?php echo url_to('product_update') ?>";
    const detail_url = "<?php echo url_to('product_detail') ?>";
    const index_dt_url = "<?php echo url_to('product_list') ?>";

    const add_new_product = () => {
        clear_form({
            modal_id: 'product_modal',
            modal_title: "Add New Product",
            modal_btn_submit: "Add Product",
            form_action_url: store_url,
        });
        $('#product_modal').modal('show');
    }

    const edit_product = async (product_id) => {
        clear_form({
            modal_id: 'product_modal',
            modal_title: "Edit Product",
            modal_btn_submit: "Update Product",
            form_action_url: update_url,
        });

        params_data = { id : product_id };
        result = await using_fetch(detail_url, params_data, "GET");

        product_data = result.data
        $('#edit_product_id').val(product_data.id);
        $('#product_code').val(product_data.product_code);
        $('#product_asin').val(product_data.product_asin_id);
        $('#product_category_id').val(product_data.product_category_id);
        $('#product_style_id').val(product_data.product_style_id);
        $('#product_colour_id').val(product_data.product_colour_id);
        $('#product_size_id').val(product_data.product_size_id);
        $('#product_name').val(product_data.product_name);
        $('#product_price').val(product_data.product_price);

        $('#product_modal').modal('show');
    }

    const delete_product = (product_id) => {
        $('#delete_message').text(`Are you sure want to delete this Product?`);
        $('#product_id').val(product_id);
        $('#delete_modal').modal('show');
    }
</script>

<script>
    $(document).ready(function() {
        // ## prevent submit form when keyboard press enter
        $('#product_form input').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        // ## Show Flash Message
        let session = <?= json_encode(session()->getFlashdata()) ?>;
        show_flash_message(session);

        let product_table = $('#product_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: index_dt_url,
            },
            order: [],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'product_code', name: 'tblproduct.product_code'},
                { data: 'product_asin_id', name: 'tblproduct.product_asin_id'},
                { data: 'category_name', name: 'tblcategory.category_name'},
                { data: 'style_no', name: 'tblstyle.style_no'},
                { data: 'style_description', name: 'tblstyle.style_description'},
                { data: 'product_price', name: 'tblproduct.product_price'},
                { data: 'action', name: 'action', orderable: false, searchable: false },
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
        });
    });
</script>

<?= $this->endSection('page_script'); ?>

