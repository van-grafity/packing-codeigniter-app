<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <a data-toggle="modal" data-target="#createModal" class="btn btn-secondary mb-2" href="#"><i class="fas fa-plus"></i> Add New</a>
                <a href="<?= base_url('index.php/purchaseorder/import'); ?>" class="btn btn-success mb-3"><i class="fas fa-file-import"></i> Import</a>
                <a href="<?= base_url('index.php/purchaseorder/export'); ?>" class="btn btn-warning mb-3"><i class="fas fa-file-export"></i> Export</a>
                <a href="<?= base_url('index.php/purchaseorder/print'); ?>" class="btn btn-info mb-3"><i class="fas fa-print"></i> Print</a>
                
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>PO No.</th>
                            <th>GL No.</th>
                            <th>Factory</th>
                            <th>Ship Date</th>
                            <th>Unit Price</th>
                            <th>PO Qty</th>
                            <th>PO Amount</th>
                            <th>Created At</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($buyerPO as $po) : ?>
                            <tr>
                            <td><a href="<?= base_url('index.php/purchaseorder/' . $po->PO_No); ?>"><?= esc($po->PO_No); ?></a></td>
                                <td><?= esc($po->gl_number); ?></td>
                                <td><?= esc($po->factory_name); ?></td>
                                <td><?= esc($po->shipdate); ?></td>
                                <td><?= esc($po->unit_price); ?></td>
                                <td><?= esc($po->PO_qty); ?></td>
                                <td><?= esc(number_to_currency($po->PO_amount, 'IDR')); ?></td>
                                <td><?= esc($po->created_at); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<form action="<?= base_url('index.php/purchaseorder/store'); ?>" method="post">
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Purchase Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="PO_No">PO No.</label>
                        <input type="text" class="form-control" id="PO_No" name="PO_No" placeholder="PO No.">
                    </div>

                    <div class="form-group">
                        <label for="id">GL No.</label>
                        <select class="form-control" id="id" name="id">
                            <option value="">-- Select GL No. --</option>
                            <?php foreach ($gl as $g) : ?>
                                <option value="<?= $g['id']; ?>"><?= $g['gl_number']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="id">Factory</label>
                        <select class="form-control" id="factory_id" name="factory_id">
                            <option value="">-- Select Factory --</option>
                            <?php foreach ($factory as $f) : ?>
                                <option value="<?= $f['id']; ?>"><?= $f['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="shipdate">Ship Date</label>
                        <input type="date" class="form-control" id="shipdate" name="shipdate" placeholder="Ship Date">
                    </div>

                    <div class="form-group">
                        <label for="unit_price">Unit Price</label>
                        <input type="text" class="form-control" id="unit_price" name="unit_price" placeholder="Unit Price">
                    </div>

                    
                    <div class="form-group">
                        <label for="PO_qty">PO Qty</label>
                        <input type="text" class="form-control" id="PO_qty" name="PO_qty" placeholder="PO Qty">
                    </div>

                    <div class="form-group">
                        <label for="PO_amount">PO Amount</label>
                        <input type="text" class="form-control" id="PO_amount" name="PO_amount" placeholder="0" readonly>
                    </div>
                    <div class="form-group">
                    
                        <table class="table table-bordered" id="item_table">
                            <thead>
                                <tr>
                                    <th>Style No.</th>
                                    <th>Size</th>
                                    <th>Qty</th>
                                    <th colspan="2" width="15%">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control" id="style_no[]" name="style_no[]">
                                            <option value="">-- Select Style No. --</option>
                                            <?php foreach ($style as $s) : ?>
                                                <option value="<?= $s->id; ?>"><?= $s->style_description; ?></option>
                                            <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <select class="form-control" id="size_id[]" name="size_id[]">
                                            <option value="">-- Select Size --</option>
                                            <?php foreach ($size as $s) : ?>
                                                <option value="<?= $s->id; ?>"><?= $s->size; ?></option>
                                            <?php endforeach; ?>
                                    </td>
                                    <td><input type="text" class="form-control" id="qty[]" name="qty[]" placeholder="Qty"></td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus" href="javascript:void(0);" onclick="removeRowSize(this);" id="btnRemoveRowSize"></i></button>
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-success btn-sm"><i class="fas fa-plus" href="javascript:void(0);" onclick="addRowStyleSize();" id="btnAddRowSize"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Purchase Order</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    function addRowStyleSize() {
        var html = '<tr>';
        html += '<td><select class="form-control" id="style_no[]" name="style_no[]"><option value="">-- Select Style No. --</option><?php foreach ($style as $s) : ?><option value="<?= $s->id; ?>"><?= $s->style_description; ?></option><?php endforeach; ?></td>';
        html += '<td><select class="form-control" id="size_id[]" name="size_id[]"><option value="">-- Select Size --</option><?php foreach ($size as $s) : ?><option value="<?= $s->id; ?>"><?= $s->size; ?></option><?php endforeach; ?></td>';
        html += '<td><input type="text" class="form-control" id="qty[]" name="qty[]" placeholder="Qty"></td>';
        html += '<td style="text-align: center;"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus" href="javascript:void(0);" onclick="removeRowStyleSize(this);" id="btnRemoveRowStyleSize"></i></button></td>';
        html += '<td style="text-align: center;"><button type="button" class="btn btn-success btn-sm"><i class="fas fa-plus" href="javascript:void(0);" onclick="addRowStyleSize();" id="btnAddRowStyleSize"></i></button></td>';
        html += '</tr>';
        $('#item_table').append(html);
    }

    function removeRowStyleSize(removeRowStyleSize) {
        $(removeRowStyleSize).closest('tr').remove();
    }

    $(document).ready(function() {
        $('#unit_price, #PO_qty').keyup(function() {
            var unit_price = $('#unit_price').val();
            var PO_qty = $('#PO_qty').val();
            var result = parseFloat(unit_price) * parseFloat(PO_qty);
            if (!isNaN(result)) {
                $('#PO_amount').val(result);
            }
        });
    });

    function calculate() {
        var myBox1 = document.getElementById('unit_price').value;
        var myBox2 = document.getElementById('PO_qty').value;
        var result = document.getElementById('PO_amount');
        var myResult = myBox1 * myBox2;
        result.value = myResult;
    }

    $(document).ready(function() {
        $('#unit_price').change(function() {
            calculate();
        });
        $('#PO_qty').change(function() {
            calculate();
        });
    });

    function addRowStyle() {
        var html = '<tr>';
        html += '<td><select class="form-control" id="style_no[]" name="style_no[]"><option value="">-- Select Style No. --</option><?php foreach ($purchaseorderstyle as $s) : ?><option value="<?= $s['id']; ?>"><?= $s['style_description']; ?></option><?php endforeach; ?></select></td>';
        html += '<td><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus" href="javascript:void(0);" onclick="removeRowStyle(this);"></i></button></td>';
        html += '<th><button type="button" class="btn btn-success btn-sm" onclick="addRowStyle();"><i class="fas fa-plus"></i></button></th>';
        html += '</tr>';
        $('#style_table tbody').append(html);
    }

    function removeRowStyle(e) {
        try {
            var row = $(e).closest('tr');
            row.remove();
        } catch (e) {
            alert(e);
        }
    }
</script>
<?= $this->endSection(); ?>