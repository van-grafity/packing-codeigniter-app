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
                <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addModal">Add New</button>

                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle">PO No.</th>
                            <th class="text-center align-middle">GL No.</th>
                            <th class="text-center align-middle">Ship Date</th>
                            <th class="text-center align-middle">Total Qty</th>
                            <th class="text-center align-middle">Total Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($buyerPO as $po) : ?>
                            <tr>
                                <td class="text-center align-middle"><a href="<?= '../index.php/purchaseorder/' . $po['PO_No']; ?>"><?= esc($po['PO_No']); ?></a></td>
                                <td class="text-center align-middle"><?= $po['gl_number']; ?></td>
                                <td class="text-center align-middle"><?= $po['shipdate']; ?></td>
                                <td class="text-center align-middle"><?= $po['PO_qty']; ?></td>
                                <td class="text-right align-middle"><?= number_to_currency($po['PO_amount'], 'USD', 'en_US', 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>
</div>
</div>
</section>
</div>

<form action="<?= '../index.php/purchaseorder/store'; ?>" method="post">
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
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
                        <label for="shipdate">Ship Date</label>
                        <input type="date" class="form-control" id="shipdate" name="shipdate" placeholder="Ship Date">
                    </div>
                    <div class="form-group">
                        <label for="PO_qty">Total Qty</label>
                        <input type="text" class="form-control" id="PO_qty" name="PO_qty" placeholder="Total Qty" disabled>
                    </div>
                    <div class="form-group">
                        <label for="PO_amount">PO Amount</label>
                        <input type="text" class="form-control" id="PO_amount" name="PO_amount" placeholder="Total Amount" disabled>
                    </div>

                    <div class="form-group">

                        <table class="table table-bordered" id="item_table">
                            <thead>
                                <tr>
                                    <th>Style</th>
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
                                            <?php foreach ($purchaseorderstyle as $s) : ?>
                                                <option value="<?= $s['id']; ?>"><?= $s['style_description']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" id="size_id[]" name="size_id[]">
                                            <option value="">-- Select Size --</option>
                                            <?php foreach ($size as $s) : ?>
                                                <option value="<?= $s['id']; ?>"><?= $s['size']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" id="qty[]" name="qty[]" placeholder="Qty"></td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus" href="javascript:void(0);" onclick="removeRowSize(this);" id="btnRemoveRowSize"></i></button>
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-success btn-sm"><i class="fas fa-plus" href="javascript:void(0);" onclick="addRowSize();" id="btnAddRowSize"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" aria-label="Close" class=>Close</button>
                    <button type="submit" class="btn btn-primary">Add Purchase Order</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function addRowSize() {
        var html = '<tr>';
        html += '<td><select class="form-control" id="size_id[]" name="size_id[]"><option value="">-- Select Size --</option><?php foreach ($size as $s) : ?><option value="<?= $s['id']; ?>"><?= $s['size']; ?></option><?php endforeach; ?></select></td>';
        html += '<td><input type="text" class="form-control" id="qty[]" name="qty[]" placeholder="Qty"></td>';
        html += '<td><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-minus" href="javascript:void(0);" onclick="removeRowSize(this);"></i></button></td>';
        html += '<th><button type="button" class="btn btn-success btn-sm" onclick="addRowSize();"><i class="fas fa-plus"></i></button></th>';
        html += '</tr>';
        $('#item_table tbody').append(html);
    }

    function removeRowSize(e) {
        try {
            var row = $(e).closest('tr');
            row.remove();
        } catch (e) {
            alert(e);
        }
    }

    // function addRowSize() {
    //     try {
    //         var table = document.getElementById("item_table");
    //         var rowCount = table.rows.length;
    //         var row = table.insertRow(rowCount);

    //         var cell1 = row.insertCell(0);
    //         cell1.innerHTML = "<select class='form-control' id='size' name='size'><option value=''>-- Select Size --</option><?php foreach ($size as $s) : ?><option value='<?= $s['id']; ?>'><?= $s['size']; ?></option><?php endforeach; ?></select>";

    //         var cell2 = row.insertCell(1);
    //         cell2.innerHTML = "<input type='text' class='form-control' id='qty' name='qty' placeholder='Qty'>";

    //         var cell3 = row.insertCell(2);
    //         cell3.innerHTML = "<button type='button' class='btn btn-success btn-sm' onclick='addRowSize();'><i class='fas fa-plus'></i></button>";

    //         var cell4 = row.insertCell(3);
    //         cell4.innerHTML = "<button type='button' class='btn btn-danger btn-sm'><i class='fas fa-minus' href='javascript:void(0);' onclick='removeRowSize(this);'></i></button>";
    //     } catch (e) {
    //         alert(e);
    //     }
    // }

    // function removeRowSize(oButton) {
    //     try {
    //         var table = document.getElementById("item_table");
    //         table.deleteRow(oButton.parentNode.parentNode.rowIndex);
    //     } catch (e) {
    //         alert(e);
    //     }
    // }

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