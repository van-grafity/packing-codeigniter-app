<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
#carton_detail_table tbody td {
    vertical-align: middle
}
</style>

<div class="content-wrapper">
    <section class="content mb-4">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <div class="card-title">Search Carton by Barcode</div>
            </div>
            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <form action="" method="post" id="barcode_form">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="carton_barcode" name="carton_barcode"
                                        placeholder="Input Barcode Here" autofocus>
                                    <div class="ml-2">
                                        <button type="submit" class="btn btn-success"
                                            id="btn_submit_form">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-info mt-2">
            <div class="card-header">
                <div class="card-title">Carton Detail</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">Order No</dt>
                            <dd class="col-md-7 col-sm-12" id="po_number"> - </dd>

                            <dt class="col-md-5 col-sm-12">Packinglist No</dt>
                            <dd class="col-md-7 col-sm-12" id="pl_number"> - </dd>

                            <dt class="col-md-5 col-sm-12">Buyer</dt>
                            <dd class="col-md-7 col-sm-12" id="buyer"> - </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-md-5 col-sm-12">Carton No</dt>
                            <dd class="col-md-7 col-sm-12" id="carton_number"> - </dd>

                            <dt class="col-md-5 col-sm-12">Total Carton</dt>
                            <dd class="col-md-7 col-sm-12" id="total_carton"> - </dd>

                            <dt class="col-md-5 col-sm-12">Total PCS</dt>
                            <dd class="col-md-7 col-sm-12" id="total_pcs"> - </dd>
                        </dl>
                    </div>
                    <div class="col-sm-8">
                        <h6 class="text-bold">Product in Carton :</h6>
                        <div class="table-responsive p-0 ">
                            <table id="carton_detail_table" class="table table-bordered table-sm">
                                <thead class="">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>UPC</th>
                                        <th>Name</th>
                                        <th>Colour</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td colspan="6">Empty Data</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-right">
            <div class="col-12">
                <a href="<?= base_url('cartonbarcode')?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
$(document).ready(function() {

    reset_field();

    $('#barcode_form').on('submit', function(e) {
        e.preventDefault();
        let carton_barcode = $('#carton_barcode').val();
        $('#carton_barcode').val('');
        
        // ## If no Entry Barcode Skip;
        if(!carton_barcode) return false;
        show_detail_carton(carton_barcode)
    });

})
</script>

<script type="text/javascript">
const detail_carton_url = '<?= base_url('scanpack/detailcarton')?>';

async function show_detail_carton(carton_barcode) {
    params_data = { carton_barcode };
    result = await using_fetch(detail_carton_url, params_data, "GET");
    
    if(result.status == 'error') { 
        reset_field();
        return false;
    }
    let data_po = result.data.data_po;
    let carton_detail = result.data.carton_detail;

    set_po_detail(data_po);
    set_carton_detail(carton_detail)

}

function reset_field() {
    $('#po_number').text('-');
    $('#pl_number').text('-');
    $('#buyer').text('-');
    $('#carton_number').text('-');
    $('#total_carton').text('-');
    $('#total_pcs').text('-');

    let empty_row = `
        <tr class="text-center">
            <td colspan="6">Empty Data</td>
        </tr>
    `;
    $('#carton_detail_table tbody').html(empty_row);
}

function set_po_detail(data_po) {
    $('#po_number').text(data_po.po_number);
    $('#pl_number').text(data_po.pl_number);
    $('#buyer').text(data_po.buyer);
    $('#carton_number').text(data_po.carton_number);
    $('#total_carton').text(data_po.total_carton);
    $('#total_pcs').text(data_po.total_pcs);
}

function set_carton_detail(carton_detail) {

    $('#carton_detail_table tbody').html('');

    let total = 0;
    carton_detail.forEach((data, key) => {
        let row = `
                <tr class="text-center">
                    <td>${key+1}</td>
                    <td>${data.product_code}</td>
                    <td>${data.product_name}</td>
                    <td>${data.product_colour}</td>
                    <td>${data.product_size}</td>
                    <td>${data.product_qty}</td>
                </tr>
            `;
        $('#carton_detail_table tbody').append(row);

        total += parseInt(data.product_qty);
    });
    let row_footer = `
            <tr>
                <td colspan="5" class="text-right">Total PCS :</td>
                <td colspan="1">${total}</td>
            </tr>
        `;
    $('#carton_detail_table tfoot').html(row_footer);
}
</script>
<?= $this->endSection('page_script'); ?>