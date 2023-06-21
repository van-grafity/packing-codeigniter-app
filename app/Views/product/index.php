<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
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
                <button type="button" class="btn btn-secondary mb-2" id="btn-add-detail">Add New</button>
                <table id="table1" class="table table-bordered table-striped table-hover">
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
                        <?php $i = 1; ?>
                        <?php foreach ($product as $p) : ?>
                            <tr>
                                <td class="text-center" scope="row"><?= $i++; ?></td>
                                <td><?= $p->product_code; ?></td>
                                <td><?= $p->product_asin_id; ?></td>
                                <td><?= $p->category_name; ?></td>
                                <td><?= $p->style_description; ?></td>
                                <td><?= $p->product_name; ?></td>
                                <td class="text-right"><?= number_to_currency($p->product_price, 'USD', 'en_US', 2); ?></td>
                                <td class="text-center">
                                    <a class="btn btn-success btn-sm btn-detail" data-id="<?= $p->id; ?>" data-product-code="<?= $p->product_code; ?>" data-product-asin="<?= $p->product_asin_id; ?>" data-category_id="<?= $p->product_category_id; ?>" data-style_id="<?= $p->product_style_id; ?>" data-colour_id="<?= $p->product_colour_id; ?>" data-size_id="<?= $p->product_size_id; ?>" data-name="<?= $p->product_name; ?>" data-price="<?= $p->product_price; ?>">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $p->id; ?>" data-product-code="<?= $p->product_code; ?>" data-product-asin="<?= $p->product_asin_id; ?>" data-category_id="<?= $p->product_category_id; ?>" data-style_id="<?= $p->product_style_id; ?>" data-colour_id="<?= $p->product_colour_id; ?>" data-size_id="<?= $p->product_size_id; ?>" data-name="<?= $p->product_name; ?>" data-price="<?= $p->product_price; ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $p->id; ?>" data-product-code="<?= $p->product_code; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
<div class="modal fade" id="modal_product_detail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
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
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../index.php/product/delete" method="post">
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

        $('#btn-add-detail').on('click', function(event) {
            $('#ModalLabel').text("Add Product")
            $('#product_form').attr('action', store_url);
            $('#btn_submit').attr('hidden', false);
            $('#product_form').find("input[type=text], input[type=number], textarea").val("");
            $('#product_form').find('select').val("").trigger('change');

            $('#modal_product_detail').modal('show');
        })

        // get Delete Product
        $('.btn-delete').on('click', function() {
            // get data from button delete
            let id = $(this).data('id');
            let product_code = $(this).data('product-code');

            // Set data to Form Delete
            $('#product_id').val(id);
            if (product_code) {
                $('#delete_message').text(`Are you sure want to delete Product Code (${product_code}) from this database ?`);
            }
            // Call Modal Delete
            $('#deleteModal').modal('show');
        });

        $('.btn-edit').on('click', function() {
            // get data from button detail
            let id = $(this).data('id');
            let code = $(this).data('product-code');
            let asin = $(this).data('product-asin');
            let category = $(this).data('category_id');
            let style = $(this).data('style_id');
            let colour = $(this).data('colour_id');
            let size = $(this).data('size_id');
            let name = $(this).data('name');
            let price = $(this).data('price');

            $('#ModalLabel').text("Edit Product")
            $('#btn_submit').text("Update Product")
            $('#btn_submit').attr('hidden', false);
            $('#product_form').attr('action', update_url);

            // Set ReadOnly the textboxes
            $('#edit_product_id').attr("readonly", false);
            $('#product_code').attr("readonly", false);
            $('#product_asin').attr("readonly", false);
            $('#product_category_id').attr("readonly", false);
            $('#product_style_id').attr("readonly", false);
            $('#product_colour_id').attr("readonly", false);
            $('#product_size_id').attr("readonly", false);
            $('#product_name').attr("readonly", false);
            $('#product_price').attr("readonly", false);

            // Set data to Form
            $('#edit_product_id').val(id);
            $('#product_code').val(code);
            $('#product_asin').val(asin);
            $('#product_category_id').val(category).trigger('change');
            $('#product_style_id').val(style).trigger('change');
            $('#product_colour_id').val(colour).trigger('change');
            $('#product_size_id').val(size).trigger('change');
            $('#product_name').val(name);
            $('#product_price').val(price);

            // Call Modal
            $('#modal_product_detail').modal('show');
        });

        $('.btn-detail').on('click', function() {
            // get data from button detail
            let id = $(this).data('id');
            let code = $(this).data('product-code');
            let asin = $(this).data('product-asin');
            let category = $(this).data('category_id');
            let style = $(this).data('style_id');
            let colour = $(this).data('colour_id');
            let size = $(this).data('size_id');
            let name = $(this).data('name');
            let price = $(this).data('price');

            // Set ReadOnly the textboxes
            $('#edit_product_id').attr("readonly", true);
            $('#product_code').attr("readonly", true);
            $('#product_asin').attr("readonly", true);
            $('#product_category_id').attr("readonly", true);
            $('#product_style_id').attr("readonly", true);
            $('#product_colour_id').attr("readonly", true);
            $('#product_size_id').attr("readonly", true);
            $('#product_name').attr("readonly", true);
            $('#product_price').attr("readonly", true);

            // Set data to Form Detail
            $('#edit_product_id').val(id);
            $('#product_code').val(code);
            $('#product_asin').val(asin);
            $('#product_category_id').val(category).trigger('change');
            $('#product_style_id').val(style).trigger('change');
            $('#product_colour_id').val(colour).trigger('change');
            $('#product_size_id').val(size).trigger('change');
            $('#product_name').val(name);
            $('#product_price').val(price);

            // Call Modal Detail
            $('#modal_product_detail').modal('show');
        });
    });
</script>

<script type="text/javascript">
    const store_url = "<?php echo base_url('product/save') ?>";
    const update_url = "<?php echo base_url('product/update') ?>";
</script>

<?= $this->endSection('content'); ?>