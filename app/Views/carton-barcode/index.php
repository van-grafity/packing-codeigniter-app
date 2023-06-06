<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary mt-2">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('cartonbarcode/import_excel')?>" method="post" id="packinglist_form" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file_excel" name="file_excel">
                                        <label class="custom-file-label" for="file_excel">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success btn-sm" id="btn_submit_form">Upload Bercode</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
</div>

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script>
$(function () {
    bsCustomFileInput.init();
});
</script>
<?= $this->endSection('page_script'); ?>