<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
    .table-wrapper {
        border: 1px solid #ced4da;
        border-radius: 5px;
        margin-bottom: 10px;
    }
</style>

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
                            <th width="20%" rowspan="2" colspan="1" class="align-middle">UPC</th>
                            <th width="20%" rowspan="2" colspan="1" class="align-middle">Colour</th>
                            <th width="30%" rowspan="1" colspan="4" class="align-middle">Size</th>
                            <th width="10%" rowspan="2" colspan="1" class="align-middle">Pcs / Carton</th>
                            <th width="10%" rowspan="2" colspan="1" class="align-middle">Total Carton</th>
                            <th width="10%" rowspan="2" colspan="1" class="align-middle">Ship Qty</th>
                            <th width="5%" rowspan="2" colspan="1" class="align-middle">NW (Kgs)</th>
                            <th width="5%" rowspan="2" colspan="1" class="align-middle">GW (Kgs)</th>
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
                        <?php foreach ($packinglist_carton as $key => $carton) { ?>
                            <tr class="text-center">
                                <td> <?= $carton->carton_number_from ?> </td>
                                <td> <?= $carton->carton_number_to ?> </td>
                                <td> <?= $carton->products_in_carton[0]->product_code ?> </td>
                                <!-- <td> xxxxx </td> -->
                                <td> <?= $carton->colour ?> </td>
                                <td> xxxxx </td>
                                <td> xxxxx </td>
                                <td> xxxxx </td>
                                <td> xxxxx </td>
                                <!-- <td colspan="4"> xxxxx </td> -->
                                <td> <?= $carton->pcs_per_carton ?> </td>
                                <td> <?= $carton->carton_qty ?> </td>
                                <td> <?= $carton->ship_qty ?> </td>
                                <td> <?= $carton->net_weight ?> </td>
                                <td> <?= $carton->gross_weight ?> </td>
                                <td>
                                    <a class="btn btn-warning btn-sm btn-edit">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
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
                <input type="hidden" name="packinglist_id" id="packinglist_id" value="<?= $packinglist->id  ?>">
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
                                <select id="product" class="form-control">
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
                                <input type="number" class="form-control" id="product_qty" placeholder="Product Qty">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h5 class="title label"> Product Detail :</h5>
                            <div class="table-wrapper">
                                <table class="table no-border">
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
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-success btn-sm" id="btn_add_product">Add Product to Carton</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h5 class="">Carton Contents :</h5>
                            <table class="table table-bordered table-sm" id="table_carton_contents">
                                <thead class="text-center thead-dark">
                                    <tr>
                                        <th class="d-none">Product ID</th>
                                        <th width="25%">UPC</th>
                                        <th width="30%">Colour</th>
                                        <th width="10%">Size</th>
                                        <th width="15%">Product Qty</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <!-- <td class="align-middle" colspan="6"> Empty Carton</td> -->
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-dark">
                                        <td class="text-right" colspan="3"> Total Pcs : </td>
                                        <td class="text-center" colspan="1" id="total_pcs"> 0 </td>
                                        <td class=""></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="carton_qty">How many of these carton to add to the Packing List? :</label>
                                <input type="number" class="form-control" id="carton_qty" name="carton_qty" value="0" placeholder="Carton Quantity">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="ship_qty">Ship Qty :</label>
                                <input type="number" class="form-control" id="ship_qty" name="ship_qty"  value="0" placeholder="Ship Quantity" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="gross_weight">Carton GW (Kgs): </label>
                                <input type="number" class="form-control" id="gross_weight" name="gross_weight" placeholder="Carton GW" step="0.01">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="net_weight">Carton NW (Kgs): </label>
                                <input type="number" class="form-control" id="net_weight" name="net_weight" placeholder="Carton NW" step="0.01">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="carton_number_from">Carton No. From : </label>
                                <input type="number" class="form-control" id="carton_number_from" name="carton_number_from" placeholder="From" min="1">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="carton_number_to">Carton No. To : </label>
                                <input type="number" class="form-control" id="carton_number_to" name="carton_number_to" placeholder="To" min="1">
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
    // ## prevent submit form when keyboard press enter
    $('#packinglist_form input').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
    });

    $('#btn_modal_create').on('click', function(e) {
        clear_form({
            modal_id: 'packinglist_modal',
            modal_title: "Add New Carton",
            modal_btn_submit: "Add Carton to Packing List",
            form_action_url: store_url,
        });

        // ## Add empty tr when no product selected
        if(is_table_empty()) {
            $('#table_carton_contents tbody').html(`<td class="align-middle" colspan="6"> Empty Carton</td>`);
        }
        
        let date_today = new Date().toJSON().slice(0, 10);
        $('#packinglist_date').val(date_today);
        $('#carton_qty').val(0);
        $('#ship_qty').val(0);
        $('#gross_weight').val(0);
        $('#net_weight').val(0);
        $('#packinglist_modal').modal('show');

    });

    // ## Set Product Detail Info on Product Code change
    $('#product').on('change', function(event) {
        let selected_option = $(this).find($('option:selected'));

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
    });

    $('#btn_add_product').on('click', function() {
        if(!$('#product').val()) {
            alert('Please select a product');
            return false;
        }

        if(!$('#product_qty').val()) {
            alert('Please provide a quantity for the product');
            return false;
        }
        
        if(is_product_already_added()){
            alert('Product already added!');
            return false;
        }
        
        if(is_table_empty()) {
            $('#table_carton_contents tbody').html('');
        }

        let data_element = {
            product_id: $('#product').val(),
            product_code: $('#product option:selected').text(),
            product_name: $('#product_name').text(),
            product_colour: $('#product_colour').text(),
            product_style: $('#product_style').text(),
            product_size: $('#product_size').text(),
            product_category: $('#product_category').text(),
            product_price: $('#product_price').text(),
            product_qty: parseInt($('#product_qty').val()),
        }
        let element_tr = create_element_tr(data_element);
        $('#table_carton_contents tbody').append(element_tr);
        
        $('#product').val('').trigger('change');
        $('#product_qty').val('0');
        update_total_pcs()
    });

    $('#carton_qty').on('input', function() {
        update_ship_qty();
    });

})
</script>

