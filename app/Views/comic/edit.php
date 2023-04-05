<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <!-- Container-fluid -->
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content header -->
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h2 class="my-3">Edit Existing Comic</h2>

                <!-- Form untuk mengisi data baru -->
                <form action="../index.php/comic/update/<?= $comic['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="slug" value="<?= $comic['slug']; ?>">
                    <div class="form-group row">
                        <label for="judul" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= (validation_show_error('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value=<?= $comic['judul']; ?>>
                            <div class="invalid-feedback">
                                <?= validation_show_error('judul'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penulis" class="col-sm-2 col-form-label">Writer</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penulis" name="penulis" value=<?= $comic['penulis']; ?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penerbit" class="col-sm-2 col-form-label">Publisher</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penerbit" name="penerbit" value=<?= $comic['penerbit']; ?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sampul" class="col-sm-2 col-form-label">Cover</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sampul" name="sampul" value=<?= $comic['sampul']; ?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>