<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
    </section>

     <section class="content">
        <div class="container-fluid">
            <h1 class="mt-4"><i class="fas fa-server"></i> Purchase Order</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('index.php/home'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>PO No.</th>
                                        <th>GL No.</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($buyerPO as $po) : ?>
                                        <tr>
                                            <td><?= esc($po['PO_No']); ?></td>
                                            <td><?= esc($po['gl_number']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>