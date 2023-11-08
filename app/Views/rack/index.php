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
                    <div class="col-sm-4 col-md-2">
                        <a href="javascript:void(0)" type="button" class="btn btn-success mb-2" id="btn-add-rack" onclick="add_new_rack()">New Rack</a>
                    </div>
                    <div class="col-sm-8 col-md-10 dt-custom-filter">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 label">
                                            <div>Area</div>
                                        </div>
                                        <div class="col-md-9 col-sm-6">
                                            <select name="filter_area" id="filter_area" class="form-control" >
                                                <option value=""> All Area </option>
                                                <?php foreach ($area_options as $area) : ?>
                                                    <option value="<?= $area; ?>">Area <?= $area; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 label">
                                            <div>Level</div>
                                        </div>
                                        <div class="col-md-9 col-sm-6">
                                            <select name="filter_level" id="filter_level" class="form-control" >
                                                <option value="">All Level</option>
                                                <?php foreach ($level_options as $level) : ?>
                                                    <option value="<?= $level; ?>">Level <?= $level; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 label">
                                            <div>Status</div>
                                        </div>
                                        <div class="col-md-9 col-sm-6">
                                            <select name="filter_status" id="filter_status" class="form-control" >
                                                <option value="">All Status</option>
                                                <option value="Y"> Empty </option>
                                                <option value="N"> Not Empty </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="rack_table" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr class="table-primary">
                            <th width="">No</th>
                            <th width="">Serial Number</th>
                            <th width="">Area</th>
                            <th width="">Level</th>
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


<!-- Modal Add and Edit Rack -->
<div class="modal fade" id="modal_rack" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="rack_form">
                <input type="hidden" name="edit_rack_id" value="" id="edit_rack_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Rack</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="serial_number" class="col-form-label">Serial Number</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="RCK-A001" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="area" class="col-form-label">Area :</label>
                        <select id="area" name="area" class="form-control select2" required>
                            <option value=""> Select Area </option>
                            <?php foreach ($area_options as $area) : ?>
                                <option value="<?= $area; ?>">Area <?= $area; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="level" class="col-form-label">Level :</label>
                        <select id="level" name="level" class="form-control select2" required>
                            <option value=""> Select Level </option>
                            <?php foreach ($level_options as $level) : ?>
                                <option value="<?= $level; ?>">Level <?= $level; ?></option>
                            <?php endforeach; ?>
                        </select>
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
<!-- End Modal Add and Edit Rack -->



<!-- Modal Delete Rack -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('rack/delete')?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Delete Rack</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="delete_message">Are you sure want to delete this Rack ?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="rack_id" id="rack_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</form>
<!-- End Modal Delete Rack -->

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script type="text/javascript">
    const index_dt_url = '<?= base_url('rack/list')?>';
    const save_url = '<?= base_url('rack/save')?>';
    const detail_url = '<?= base_url('rack/detail')?>';
    const update_url = '<?= base_url('rack/update')?>';


    const add_new_rack = () => {
        $('#rack_form').attr('action',save_url);
        $('#rack_form').find("input[type=text], textarea").val("");
        $('#modal_rack').modal('show');
    }

    const edit_rack = async (rack_id) => {
        params_data = { id : rack_id };
        result = await using_fetch(detail_url, params_data, "GET");

        rack_data = result.data
        $('#serial_number').val(rack_data.serial_number);
        $('#area').val(rack_data.area).trigger('change');
        $('#level').val(rack_data.level).trigger('change');
        $('#description').val(rack_data.description);
        $('#location').val(rack_data.location);
        $('#edit_rack_id').val(rack_data.id);
        
        $('#rack_form').attr('action',update_url);
        $('#modal_rack').modal('show');
    }

    const delete_rack = (rack_id) => {
        $('#delete_message').text(`Are you sure want to delete this Rack?`);
        $('#rack_id').val(rack_id);
        $('#delete_modal').modal('show');
    }

</script>
<script>
$(document).ready(function() {

    // ## Show Flash Message
    let session = <?= json_encode(session()->getFlashdata()) ?>;
    show_flash_message(session);
    
    let rack_table = $('#rack_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: index_dt_url,
            data: function (d) {
                d.filter_area = $('#filter_area').val();
                d.filter_level = $('#filter_level').val();
                d.filter_status = $('#filter_status').val();
            }
        },
        order: [],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'serial_number', name: 'rack.serial_number'},
            { data: 'area', name: 'rack.area'},
            { data: 'level', name: 'rack.level'},
            { data: 'description', name: 'rack.description'},
            { data: 'status', name: 'rack.flag_empty', orderable: false, searchable: false },
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

    $('#filter_area, #filter_level, #filter_status').change(function(event) {
        rack_table.ajax.reload();
    });

    $('select.select2').select2({
        dropdownParent: $('#modal_rack')
    });
    $('select.select2').on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

})
</script>

<?= $this->endSection('page_script'); ?>