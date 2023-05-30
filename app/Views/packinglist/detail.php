<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h4>SN : <?= esc($packinglist->packinglist_serial_number); ?></h4>
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
                                <td> xxxxx </td>
                            </tr>
                            <tr>
                                <td><b>Cut Qty.</b></td>
                                <td><?= esc($packinglist->packinglist_cutting_qty); ?></td>
                                <td><b>Departments</b></td>
                                <td> xxxxx </td>
                            </tr>
                            <tr>
                                <td><b>Ship Qty.</b></td>
                                <td>290</td> <!-- esc($packinglist->packinglist_ship_qty);  -->
                                <td><b>Customer</b></td>
                                <td> xxxxx </td>
                            </tr>
                            <tr>
                                <td><b>Total Carton</b></td>
                                <td> xxxxx </td>
                                <td><b>Ship Date</b></td>
                                <td><?= esc($packinglist->shipdate); ?></td>
                            </tr>
                            <tr>
                                <td><b>Percentage Ship</b></td>
                                <td> xxxxx </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-success">
            <div class="card-header">
                <h5 class="card-title">Packing List Carton</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-secondary mb-2" id="btn_modal_create">Add New</button>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%" rowspan="1" colspan="2" class="align-middle">Ctn No.</th>
                            <th width="20%" rowspan="2" colspan="1" class="align-middle">Colour</th>
                            <th width="30%" rowspan="1" colspan="4" class="align-middle">Size</th>
                            <th width="10%" rowspan="2" colspan="1" class="align-middle">Total Carton</th>
                            <th width="10%" rowspan="2" colspan="1" class="align-middle">Ship Qty</th>
                            <th width="5%" rowspan="2" colspan="1" class="align-middle">NW</th>
                            <th width="5%" rowspan="2" colspan="1" class="align-middle">GW</th>
                            <th width="15%" rowspan="2" colspan="1" class="align-middle">Action</th>
                        </tr>
                        <tr class="table-primary text-center">
                            <th rowspan="1" colspan="1" class="">from</th>
                            <th rowspan="1" colspan="1" class="">to</th>
                            <th rowspan="1" colspan="1" class="">S</th>
                            <th rowspan="1" colspan="1" class="">M</th>
                            <th rowspan="1" colspan="1" class="">L</th>
                            <th rowspan="1" colspan="1" class="">XL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td> xxxxx </td>
                            <td>
                                <a class="btn btn-warning btn-sm btn-edit">Edit</a>
                                <a class="btn btn-danger btn-sm btn-delete">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
</div>


<!-- Modal Add and Edit Carton -->
<div class="modal fade" id="packinglist_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="post" id="packinglist_form">
                <?= csrf_field(); ?>
                <input type="hidden" name="edit_packinglist_id" id="edit_packinglist_id">
                <div class="modal-header">
                    <h5 class="modal-title">Add Carton</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="product">Product Code :</label>
                                <select id="product" name="product" class="form-control" required>
                                    <option value="">Select Product Code </option>
                                    <?php foreach ($products as $key => $product) { ?>
                                    <option value="<?= esc($product->id) ?>"
                                        data-product-name="<?= esc($product->product_name) ?>"
                                        data-colour="<?= esc($product->colour) ?>"
                                        data-style="<?= esc($product->style) ?>"
                                        data-size="<?= esc($product->size) ?>"
                                        data-category="<?= esc($product->category) ?>"
                                        data-price="<?= esc($product->product_price) ?>"
                                    ><?= esc($product->product_code) ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="product_qty">Product Qty :</label>
                                <input type="number" class="form-control" id="product_qty" name="product_qty"
                                    placeholder="Product Qty">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h5 class="title label"> Product Detail :</h5>
                            <table class="table no-border" style="border: 1px solid #ced4da">
                                <tbody>
                                    <tr>
                                        <td width="20%">Product Name</td>
                                        <td width="30%" id="product_name">: </td>
                                        <td width="20%">Colour</td>
                                        <td width="30%" id="product_colour">: </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Style</td>
                                        <td width="30%" id="product_style">: </td>
                                        <td width="20%">Size</td>
                                        <td width="30%" id="product_size">: </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Category</td>
                                        <td width="30%" id="product_category">: </td>
                                        <td width="20%">Price</td>
                                        <td width="30%" id="product_price">: </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <button type="button" class="btn btn-success btn-sm">Add Product to Carton</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h5 class="">Carton Contents :</h5>
                            <table class="table table-bordered table-sm">
                                <thead class="text-center thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>UPC</th>
                                        <th>Colour</th>
                                        <th>Size</th>
                                        <th>Product Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>1</td>
                                        <td>081277364</td>
                                        <td>Med Heather Grey</td>
                                        <td>S</td>
                                        <td>1</td>
                                        <td>
                                            <a type="button" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="carton_qty">How many of these carton to add to the Packing List? :</label>
                                <input type="number" class="form-control" id="carton_qty" name="carton_qty"
                                    placeholder="Carton Quantity">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit Carton -->

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#btn_modal_create').on('click', function(e) {
        clear_form({
            modal_id: 'packinglist_modal',
            modal_title: "Add New Carton",
            modal_btn_submit: "Add Carton to Packing List",
            form_action_url: store_url,
        });
        // date_filter: ,

        let date_today = new Date().toJSON().slice(0, 10);
        $('#packinglist_date').val(date_today);
        $('#packinglist_modal').modal('show');

    });

    $('#product').on('change', function(event) {

        let selected_option = $(this).find($('option:selected'));
        console.log(selected_option.data());
        let product_name = selected_option.data('product-name');
        let product_colour = selected_option.data('colour');
        let product_style = selected_option.data('style');
        let product_size = selected_option.data('size');
        let product_category = selected_option.data('category');
        let product_price = selected_option.data('price');

        if ($(this).val()) {
            $('#product_name').text(product_name);
            $('#product_colour').text(product_colour);
            $('#product_style').text(product_style);
            $('#product_size').text(product_size);
            $('#product_category').text(product_category);
            $('#product_price').text(product_price);
        } else {
            $('#product_name').text('');
            $('#product_colour').text('');
            $('#product_style').text('');
            $('#product_size').text('');
            $('#product_category').text('');
            $('#product_price').text('');
        }
    })
})
</script>

<script type="text/javascript">
const store_url = "../index.php/packinglist/cartonstore";
// const update_url = "../index.php/packinglist/cartonupdate";
</script>
<?= $this->endSection('page_script'); ?>