<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo base_url('index.php/home') ?>">Home</a>
            </li>
        </ul>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link"><?=session()->get()['userData']['name'];?></a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->