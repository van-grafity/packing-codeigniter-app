<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>

    .dt-custom-filter .label {
        font-weight:bold;
        display: flex;
        align-items: center;
        justify-content: flex-end
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
                    <div class="col-sm-6">
                        <a href="javascript:void(0)" type="button" class="btn btn-success mb-2" id="btn-add-pallet" onclick="add_new_pallet()">New Pallet</a>
                    </div>
                    <div class="col-sm-6 dt-custom-filter">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-8 label">
                                    <div>Status</div>
                                </div>
                                <div class="col-sm-4">
                                    <select name="pallet_status" id="pallet_status" class="form-control" required >
                                        <option value="">All Status</option>
                                        <option value="Y"> Empty </option>
                                        <option value="N"> Not Empty </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="pallet_table" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr class="table-primary">
                            <th width="">No</th>
                            <th width="">Serial Number</th>
                            <th width="">Description</th>
                            <th width="">Status</th>
                            <th width="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>


<!-- Modal Add and Edit Product Detail -->
<div class="modal fade" id="modal_pallet" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="pallet_form">
                <input type="hidden" name="edit_pallet_id" value="" id="edit_pallet_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Pallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="serial_number" class="col-form-label">Serial Number</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="PLT-A0001" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit Product Detail -->



<!-- Modal Delete Pallet -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('pallet/delete')?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete Pallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Pallet ?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="pallet_id" id="pallet_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</form>
<!-- End Modal Delete Pallet -->

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
    const index_dt_url = '<?= base_url('pallet/list')?>';
    const save_url = '<?= base_url('pallet/save')?>';
    const detail_url = '<?= base_url('pallet/detail')?>';
    const update_url = '<?= base_url('pallet/update')?>';


    const add_new_pallet = () => {
        $('#pallet_form').attr('action',save_url);
        $('#pallet_form').find("input[type=text], textarea").val("");
        $('#modal_pallet').modal('show');
    }

    const edit_pallet = async (pallet_id) => {
        params_data = { id : pallet_id };
        result = await using_fetch(detail_url, params_data, "GET");

        pallet_data = result.data
        $('#serial_number').val(pallet_data.serial_number);
        $('#description').val(pallet_data.description);
        $('#edit_pallet_id').val(pallet_data.id);
        
        $('#pallet_form').attr('action',update_url);
        $('#modal_pallet').modal('show');
    }

    const delete_pallet = (pallet_id) => {
        $('#delete_message').text(`Are you sure want to delete this Pallet?`);
        $('#pallet_id').val(pallet_id);
        $('#delete_modal').modal('show');
    }

</script>
<script type="text/javascript">
    let pallet_table = $('#pallet_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: index_dt_url,
            data: function (d) {
                d.pallet_status = $('#pallet_status').val();
            }
        },
        order: [],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'serial_number', name: 'pallet.serial_number'},
            { data: 'description', name: 'pallet.description'},
            { data: 'status', name: 'status', orderable: false, searchable: false },
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
    });

    $('#pallet_status').change(function(event) {
        pallet_table.ajax.reload();
    });
</script>
<script>
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);

})
</script>

<?= $this->endSection('page_script'); ?>