<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addModal">Add New</button>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle">PL No.</th>
                            <th class="text-center align-middle">PO No.</th>
                            <th class="text-center align-middle">Buyer</th>
                            <th class="text-center align-middle">GL No.</th>
                            <th class="text-center align-middle">Season</th>
                            <th class="text-center align-middle">Size Order</th>
                            <th class="text-center align-middle">Action</th>
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
                                <td class="text-center align-middle">
                                    <a class="btn btn-success btn-sm btn-detail">Details</a>
                                    <a class="btn btn-warning btn-sm btn-edit">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
</div>

<!-- public function store() {
        // dd($this->request->getVar());
        if (!$this->validate([
            'packinglist_no' => [
                'rules' => 'required|is_unique[tblpackinglist.packinglist_no]',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.',
                    'is_unique' => '{field} packinglist sudah terdaftar.'
                ]
            ],
            'packinglist_po_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_cutting_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_ship_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to('/packinglist')->withInput();
        }

        $this->pl->save([
            'packinglist_no' => $this->request->getVar('packinglist_no'),
            'packinglist_po_id' => $this->request->getVar('packinglist_po_id'),
            'packinglist_date' => $this->request->getVar('packinglist_date'),
            'packinglist_qty' => $this->request->getVar('packinglist_qty'),
            'packinglist_cutting_qty' => $this->request->getVar('packinglist_cutting_qty'),
            'packinglist_ship_qty' => $this->request->getVar('packinglist_ship_qty'),
            'packinglist_amount' => $this->request->getVar('packinglist_amount')
        ]);

        $packinglist_id = $this->pl->select('tblpackinglist.id')
            ->where('tblpackinglist.packinglist_no', $this->request->getVar('packinglist_no'))
            ->first()['id'];

        $packinglistsize_size_id = $this->request->getVar('packinglistsize_size_id');
        $packinglistsize_qty = $this->request->getVar('packinglistsize_qty');
        $packinglistsize_amount = $this->request->getVar('packinglistsize_amount');

        for ($i = 0; $i < count($packinglistsize_size_id); $i++) {
            $this->plsize->save([
                'packinglistsize_pl_id' => $packinglist_id,
                'packinglistsize_size_id' => $packinglistsize_size_id[$i],
                'packinglistsize_qty' => $packinglistsize_qty[$i],
                'packinglistsize_amount' => $packinglistsize_amount[$i]
            ]);
        }

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/packinglist');
    } -->

<form action="<?= base_url('index.php/packinglist/store'); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Packing List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List No :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_no" name="packinglist_no" autofocus placeholder="Packing List No" value="<?= $packinglist_no; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="packinglist_po_id" class="col-sm-3 col-form-label">PO No :</label>
                        <select id="packinglist_po_id" name="packinglist_po_id" class="form-control">
                            <option value="">-Select-</option>
                            <?php foreach ($po as $p) : ?>
                                <option value="<?= $p->id; ?>"><?= $p->PO_No; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Date :</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="packinglist_date" name="packinglist_date" autofocus placeholder="Packing List Date" value="<?= date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_qty" name="packinglist_qty" autofocus placeholder="Packing List Qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Cutting Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_cutting_qty" name="packinglist_cutting_qty" autofocus placeholder="Packing List Cutting Qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Ship Qty :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_ship_qty" name="packinglist_ship_qty" autofocus placeholder="Packing List Ship Qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Packing List Amount :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="packinglist_amount" name="packinglist_amount" autofocus placeholder="Packing List Amount">
                        </div>
                    </div>

                    <!-- onChange size by purchaseordersize to packinglistsize -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Size :</label>
                        <div class="col-sm-9">
                            <table class="table table-bordered" id="dynamic_field">
                                <tr>
                                    <td>
                                        <input type="text" name="size[]" placeholder="Size" class="form-control name_list" />
                                    </td>
                                    <td>
                                        <input type="text" name="packinglistsize_qty[]" placeholder="Qty" class="form-control name_list" />
                                    </td>
                                    <td>
                                        <input type="text" name="packinglistsize_amount[]" placeholder="Amount" class="form-control name_list" />
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url('index.php/packinglist'); ?>" class="btn btn-secondary">Close</a>
                    <button type="submit" class="btn btn-primary">Add Packing List</button>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    td {
        cursor: pointer;
    }
</style>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    // onChange size by purchaseordersize to packinglistsize
    // select2 onchange item table by 
    // get_size by packinglist_po_id
    
    $(document).ready(function() {
        $('#packinglist_po_id').change(function() {
            var po_id = $(this).val();
            console.log(po_id);
            if (po_id != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/packinglist/get_size_by_po/" + po_id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<tr>' +
                                '<td>' +
                                '<input type="text" name="size[]" placeholder="Size" class="form-control name_list" value="' + data[i].size + '" />' +
                                '</td>' +
                                '<td>' +
                                '<input type="text" name="packinglistsize_qty[]" placeholder="Qty" class="form-control name_list" />' +
                                '</td>' +
                                '<td>' +
                                '<input type="text" name="packinglistsize_amount[]" placeholder="Amount" class="form-control name_list" />' +
                                '</td>' +
                                '<td></td>' +
                                '</tr>';
                        }
                        $('#dynamic_field').html(html);
                    }
                });
            } else {
                $('#dynamic_field').html('');
            }
        });
    });
</script>


</section>
</div>
<?= $this->endSection(); ?>