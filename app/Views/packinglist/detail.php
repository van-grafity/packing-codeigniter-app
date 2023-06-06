<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
    .table-wrapper {
        border: 1px solid #ced4da;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    #packinglist_carton_table th,
    #packinglist_carton_table td {
        vertical-align: middle!important;
    }
</style>

<div class="content-wrapper">
    <section class="content mb-4">
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
                                <td> <?= esc($packinglist->destination); ?> </td>
                            </tr>
                            <tr>
                                <td><b>Cut Qty.</b></td>
                                <td><?= esc($packinglist->packinglist_cutting_qty); ?></td>
                                <td><b>Departments</b></td>
                                <td> <?= esc($packinglist->department); ?> </td>
                            </tr>
                            <tr>
                                <td><b>Ship Qty.</b></td>
                                <td><?= esc($packinglist->packinglist_ship_qty); ?></td>
                                <td><b>Customer</b></td>
                                <td> xxxxx </td>
                            </tr>
                            <tr>
                                <td><b>Total Carton</b></td>
                                <td> <?= esc($packinglist->total_carton); ?> </td>
                                <td><b>Ship Date</b></td>
                                <td><?= esc($packinglist->shipdate); ?></td>
                            </tr>
                            <tr>
                                <td><b>Percentage Ship</b></td>
                                <td> <?= esc($packinglist->percentage_ship); ?> </td>
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
                <table class="table table-bordered" id="packinglist_carton_table">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%" rowspan="1" colspan="2">Ctn No.</th>
                            <th width="15%" rowspan="2" colspan="1">UPC</th>
                            <th width="15%" rowspan="2" colspan="1">Colour</th>
                            <th width="20%" rowspan="<?= $size_rowspan?>" colspan="<?= $size_colspan; ?>">Size</th>
                            <th width="5%" rowspan="2" colspan="1">Pcs / Carton</th>
                            <th width="5%" rowspan="2" colspan="1">Total Carton</th>
                            <th width="10%" rowspan="2" colspan="1">Ship Qty</th>
                            <th width="5%" rowspan="2" colspan="1">NW (Kgs)</th>
                            <th width="5%" rowspan="2" colspan="1">GW (Kgs)</th>
                            <th width="20%" rowspan="2" colspan="1">Action</th>
                        </tr>
                        <tr class="table-primary text-center">
                            <th rowspan="1" colspan="1" class="">from</th>
                            <th rowspan="1" colspan="1" class="">to</th>
                            <?php foreach ($packinglist_size_list as $key => $size) { ?>
                                <th rowspan="1" colspan="1" class=""><?= $size->size ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($packinglist_carton as $key => $carton) { ?>
                            <tr class="text-center">
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>" > <?= $carton->carton_number_from ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>" > <?= $carton->carton_number_to ?> </td>
                                <?php foreach ($carton->products_in_carton as $key_product => $product) { ?>
                                    <?php if($key_product == 0 ) {?>
                                        <td> <?= $carton->products_in_carton[$key_product]->product_code ?> </td>
                                        <td> <?= $carton->products_in_carton[$key_product]->colour ?> </td>
                                        <?php foreach ($product->ratio_by_size_list as $key_size => $size) { ?>
                                            <td> <?= $size->size_qty ?> </td>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>" > <?= $carton->pcs_per_carton ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>" > <?= $carton->carton_qty ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>" > <?= $carton->ship_qty ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>" > <?= $carton->net_weight ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>" > <?= $carton->gross_weight ?> </td>
                                <td rowspan="<?= $carton->number_of_product_per_carton; ?>">
                                    <a class="btn btn-warning btn-sm btn-edit" onclick="edit_packinglist_carton(<?= $carton->id; ?>)"  >Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $carton->id ?>">Delete</a>
                                </td>
                            </tr>
                            <?php if($carton->number_of_product_per_carton > 1) {  ?>
                                <?php foreach ($carton->products_in_carton as $key_product => $product) { ?>
                                    <?php if( $key_product > 0 ) {?>
                                        <tr class="text-center">
                                            <td> <?= $carton->products_in_carton[$key_product]->product_code ?> </td>
                                            <td> <?= $carton->products_in_carton[$key_product]->colour ?> </td>
                                            <?php foreach ($product->ratio_by_size_list as $key_size => $size) { ?>
                                                <td> <?= $size->size_qty ?> </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>

        <div class="row text-right">
            <div class="col-12">
                <a href="<?= base_url('packinglist')?>" class="btn btn-secondary">Back</a>
            </div>
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
                <input type="hidden" name="edit_packinglist_carton_id" id="edit_packinglist_carton_id">
                <input type="hidden" name="packinglist_id" value="<?= $packinglist->id  ?>">
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
                    <button type="submit" class="btn btn-primary btn-submit" id="btn_submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit Carton -->



<!-- Modal Delete Carton -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../index.php/packinglist/cartondelete" method="post">
                <input type="hidden" name="packinglist_id" value="<?= $packinglist->id  ?>">
                <input type="hidden" name="packinglist_carton_id" id ="packinglist_carton_id" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Carton</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Carton ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete Carton -->

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
        // if(is_table_empty()) {
        //     clear_carton_contents();
        // }
        
        let date_today = new Date().toJSON().slice(0, 10);
        $('#packinglist_date').val(date_today);
        $('#carton_qty').val(0);
        $('#ship_qty').val(0);
        $('#gross_weight').val(0);
        $('#net_weight').val(0);
        clear_carton_contents();
        update_total_pcs();
        
        $('#packinglist_modal').modal('show');
    });
    
    $('.btn-delete').on('click', function() {
        let id = $(this).data('id');
        $('#packinglist_carton_id').val(id);
        if (id) {
            $('#delete_message').text(`Are you sure want to delete this Carton?`);
        }
        $('#deleteModal').modal('show');
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
        
        // ## if table empty replace default row to new data at the first row
        if(is_table_empty()) {
            clear_carton_contents('empty');
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
const store_url = '<?= base_url('packinglistcarton/store')?>';
const edit_url = '<?= base_url('packinglistcarton/edit')?>';
const update_url = '<?= base_url('packinglistcarton/update')?>';

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
            <button type="button" class="btn btn-danger btn-sm btn-delete-product" onclick="delete_carton_content(this)">Delete</button>
        </td>
    </tr>
    `
    return element;
}

function delete_carton_content(element) {
    $(element).parents('tr').remove();
    if(is_table_empty()) {
        clear_carton_contents()
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

function clear_carton_contents(type = false) {
    if (type == 'empty') {
        $('#table_carton_contents tbody').html(``);
    } else {
        $('#table_carton_contents tbody').html(`<td class="align-middle" colspan="6"> Empty Carton</td>`);
    }
}


async function edit_packinglist_carton(packinglist_carton_id) {
    params_data = { id : packinglist_carton_id };
    result = await using_fetch(edit_url, params_data, "GET");
    
    let carton_detail = result.data.carton_detail;
    if(carton_detail.length <= 0) { clear_carton_contents(); };
    
    clear_form({
        modal_id: 'packinglist_modal',
        modal_title: "Edit Carton",
        modal_btn_submit: "Save",
        form_action_url: update_url,
    });
    clear_carton_contents('empty');

    carton_detail.forEach(data => {
        console.log(data);
        let data_element = {
            product_id: data.product_id ,
            product_code: data.product_code ,
            product_name: data.product_name ,
            product_colour: data.colour ,
            product_style: data.product_id ,
            product_size: data.size ,
            product_qty: data.product_qty,
        }
        let element_tr = create_element_tr(data_element);
        $('#table_carton_contents tbody').append(element_tr);
    });
    
    let packinglist_carton = result.data.packinglist_carton;
    $('#carton_qty').val(packinglist_carton.carton_qty);
    $('#gross_weight').val(packinglist_carton.gross_weight);
    $('#net_weight').val(packinglist_carton.net_weight);
    $('#carton_number_from').val(packinglist_carton.carton_number_from);
    $('#carton_number_to').val(packinglist_carton.carton_number_to);
    $('#edit_packinglist_carton_id').val(packinglist_carton.id);
    

    // result = await get_using_fetch(url_edit);
    // form = $('#buyer_form')
    // form.append('<input type="hidden" name="_method" value="PUT">');
    // $('#modal_formLabel').text("Edit Buyer");
    // $('#btn_submit').text("Save");
    // $('#modal_form').modal('show')

    // let url_update = update_url.replace(':id',buyer_id);
    // form.attr('action', url_update);
    // form.find('input[name="name"]').val(result.name);
    // form.find('input[name="address"]').val(result.address);
    // form.find('input[name="shipment_address"]').val(result.shipment_address);
    // form.find('input[name="code"]').val(result.code);

    $('#packinglist_modal').modal('show');

    update_total_pcs()
    update_ship_qty();
}
</script>
<?= $this->endSection('page_script'); ?>