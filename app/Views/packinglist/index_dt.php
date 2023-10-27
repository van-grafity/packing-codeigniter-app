<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-success mb-2" id="btn_modal_create" onclick="create_packinglist()" >Create Packing List</button>
                <table id="packinglist_table" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="table-primary text-center">
                            <th width="5%">No</th>
                            <th width="15%">PL No.</th>
                            <th width="20%">Buyer</th>
                            <th width="20%">PO No.</th>
                            <th width="15%">GL No.</th>
                            <th width="10%">Season</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>


<!-- Modal Add and Edit Packing List -->

<div class="modal fade" id="packinglist_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="packinglist_form">
                <?= csrf_field(); ?>
                <input type="hidden" name="edit_packinglist_id" id="edit_packinglist_id">
                <div class="modal-header">
                    <h5 class="modal-title">Create Packing List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="po_no">PO No :</label>
                        <select id="po_no" name="po_no" class="form-control select2" required>
                            <option value="">Select PO No </option>
                            <?php foreach ($po_list as $key => $po) { ?>
                                <option value="<?= esc($po->id) ?>"
                                    data-gl-number="<?= esc($po->gl_number) ?>"    
                                    data-buyer-name="<?= esc($po->buyer_name) ?>"    
                                    data-po-qty="<?= esc($po->po_qty) ?>"    
                                    data-shipdate="<?= esc($po->shipdate) ?>"    
                                ><?= esc($po->po_no) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="buyer_name">Buyer Name :</label>
                                <input type="text" readonly class="form-control" id="buyer_name" name="buyer_name" placeholder="Buyer Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_no">Order No :</label>
                                <input type="text" readonly class="form-control" id="order_no" name="order_no" placeholder="Order No">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_qty">Order Qty :</label>
                                <input type="text" readonly class="form-control" id="order_qty" name="order_qty" placeholder="Order Qty">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="shipdate">Ship Date :</label>
                                <input type="text" readonly class="form-control" id="shipdate" name="shipdate" placeholder="Ship Date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="packinglist_date">Packing List Date :</label>
                                <input type="date" class="form-control" id="packinglist_date" name="packinglist_date" placeholder="Packing List Date" value="<?= date('Y-m-d'); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="destination">Destionation :</label>
                                <input type="text" class="form-control" id="destination" name="destination" placeholder="Destionation">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="department">Department :</label>
                                <input type="text" class="form-control" id="department" name="department" placeholder="Department">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-submit">Create Packing List</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit Packing List -->


<!-- Modal Delete Packing List -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('packinglist/delete')?>" method="post">
                <input type="hidden" name="packinglist_id" id="packinglist_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Packing List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Packing List ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete Packing List -->

<?= $this->endSection(); ?>



<?= $this->Section('page_script'); ?>

<script type="text/javascript">
    const store_url = "<?= base_url('packinglist/store')?>";
    const update_url = "<?= base_url('packinglist/update')?>";
    const edit_url = '<?= url_to('packinglist_edit')?>';
    const index_dt_url = '<?= url_to('packinglist_list')?>';

    const create_packinglist = () => {
        clear_form({
            modal_id: 'packinglist_modal',
            modal_title: "Create Packing List",
            modal_btn_submit: "Create",
            form_action_url: store_url,
        });

        let date_today = new Date().toJSON().slice(0, 10);
        $('#packinglist_date').val(date_today);
        $('#packinglist_modal').modal('show');
    }

    const edit_packinglist = async (packinglist_id) => {

        params_data = {
            id: packinglist_id
        };
        result = await using_fetch(edit_url, params_data, "GET");
        let packinglist = result.data.packinglist;

        clear_form({
            modal_id: 'packinglist_modal',
            modal_title: "Edit Packing List",
            modal_btn_submit: "Save",
            form_action_url: update_url,
        });

        $('#edit_packinglist_id').val(packinglist.id);
        $('#po_no').val(packinglist.po_id).trigger('change');
        $('#destination').val(packinglist.destination);
        $('#department').val(packinglist.department);
        
        $('#packinglist_modal').modal('show');
    }


    const delete_pl = (element) => {
        let id = $(element).data('id');
        let serial_number = $(element).data('pl-serial-number');
        $('#packinglist_id').val(id);
        if (id) {
            $('#delete_message').text(`Are you sure want to delete Packing List (${serial_number})?`);
        }
        $('#deleteModal').modal('show');
    }
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#po_no.select2').select2({
            dropdownParent: $('#packinglist_modal')
        });
        $('#po_no.select2').on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
        });

        $('#packinglist_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: index_dt_url,
            order: [],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'packinglist_serial_number', name: 'pl.packinglist_serial_number'},
                { data: 'buyer_name', name: 'sync_po.buyer_name' },
                { data: 'po_no', name: 'po.po_no' },
                { data: 'gl_number', name: 'sync_po.gl_number' },
                { data: 'season', name: 'sync_po.season' },
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
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        // ## Show Flash Message
        let session = <?= json_encode(session()->getFlashdata()) ?>;
        show_flash_message(session);
        
        $('#po_no').on('change', function(event) {
            let buyer_name = $(this).find($('option:selected')).data('buyer-name');
            let order_no = $(this).find($('option:selected')).data('gl-number');
            let order_qty = $(this).find($('option:selected')).data('po-qty');
            let shipdate = $(this).find($('option:selected')).data('shipdate');

            if ($(this).val()) {
                $('#buyer_name').val(buyer_name);
                $('#order_no').val(order_no);
                $('#order_qty').val(order_qty);
                $('#shipdate').val(shipdate);
            } else {
                $('#order_qty').val();
            }
        })
    })
</script>


<?= $this->endSection('page_script'); ?>