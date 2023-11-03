<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?= $title ?></title>

    <base href="<?= base_url('assets') ?>/">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">

    <!-- Custom style -->
    <link rel="stylesheet" href="css/scanpack.css">

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?= $this->include('app-layout/navbar'); ?>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('home') ?>" class="brand-link">
                <img src="img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= config('app')->applicationName; ?></span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <!--<li class="nav-item menu-open"> -->

                        <?php if (in_array(session()->get('role'), ['superadmin'])) : ?>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        Administrator
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview pl-3">
                                    <?php if (in_array(session()->get('role'), ['superadmin'])) : ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url('user') ?>" class="nav-link">
                                                <i class="nav-icon fas fa-users"></i>
                                                <p>User Management</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?= base_url('factory'); ?>" class="nav-link">
                                                <i class="nav-icon fas fa-industry"></i>
                                                <p>Factory</p>
                                            </a>
                                        </li>
                                    <?php endif ?>

                                </ul>
                            </li>
                        <?php endif ?>
                        
                        <?php if (in_array(session()->get('role'), ['superadmin', 'admin', 'merchandiser'])) : ?>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        Master Data
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview pl-3">

                                    <li class="nav-item">
                                        <a href="<?= base_url('buyer'); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-user-tie"></i>
                                            <p>Buyer</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('colour'); ?>" class="nav-link">
                                            <i class="nav-icon fa fa-palette"></i>
                                            <p>Colour</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('category'); ?>" class="nav-link">
                                            <i class="nav-icon fas fa-tags"></i>
                                            <p>Product Type</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('style'); ?>" class="nav-link">
                                            <i class="nav-icon fas fa-paint-brush"></i>
                                            <p>Style</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('product'); ?>" class="nav-link">
                                            <i class="nav-icon fas fa-tshirt"></i>
                                            <p>Products</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('gl'); ?>" class="nav-link">
                                            <i class="nav-icon fas fa-file-contract"></i>
                                            <p>GL</p>
                                        </a>
                                    </li>

                                    <?php if (in_array(session()->get('role'), ['superadmin','admin'])) : ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url('pallet'); ?>" class="nav-link">
                                            <i class="nav-icon fas fa-pallet"></i>
                                            <p>Pallet</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('rack'); ?>" class="nav-link">
                                            <i class="nav-icon fas fa-memory"></i>
                                            <p>Rack</p>
                                        </a>
                                    </li>
                                    <?php endif ?>

                                </ul>
                            </li>
                        <?php endif ?>

                        <?php if (in_array(session()->get('role'), ['superadmin', 'admin', 'merchandiser', 'packing'])) : ?>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-exchange-alt"></i>
                                    <p>Transaction
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview pl-3">

                                    <li class="nav-item">
                                        <a href="<?= base_url('purchaseorder'); ?>" class="nav-link">
                                            <i class="nav-icon far fa-file-alt"></i>
                                            <p>Buyer PO</p>
                                        </a>
                                    </li>
                                    <?php if (in_array(session()->get('role'), ['superadmin','admin', 'packing'])) : ?>

                                    <li class="nav-item" <?php if ($title == 'Factory Packing List') echo 'active' ?>>
                                        <a class="nav-link" href="<?= base_url('packinglist') ?>">
                                            <i class="nav-icon far fa-list-alt"></i>
                                            <p>Packing List</p>
                                        </a>
                                    </li>
                                    <?php endif ?>
                                </ul>
                            </li>
                        <?php endif ?>

                        <?php if (in_array(session()->get('role'), ['superadmin', 'admin', 'packing','shipping'])) : ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>
                                        Carton & Ratio
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url('cartonbarcode') ?>">
                                            <i class="nav-icon far fa-circle"></i>
                                            <p>Carton Barcode & Rasio</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif ?>

                        <?php if (in_array(session()->get('role'), ['superadmin', 'admin', 'shipping','packing'])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('scanpack') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-barcode"></i>
                                    <p>Pack Carton</p>
                                </a>
                            </li>
                        <?php endif ?>

                        <?php if (in_array(session()->get('role'), ['superadmin','admin'])) : ?>
                            <li class="nav-item has-treeview">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-box-open"></i>
                                    <p>Carton Inspection <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview pl-3">
                                    <li class="nav-item">
                                        <a href="<?= base_url('cartoninspection/create') ?>" class="nav-link">
                                            <i class="far fa-plus-square nav-icon"></i>
                                            <p>New Inspection</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('cartoninspection') ?>" class="nav-link">
                                            <i class="fas fa-list-ul nav-icon"></i>
                                            <p>Inspection List</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif ?>
                        <?php if (in_array(session()->get('role'), ['superadmin','admin','packing','fg_warehouse'])) : ?>
                            <li class="nav-item has-treeview">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-dolly-flatbed"></i>
                                    <p>Packing Transfer <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview pl-3">
            
                                    <?php if (in_array(session()->get('role'), ['superadmin','admin', 'packing'])) : ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url('pallet-transfer') ?>" class="nav-link">
                                            <i class="fas fa-list-ul nav-icon"></i>
                                            <p>Pallet Transfer List</p>
                                        </a>
                                    </li>
                                    <?php endif ?>
                                    
                                    <?php if (in_array(session()->get('role'), ['superadmin','admin', 'fg_warehouse'])) : ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url('pallet-receive') ?>" class="nav-link">
                                            <i class="fas fa-list-ul nav-icon"></i>
                                            <p>Pallet Receive List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('pallet-receive/create') ?>" class="nav-link">
                                            <i class="fas fa-list-ul nav-icon"></i>
                                            <p>Pallet Receive</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('rack-information') ?>" class="nav-link">
                                            <i class="fas fa-list-ul nav-icon"></i>
                                            <p>Rack Information</p>
                                        </a>
                                    </li>
                                    <?php endif ?>
                                </ul>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a href="<?= base_url('logout') ?>" class="nav-link">
                                <i class="fas fa-sign-out-alt nav-icon"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                        <br>
                        <!-- <li class="nav-item">
                            <a href="https://adminlte.io/docs/3.1/" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>Documentation</p>
                            </a>
                        </li> -->
                        

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url('assets'); ?>/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <?= $this->renderSection('content'); ?>

        <footer class="main-footer">
            <strong>Copyright &copy; 2023 <a href="http://www.ghimli.com">IT Team of PT. Ghim Li Indonesia</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>

    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

    <!-- Input Mask JS -->
    <script src="js/jquery.inputmask.js"></script>
    
    <!-- AdminLTE App -->
    <script src="js/adminlte.js"></script>

    <!-- Custom JS | Utility -->
    <script src="<?= base_url(); ?>assets/js/utils.js"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#table1").DataTable({
                "buttons": ["excel", "pdf", "print"],
                "lengthMenu": [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, 'All'],
                ],
                dom: "<'row'<'col-md-2'l><'col-md-6'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            }).buttons().container().appendTo('#table1_wrapper .col-md-6:eq(0)');
        });
    </script>

    <!-- Page Script | Javascript Khusus di halaman tersebut -->
    <?= $this->renderSection('page_script'); ?>


    <!-- ## Script for set Active Class depand on Active Page -->
    <!-- <script>
        $(document).ready(function() {
            /*** add active class and stay opened when selected ***/
            $(function () {
                var url = window.location;
                // for single sidebar menu
                $('ul.nav-sidebar a').filter(function () {
                    return this.href == url;
                }).addClass('active');

                // for sidebar menu and treeview
                $('ul.nav-treeview a').filter(function () {
                    return this.href == url;
                }).parentsUntil(".nav-sidebar > .nav-treeview")
                    .css({'display': 'block'})
                    .addClass('menu-open').prev('a')
                    .addClass('active');
            });
        });
    </script> -->

    <!-- ## Script for set Active Class depand on Active Page -->
    <script>
        $(document).ready(function() {
            /*** add active class and stay opened when selected ***/
            $(function () {
                var url = window.location;
                // for single sidebar menu
                $('ul.nav-sidebar a').filter(function () {
                    return this.href == url;
                }).addClass('active');

                // for sidebar menu and treeview
                $('ul.nav-treeview a').filter(function () {
                    return this.href == url;
                }).parentsUntil(".nav-sidebar > .nav-treeview")
                    .css({'display': 'block'})
                    .addClass('menu-open').prev('a')
                    .addClass('active');
            });
        });
    </script>
</body>

</html>