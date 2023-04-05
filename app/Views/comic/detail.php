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

    <div class="container">
        <div class="row">
            <div class="col">
                <hr2 class="mt-2">Comic Details</hr2>
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="../images/<?= $comic['sampul']; ?>" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $comic['judul']; ?></h5>
                                <p class="card-text"><b>Penulis :</b> <?= $comic['penulis']; ?></p>
                                <p class="card-text"><small class="text-muted"><b>Penerbit :<?= $comic['penerbit']; ?></b></small></p>

                                <a href="../index.php/comic/edit/<?= $comic['slug']; ?>" class="btn btn-warning">Edit</a>

                                <!-- Fungsi DELETE menggunakan BUTTON -->
                                <form action="../index.php/comic/<?= $comic['id']; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">Delete</button>
                                </form>
                                <br><br>
                                <a href="../index.php/comic ">Kembali ke daftar komik</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>