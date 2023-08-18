<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<style>
    #carton_barcode {
        max-width: 200px;
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
                    <div class="col-sm-12 col-md-8">
                        <form action="" id="carton_barcode_form">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="carton_barcode" class="col-form-label">Input Carton Barcode :</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="carton_barcode" name="carton_barcode" placeholder="Carton Barcode Here" autofocus>
                                    <div class="ml-2">
                                        <button type="submit" class="btn btn-primary" id="btn_search_carton">Search Carton</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="carton-preview">
                            <h4>Carton Preview</h4>
                        </div>
    
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-4">
                        <form action="" method="post" id="carton_inspection_form">
                            <div class="form-group">
                                <label for="issued_by" class="col-form-label">Issued By</label>
                                <input type="text" class="form-control" id="issued_by" name="issued_by" placeholder="Issued By">
                            </div>
                            <div class="form-group">
                                <label for="received_by" class="col-form-label">Received By :</label>
                                <input type="text" class="form-control" id="received_by" name="received_by" placeholder="Received By">
                            </div>
                            <div class="form-group">
                                <label for="received_date" class="col-form-label">Received Date :</label>
                                <input type="text" class="form-control" id="received_date" name="received_date" disabled>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary" id="btn_submit">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<?= $this->endSection(); ?>


<?= $this->Section('page_script'); ?>
<script>
$(document).ready(function() {


})
</script>
<?= $this->endSection('page_script'); ?>