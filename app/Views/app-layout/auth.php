<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta name="viewport" content="width=device-width" />
    <title>Codeigniter 4 Authentication</title>

    <base href="<?php echo base_url('assets') ?>/">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/auth.css">
</head>

<body>

    <div class="wrapper">
        <div class="auth-content">
            <?= $this->renderSection('main') ?>
        </div>
    </div>

    <script src="plugins/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url("plugins/bootstrap/js/bootstrap.bundle.min.js") ?>" type="text/javascript"></script>
</body>

</html>