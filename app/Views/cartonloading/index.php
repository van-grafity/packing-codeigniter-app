<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
    
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-8 col-md-10 dt-custom-filter">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 label">
                                            <div>GL</div>
                                        </div>
                                        <div class="col-md-9 col-sm-6">
                                            <select name="filter_gl_number" id="filter_gl_number" class="form-control select2" >
                                                <option value=""> All GL Number </option>
                                                <?php foreach ($gls as $gl) : ?>
                                                    <option value="<?= $gl['gl_number']; ?>"> <?= $gl['gl_number']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="carton_list_table" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr class="table-primary">
                            <th width="30px">No</th>
                            <th width="">Barcode</th>
                            <th width="100px">Buyer</th>
                            <th width="">PO</th>
                            <th width="100px">GL Number</th>
                            <th width="">Content</th>
                            <th width="">Total PCS</th>
                            <th width="200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>


<!-- Modal Detail Carton -->
<div class="modal fade" id="detail_carton_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">Detail Carton</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table" id="detail_carton_table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>UPC</th>
                                        <th>Name</th>
                                        <th>Colour</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Detail Carton -->


<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
    const index_dt_url = '<?= base_url('carton-loading/list')?>';
    const detail_carton_url = '<?= base_url('cartonbarcode/detailcarton')?>';

    const detail_carton = async (carton_id) => {
        $('#detail_carton_table tbody').html('');
        let total = 0;
        
        params_data = { id : carton_id };
        result = await using_fetch(detail_carton_url, params_data, "GET");
        result.data.forEach((data, key) => {
            let row = `
                <tr>
                    <td>${key+1}</td>
                    <td>${data.product_code}</td>
                    <td>${data.product_name}</td>
                    <td>${data.product_colour}</td>
                    <td>${data.product_size}</td>
                    <td>${data.product_qty}</td>
                </tr>
            `;
            $('#detail_carton_table tbody').append(row);
            
            total += parseInt(data.product_qty);
        });
        let row_footer = `
            <tr>
                <td colspan="5" class="text-right">Total PCS :</td>
                <td colspan="1">${total}</td>
            </tr>
        `;
        $('#detail_carton_table tfoot').html(row_footer);

        $('#detail_carton_modal').modal('show');
    }   

</script>
<script>
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);
    
    let carton_list_table = $('#carton_list_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: index_dt_url,
            data: function (d) {
                d.filter_gl_number = $('#filter_gl_number').val();
            }
        },
        order: [],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'barcode', name: 'tblcartonbarcode.barcode'},
            { data: 'buyer_name', name: 'sync_po.buyer_name'},
            { data: 'po_number', name: 'po.po_no'},
            { data: 'gl_number', name: 'sync_po.gl_number'},
            { data: 'content', name: 'content', orderable: false, searchable: false },
            { data: 'total_pcs', name: 'total_pcs', orderable: false, searchable: false },
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
        dom: "<'row'<'col-md-2'l><'col-md-6'B><'col-md-4'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>",
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            },
        ]
    });

    $('#filter_gl_number').change(function(event) {
        carton_list_table.ajax.reload();
    });

    $('#filter_gl_number').select2();

    $('select.select2').on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

})
</script>

<?= $this->endSection('page_script'); ?>