<script type="text/javascript">
const store_url = "../index.php/packinglist/cartonstore";
// const update_url = "../index.php/packinglist/cartonupdate";

function create_element_tr(data) {
    let element = `
    <tr>
        <td class="d-none">
            <input class="form-control" type="text" value="${data.product_id}" name="products_in_carton[]" readonly>
            <input class="form-control" type="text" value="${data.product_qty}" name="products_in_carton_qty[]" readonly>
        </td>
        <td class="align-middle" >${data.product_code}</td>
        <td class="align-middle" >${data.product_colour}</td>
        <td class="align-middle" >${data.product_size}</td>
        <td class="align-middle" >${data.product_qty}</td>
        <td class="align-middle" >
            <button type="button" class="btn btn-danger btn-sm btn-delete-product" onclick="delete_po_detail(this)">Delete</button>
        </td>
    </tr>
    `
    return element;
}

function delete_po_detail(element) {
    $(element).parents('tr').remove();
    if(is_table_empty()) {
        $('#table_carton_contents tbody').html(`<td class="align-middle" colspan="6"> Empty Carton</td>`);
    }
    update_total_pcs()
}

function is_table_empty() {
    let count_first_element = $(`#table_carton_contents tbody tr td`).length;
    if (count_first_element <= 1) {
        return true;
    }
    return false;
}

function is_product_already_added() {
    var product_on_carton = $("input[name='products_in_carton[]']").map(function(){return $(this).val();}).get();
    let product_selected_value = $('#product').val();
    if(product_on_carton.includes(product_selected_value)){
        return true;
    }
    return false;
}

function update_total_pcs() {
    let qty_per_product = $("input[name='products_in_carton_qty[]']").map(function(){return $(this).val();}).get();
    let sum_qty = qty_per_product.reduce((tempSum, next_arr) => tempSum + parseInt(next_arr), 0);
    $('#total_pcs').html(sum_qty);
    update_ship_qty();
}

function update_ship_qty() {
    let carton_qty = $('#carton_qty').val();
    if(carton_qty == '') {
        carton_qty = '0';
    }
    let total_pcs = parseInt($('#total_pcs').text());
    let ship_qty = carton_qty * total_pcs; 
    $('#ship_qty').val(ship_qty);
}

</script>
<?= $this->endSection('page_script'); ?>