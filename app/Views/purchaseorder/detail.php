<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
    </section>
    
     <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h3><?= $title ?></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <br>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h4>PO No.</h4>
                                        </div>
                                    </div>
                                    <h1><?= esc($buyerPO['PO_No']); ?></h1>
                                    <table width="100%">
                                        <tr>
                                            <td><b>Buyer</b></td>
                                            <td><?= esc($buyerPO['buyer_name']); ?></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><b>Order Qty.</b></td>
                                            <td><?= esc($buyerPO['PO_qty']); ?></td>
                                            <td><b>Cut Qty.</b></td>
                                            <td><?= esc($buyerPO['PO_qty']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>PO Amount</b></td>
                                            <td><?= esc($buyerPO['PO_amount']); ?></td>
                                            <td><b>Size Order</b></td>
                                            <td><?= esc($buyerPO['size_order']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Ship Date</b></td>
                                            <td><?= esc($buyerPO['shipdate']); ?></td>
                                            <td><b>GL Number</b></td>
                                            <td><?= esc($buyerPO['gl_number']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Factory</b></td>
                                            <td><?= esc($buyerPO['factory_name']); ?></td>
                                            <td><b>Factory Code</b></td>
                                            <td><?= esc($buyerPO['factory_id']); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="card card-primary card-outline card-tabs">
                                    <div class="card-header p-0 pt-1 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Style</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Size</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-other-tab" data-toggle="pill" href="#custom-tabs-three-other" role="tab" aria-controls="custom-tabs-three-other" aria-selected="false">Other Information</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-three-tabContent">
                                            <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                                <div class="col-lg-6">    
                                                    <div class="card-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Style No.</th>
                                                                    <th scope="col">Style Description</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($purchaseorderstyle as $pos) : ?>
                                                                    <tr>
                                                                        <td><?= $pos['style_no']; ?></td>
                                                                        <td><?= $pos['style_description']; ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                                <div class="col-lg-6">    
                                                    <div class="card-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Size</th>
                                                                    <th scope="col">Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($purchaseordersize as $pos) : ?>
                                                                    <tr>
                                                                        <td><?= $pos['size']; ?></td>
                                                                        <td><?= $pos['quantity']; ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                                <tr>
                                                                    <td><b>Total</b></td>
                                                                    <td><?php echo array_sum(array_column($purchaseordersize, 'quantity')); ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-three-other" role="tabpanel" aria-labelledby="custom-tabs-three-other-tab">
                                            Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12">
                    <a href="<?= base_url('purchaseorder'); ?>" class="btn btn-secondary">Back</a>
                    <a href="<?= base_url('purchaseorder/edit/' . $buyerPO['PO_No']); ?>" class="btn btn-warning float-right">Edit</a>
                </div>
            </div>
        </div>
    </div>


    
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th,
        td {
            text-align: left;
            padding: 8px;
            font-size: 18px;
        }

        .nav-item {
            font-size: 18px;
            font-weight: bold;
        }
        </style>
</div>
<?= $this->endSection(); ?>