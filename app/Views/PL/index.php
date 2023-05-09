<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addModal">Add New</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle">PL No.</th>
                            <th class="text-center align-middle">PO No.</th>
                            <th class="text-center align-middle">Buyer</th>
                            <th class="text-center align-middle">GL No.</th>
                            <th class="text-center align-middle">Season</th>
                            <th class="text-center align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pl as $pl) : ?>
                            <tr>
                                <td><a href="<?= base_url('index.php/packinglist/' . $pl['packinglist_no']); ?>"><?= esc($pl['packinglist_no']); ?></a></td>
                                <td onClick="window.location.href='<?= base_url('index.php/home'); ?>'"><?= esc($pl['PO_No']); ?></td>
                                <td><?= esc($pl['buyer_name']); ?></td>
                                <td><?= esc($pl['gl_number']); ?></td>
                                <td><?= esc($pl['season']); ?></td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-warning btn-sm btn-edit">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<form action="<?= base_url('index.php/packinglist/store'); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Packing List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List No :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_no" name="packinglist_no" autofocus placeholder="Packing List No" value="<?= $packinglist_no; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="packinglist_po_id" class="col-sm-3 col-form-label">PO No :</label>
                        <select id="packinglist_po_id" name="packinglist_po_id" class="form-control">
                            <option value="">-Select-</option>
                            <?php foreach ($po as $p) : ?>
                                <option value="<?= $p->id; ?>"><?= $p->PO_No; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="packinglist_style_id" class="col-sm-3 col-form-label">Style :</label>
                        <select id="packinglist_style_id" name="packinglist_style_id" class="form-control">
                            <option value="">-Select-</option>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Date :</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="packinglist_date" name="packinglist_date" autofocus placeholder="Packing List Date" value="<?= date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Order Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_qty" name="packinglist_qty" autofocus placeholder="Order Qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Cutting Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_cutting_qty" name="packinglist_cutting_qty" autofocus placeholder="Cutting Qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Ship Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_ship_qty" name="packinglist_ship_qty" autofocus placeholder="Ship Qty">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Size :</label>
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="10%" class="text-center align-middle">Size</th>
                                    <th width="10%" class="text-center align-middle">Style</th>
                                    <th width="10%" class="text-center align-middle">Qty Per Carton</th>
                                    <th width="10%" class="text-center align-middle">Carton</th>
                                    <th width="10%" class="text-center align-middle">Amount</th>
                                    <th width="10%" class="text-center align-middle">#</th>
                                </tr>
                            </table>
                            <table class="table table-bordered" id="dynamic_field">
                                <tr>
                                    <td class="text-center align-middle" colspan="3">Please Select PO No.</td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small></small>
                                <button type="button" name="add" id="add" class="btn btn-success btn-sm" href="javascript:void(0);" onclick="addSize();">Add Size</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Amount :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_amount" name="packinglist_amount" autofocus placeholder="Packing List Amount">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url('index.php/packinglist'); ?>" class="btn btn-secondary">Close</a>
                    <button type="submit" class="btn btn-primary">Add Packing List</button>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    td {
        cursor: pointer;
    }
