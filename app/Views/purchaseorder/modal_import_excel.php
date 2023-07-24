<!-- Modal Import Purchase Order -->
<div class="modal fade" id="modal_import_excel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('purchaseorder/importexcel')?>" method="post" id="packinglist_form" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add <?= $title ? $title : '' ?> via Import Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Upload <?= $title ? $title : '' ?> on Excel Format</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file_excel" name="file_excel" required>
                                        <label class="custom-file-label" for="file_excel">Choose Excel file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="btn_submit_form">Upload <?= $title ? $title : '' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Import Purchase Order -->

<?= $this->Section('page_script'); ?>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    })

    const show_import_modal = () => {
        $('#modal_import_excel').modal('show');
    }
</script>
<?= $this->endSection('page_script'); ?>


