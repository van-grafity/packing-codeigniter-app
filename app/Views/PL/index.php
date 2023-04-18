<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
    </section>

     <section class="content">
        <div class="container-fluid">
            <h1 class="mt-4"><i class="fas fa-server"></i>FactoryPacking List</h1>
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
                                        <th>PL No.</th>
                                        <th>PO No.</th>
                                        <th>Buyer</th>
                                        <th>GL No.</th>
                                        <th>Season</th>
                                        <th>Size Order</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($pl as $pl) : ?>
                                        <tr>
                                            <td><a href="<?= base_url('index.php/packinglist/' . $pl['packinglist_no']); ?>"><?= esc($pl['packinglist_no']); ?></a></td>
                                            <td onClick="window.location.href='<?= base_url('index.php/home'); ?>'"><?= esc($pl['PO_No']); ?></td>
                                            <td><?= esc($pl['buyer_name']); ?></td>
                                            <td><?= esc($pl['gl_number']); ?></td>
                                            <td><?= esc($pl['season']); ?></td>
                                            <td><?= esc($pl['size_order']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            td {
                cursor: pointer;
            }
    </section>
</div>
<?= $this->endSection(); ?>