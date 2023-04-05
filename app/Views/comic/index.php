<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--Isikan Header di sini bila diinginkan -->
    </section>
    <!-- /.content header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- /.card -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!--  Added "Add Button" -->
                            <a href="../index.php/comic/create" class="btn btn-primary mt-3">Add New Comic</a>
                            <h1 class="mt-2">Comic List</h1>
                            <!--  Untuk menampilkan notifikasi -->
                            <?php if (session()->getFlashdata('pesan')) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= session()->getFlashdata('pesan'); ?>
                                </div>
                            <?php endif; ?>

                            <!--  Table start in here -->
                            <table class="table table-bordered table-striped">
                                <thead class="dt-head-center">
                                    <tr class="table-primary">
                                        <th width="5%" scope="col">#</th>
                                        <th width="30%" scope=" col">Sampul</th>
                                        <th width="45%" scope="col">Judul</th>
                                        <th width="20%" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>

                                    <?php foreach ($comic as $c) :  ?>
                                        <tr>
                                            <th scope="row"> <?= $i++; ?></th>
                                            <td><img src="../images/<?= $c['sampul']; ?>" alt="" class="gambar"></td>
                                            <td><?= $c['judul']; ?></td>
                                            <td><a href="../index.php/comic/<?= $c['slug']; ?>" class="btn btn-success">Detail</a></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection('content'); ?>