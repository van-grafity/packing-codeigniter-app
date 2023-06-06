 <?= $this->extend('app-layout/template'); ?>

 <?= $this->Section('content'); ?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Main content -->
     <section class="content">
         <div class="card card-primary">
             <div class="card-header">
                 <h3 class="card-title"><?= $title ?></h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
                 <button type="button" class="btn btn-secondary mb-2" id="btn-add-detail">Add Factory</button>
                 <table id="table1" class="table table-bordered table-striped">
                     <thead>
                         <tr class="table-primary">
                             <th class="text-center align-middle">SN</th>
                             <th class="text-center align-middle">Factory Name</th>
                             <th class="text-center align-middle">In-Charge</th>
                             <th class="text-center align-middle">Remarks</th>
                             <th class="text-center align-middle">Action</th>
                         </tr>
                     </thead>

                     <tbody>
                         <?php $i = 1; ?>
                         <?php foreach ($factory as $fty) : ?>
                             <tr>
                                 <th class="text-center" scope="row"><?= $i++; ?></th>
                                 <td><?= $fty->name; ?></td>
                                 <td><?= $fty->incharge; ?></td>
                                 <td><?= $fty->remarks; ?></td>
                                 <td>
                                     <a class="btn btn-success btn-sm btn-detail" data-id="<?= $fty->id; ?>" data-factory-name="<?= $fty->name; ?>" data-incharge="<?= $fty->incharge; ?>" data-remarks="<?= $fty->remarks ?>">Details</a>
                                     <a class="btn btn-warning btn-sm btn-edit" data-id="<?= $fty->id; ?>" data-factory-name="<?= $fty->name; ?>" data-incharge="<?= $fty->incharge; ?>" data-remarks="<?= $fty->remarks ?>">Edit</a>
                                     <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $fty->id; ?>" data-factory-name="<?= $fty->name; ?>">Delete</a>
                                 </td>
                             </tr>
                         <?php endforeach; ?>
                     </tbody>
                 </table>
             </div>
             <!-- /.card-body -->
         </div>
         <!-- /.card -->
     </section>
     <!-- /.section -->
 </div>

 <!-- Modal Add and Edit Factory Detail -->
 <div class="modal fade" id="modal_factory_detail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <form action="" method="post" id="factory_form">
                 <input type="hidden" name="edit_factory_id" value="" id="edit_factory_id">

                 <div class="modal-header">
                     <h5 class="modal-title" id="ModalLabel">Add New Factory</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Factory Name</label>
                         <input type="text" class="form-control" id="factory_name" name="name" placeholder="Factory Name" autofocus>
                     </div>
                     <div class="form-group">
                         <label>Factory In-charge</label>
                         <input type="text" class="form-control" id="factory_incharge" name="incharge" placeholder="Factory In-charge">
                     </div>
                     <div class="form-group">
                         <label>Remarks</label>
                         <input type="text" class="form-control" id="factory_remarks" name="remarks" placeholder="Remarks">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary" id="btn_submit">Save</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <!-- End Modal Add and Edit Factory Detail -->

 <!-- Modal Delete Factory-->
 <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <form action="../index.php/factory/delete" method="post">
                 <div class="modal-header">
                     <h5 class="modal-title" id="ModalLabel">Delete Factory</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <h4 id="delete_message">Are you sure want to delete this factory data ?</h4>
                 </div>
                 <div class="modal-footer">
                     <input type="hidden" name="factory_id" id="factory_id">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                     <button type="submit" class="btn btn-primary">Yes</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <!-- End Modal Delete Factory-->

 <script>
     $(document).ready(function() {
         // ## prevent submit form when keyboard press enter
         $('#factory_form input').on('keyup keypress', function(e) {
             var keyCode = e.keyCode || e.which;
             if (keyCode === 13) {
                 e.preventDefault();
                 return false;
             }
         });

         $('#btn-add-detail').on('click', function(event) {
             $('#ModalLabel').text("Add New Factory")
             $('#factory_form').attr('action', store_url);
             $('#btn_submit').attr('hidden', false);
             $('#factory_form').find("input[type=text], input[type=number], textarea").val("");
             $('#factory_form').find('select').val("").trigger('change');

             $('#modal_factory_detail').modal('show');
         })

         // get Delete Product Type
         $('.btn-delete').on('click', function() {
             // get data from button delete
             let id = $(this).data('id');
             let factory_name = $(this).data('factory-name');

             // Set data to Form Delete
             $('#factory_id').val(id);
             if (factory_name) {
                 $('#delete_message').text(`Are you sure want to delete this Factory (${factory_name}) from this database ?`);
             }

             // Call Modal Delete
             $('#deleteModal').modal('show');
         })

         $('.btn-edit').on('click', function(event) {
             // get data from button edit
             let id = $(this).data('id');
             let name = $(this).data('factory-name');
             let incharge = $(this).data('incharge');
             let remarks = $(this).data('remarks');

             $('#ModalLabel').text("Edit Factory")
             $('#btn_submit').text("Update Factory")
             $('#btn_submit').attr('hidden', false);
             $('#factory_form').attr('action', update_url);

             // Set ReadOnly the textboxes
             $('#edit_factory_id').attr("readonly", false);
             $('#factory_name').attr("readonly", false);
             $('#factory_incharge').attr("readonly", false);
             $('#factory_remarks').attr("readonly", false);

             // Set data to Form
             $('#edit_factory_id').val(id);
             $('#factory_name').val(name);
             $('#factory_incharge').val(incharge);
             $('#factory_remarks').val(remarks);

             // Call the Modal
             $('#modal_factory_detail').modal('show');
         })

         $('.btn-detail').on('click', function(event) {
             // get data from button edit
             let id = $(this).data('id');
             let name = $(this).data('factory-name');
             let incharge = $(this).data('incharge');
             let remarks = $(this).data('remarks');

             $('#ModalLabel').text("Factory Details")
             $('#btn_submit').attr('hidden', true);

             // Set ReadOnly the textboxes
             $('#edit_factory_id').attr("readonly", true);
             $('#factory_name').attr("readonly", true);
             $('#factory_incharge').attr("readonly", true);
             $('#factory_remarks').attr("readonly", true);

             // Set data to Form
             $('#edit_factory_id').val(id);
             $('#factory_name').val(name);
             $('#factory_incharge').val(incharge);
             $('#factory_remarks').val(remarks);

             // Call the Modal
             $('#modal_factory_detail').modal('show');
         })
     });
 </script>

 <script type="text/javascript">
     const store_url = "../index.php/factory/save";
     const update_url = "../index.php/factory/update";
 </script>

 <?= $this->endSection('content'); ?>