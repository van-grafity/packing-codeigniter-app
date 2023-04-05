<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--Isikan Header di sini bila diinginkan -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- /.card -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h3>Product Lists</h3>
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addModal">Add New</button>

                            <table id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="text-center align-middle" scope="col">SN</th>
                                        <th class="text-center align-middle" scope="col">Prod Code</th>
                                        <th class="text-center align-middle" scope="col">ASIN #</th>
                                        <th class="text-center align-middle" scope="col">Description</th>
                                        <th class="text-center align-middle" scope="col">Price</th>
                                        <th class="text-center align-middle" scope="col">Category</th>
                                        <th class="text-center align-middle" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($product as $row) : ?>
                                        <tr>
                                            <th class="text-center" scope="row"><?= $i++; ?></th>
                                            <td><?= $row->product_code; ?></td>
                                            <td><?= $row->product_asin_id; ?></td>
                                            <td><?= $row->product_name; ?></td>
                                            <td class="text-right"><?= number_to_currency($row->product_price, 'USD', 'en_US', 2); ?></td>
                                            <td><?= $row->category_name; ?></td>
                                            <td>
                                                <a class="btn btn-success btn-sm btn-detail" data-id="<?= $row->product_id; ?>" data-code="<?= $row->product_code; ?>" data-asin="<?= $row->product_asin_id; ?>" data-style="<?= $row->style; ?>" data-name="<?= $row->product_name; ?>" data-price="<?= $row->product_price; ?>" data-category_id="<?= $row->product_category_id; ?>">Details</a>
                                                <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $row->product_id; ?>" data-code="<?= $row->product_code; ?>" data-asin="<?= $row->product_asin_id; ?>" data-style="<?= $row->style; ?>" data-name="<?= $row->product_name; ?>" data-price="<?= $row->product_price; ?>" data-category_id="<?= $row->product_category_id; ?>">Edit</a>
                                                <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $row->product_id; ?>">Delete</a>
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

        <!-- Modal Add Product-->
        <form action="../index.php/product/save" method="post">
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Product Code</label>
                                <input type="text" class="form-control" name="product_code" placeholder="Product Code" autofocus>
                            </div>

                            <div class="form-group">
                                <label>Product ASIN #</label>
                                <input type="text" class="form-control" name="product_asin_id" placeholder="Product ASIN #">
                            </div>

                            <div class="form-group">
                                <label>Style</label>
                                <input type="text" disabled class="form-control style" name="style" placeholder="Product Style">
                            </div>

                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="product_name" placeholder="Product Name">
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" name="product_price" placeholder="Product Price">
                            </div>

                            <div class="form-group">
                                <label>Category</label>
                                <select name="product_category" class="form-control">
                                    <option value="">-Select-</option>
                                    <?php foreach ($category as $row) : ?>
                                        <option value="<?= $row->category_id; ?>"><?= $row->category_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Modal Add Product-->

        <!-- Modal Details Product-->
        <form action="" method="post">
            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Product Code</label>
                                <input type="text" disabled class="form-control product_code" name="product_code" placeholder="Product Code">
                            </div>

                            <div class="form-group">
                                <label>Product ASIN #</label>
                                <input type="text" disabled class="form-control product_asin_id"" name=" product_asin_id" placeholder="Product ASIN #">
                            </div>

                            <div class="form-group">
                                <label>Style</label>
                                <input type="text" disabled class="form-control style" name="style" placeholder="Product Style">
                            </div>

                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" disabled class="form-control product_name" name="product_name" placeholder="Product Name">
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" disabled class="form-control product_price" name="product_price" placeholder="Product Price">
                            </div>

                            <div class="form-group">
                                <label>Category</label>
                                <select name="product_category" class="form-control">
                                    <option value="" disabled>-Select-</option>
                                    <?php foreach ($category as $row) : ?>
                                        <option value="<?= $row->category_id; ?>"><?= $row->category_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="product_id" class="product_id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Modal Details Product-->

        <!-- Modal Edit Product-->
        <form action="../index.php/product/update" method="post">
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Product Code</label>
                                <input type="text" class="form-control product_code" name="product_code" placeholder="Product Code">
                            </div>

                            <div class="form-group">
                                <label>Product ASIN #</label>
                                <input type="text" class="form-control product_asin_id" name="product_asin_id" placeholder="Product ASIN #">
                            </div>

                            <div class="form-group">
                                <label>Style</label>
                                <input type="text" class="form-control style" name="style" placeholder="Product Style">
                            </div>

                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control product_name" name="product_name" placeholder="Product Name">
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control product_price" name="product_price" placeholder="Product Price">
                            </div>

                            <div class="form-group">
                                <label>Category</label>
                                <select name="product_category" class="form-control product_category">
                                    <option value="">-Select-</option>
                                    <?php foreach ($category as $row) : ?>
                                        <option value="<?= $row->category_id; ?>"><?= $row->category_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="product_id" class="product_id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Modal Edit Product-->

        <!-- Modal Delete Product-->
        <form action="../index.php/product/delete" method="post">
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <h4>Are you sure want to delete this product?</h4>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="product_id" class="productID">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Modal Delete Product-->

        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                // get Product Detail
                $('.btn-detail').on('click', function() {
                    // get data from button detail
                    const id = $(this).data('id');
                    const code = $(this).data('code');
                    const asin = $(this).data('asin');
                    const style = $(this).data('style');
                    const name = $(this).data('name');
                    const price = $(this).data('price');
                    const category = $(this).data('category_id');
                    // Set data to Form Detail
                    $('.product_id').val(id);
                    $('.product_code').val(code);
                    $('.product_asin_id').val(asin);
                    $('.style').val(style);
                    $('.product_name').val(name);
                    $('.product_price').val(price);
                    $('.product_category').val(category).trigger('change');
                    // Call Modal Detail
                    $('#detailModal').modal('show');
                });

                // get Edit Product
                $('.btn-edit').on('click', function() {
                    // get data from button edit
                    const id = $(this).data('id');
                    const code = $(this).data('code');
                    const asin = $(this).data('asin');
                    const style = $(this).data('style');
                    const name = $(this).data('name');
                    const price = $(this).data('price');
                    const category = $(this).data('category_id');
                    // Set data to Form Edit
                    $('.product_id').val(id);
                    $('.product_code').val(code);
                    $('.product_asin_id').val(asin);
                    $('.style').val(style);
                    $('.product_name').val(name);
                    $('.product_price').val(price);
                    $('.product_category').val(category).trigger('change');
                    // Call Modal Edit
                    $('#editModal').modal('show');
                });

                // get Delete Product
                $('.btn-delete').on('click', function() {
                    // get data from button delete
                    const id = $(this).data('id');
                    // Set data to Form Delete
                    $('.productID').val(id);
                    // Call Modal Delete
                    $('#deleteModal').modal('show');
                });
            });
        </script>
    </section>
</div>
<?= $this->endSection('content'); ?>