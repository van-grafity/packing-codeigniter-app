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
                                        <th>Factory</th>
                                        <th>Ship Date</th>
                                        <th>Unit Price</th>
                                        <th>PO Qty</th>
                                        <th>PO Amount</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($buyerPO as $po) : ?>
                                        <tr>
                                            <td><?= esc($po['PO_No']); ?></td>
                                            <td><?= esc($po['gl_number']); ?></td>
                                            <td><?= esc($po['factory_name']); ?></td>
                                            <td><?= esc($po['shipdate']); ?></td>
                                            <td><?= esc($po['unit_price']); ?></td>
                                            <td><?= esc($po['PO_qty']); ?></td>
                                            <td><?= esc($po['PO_amount']); ?></td>
                                            <td><?= esc($po['created_at']); ?></td>
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