</style>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#packinglist_po_id').change(function() {
            var po_id = $(this).val();
            console.log(po_id);
            if (po_id != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/packinglist/get_by_po/" + po_id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                        $('#packinglist_qty').val(data.po.PO_qty);
                        // $('#packinglist_amount').val(data.pl.packinglist_amount);
                        // $('#packinglist_po_id').attr('disabled', true);

                        var html = '';
                        var i;
                        for (i = 0; i < data.posize.length; i++) {
                            html += '<tr>' +
                                '<td width="10%" class="text-center align-middle">' +
                                    '<select id="packinglistsize_size_id" name="packinglistsize_size_id[]" class="form-control">' +
                                        '<option value="' + data.posize[i].size_id + '">' + data.posize[i].size + '</option>' +
                                    '</select>' +
                                '</td>' +
                                '<td width="10%" class="text-center align-middle">' +
                                    '<select id="packinglistsize_style_id" name="packinglistsize_style_id[]" class="form-control">' +
                                        '<option value="' + data.postyle[i].style_id + '">' + data.postyle[i].style_description + '</option>' +
                                    '</select>' +
                                '</td>' +
                                '<td width="10%" class="text-center align-middle">' +
                                    '<input type="text" name="packinglistsize_qty[]" placeholder="Qty" class="form-control name_list" />' +
                                '</td>' +
                                '<td width="10%" class="text-center align-middle">' +
                                    '<input type="text" name="packinglistsize_carton[]" placeholder="Carton" class="form-control name_list" />' +
                                '</td>' +
                                '<td width="10%" class="text-center align-middle">' +
                                    '<input type="text" name="packinglistsize_amount[]" placeholder="Amount" class="form-control name_list" />' + 
                                '</td>' +
                                '</tr>';
                        }
                        $('#dynamic_field').html(html);
                    }
                });
            } else {
                $('#packinglist_qty').val('');
                $('#packinglist_amount').val('');
            }
        });
    });

    function addSize() {
        var html = '<tr>' +
            '<td width="10%" class="text-center align-middle">' +
                '<select id="packinglistsize_size_id" name="packinglistsize_size_id[]" class="form-control">' +
                    '<option value="">Select Size</option>' +
                    '<?php foreach ($size as $s) : ?>' +
                        '<option value="<?= $s->id; ?>"><?= $s->size; ?></option>' +
                    '<?php endforeach; ?>' +
                '</select>' +
            '</td>' +
            '<td width="10%" class="text-center align-middle">' +
                '<select id="packinglistsize_style_id" name="packinglistsize_style_id[]" class="form-control">' +
                    '<option value="">Select Style</option>' +
                    '<?php foreach ($style as $s) : ?>' +
                        '<option value="<?= $s->id; ?>"><?= $s->style_description; ?></option>' +
                    '<?php endforeach; ?>' +
                '</select>' +
            '</td>' +
            '<td width="10%" class="text-center align-middle">' +
                '<input type="text" name="packinglistsize_qty[]" placeholder="Qty" class="form-control name_list" />' +
            '</td>' +
            '<td width="10%" class="text-center align-middle">' +
                '<input type="text" name="packinglistsize_carton[]" placeholder="Carton" class="form-control name_list" />' +
            '</td>' +
            '<td width="10%" class="text-center align-middle">' +
                '<input type="text" name="packinglistsize_amount[]" placeholder="Amount" class="form-control name_list" />' +
            '</td>' +
            '</tr>';
        $('#dynamic_field').append(html);
    }

    function sum() {
        var txtFirstNumberValue = document.getElementById('packinglist_qty').value;
        var txtSecondNumberValue = document.getElementById('packinglist_amount').value;
        var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
        if (!isNaN(result)) {
            document.getElementById('packinglist_amount').value = result;
        }
    }
    
    
    function calculate() {
        var qty = document.getElementsByName('packinglistsize_qty[]');
        var carton = document.getElementsByName('packinglistsize_carton[]');
        var amount = document.getElementsByName('packinglistsize_amount[]');
        var i = 0;
        for (i = 0; i < qty.length; i++) {
            var result = parseInt(qty[i].value) * parseInt(carton[i].value) * parseInt(amount[i].value);
            if (!isNaN(result)) {
                amount[i].value = result;
            }
        }
    }

    $(document).ready(function() {
        $('#packinglist_po_id').change(function() {
            var packinglist_po_id = $(this).val();
            $.ajax({
                url: "<?php echo site_url('packinglist/get_style_by_po/') ?>" + packinglist_po_id,
                method: "GET",
                data: {
                    packinglist_po_id: packinglist_po_id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    console.log("data style", data);
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].style_id + '>' + data[i].style_description + '</option>';
                    }
                    $('#packinglist_style_id').html(html);
                }
            });
            return false;
        });
    });
</script>

</section>
</div>
<?= $this->endSection(); ?>