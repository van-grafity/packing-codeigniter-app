<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>Under Maintenance</title>

    <!--CSS-->
    <link rel="stylesheet" href="<?= base_url(''); ?>css/maintenance.css">
    <link rel="stylesheet" href="<?= base_url(''); ?>css/bootstrap-light.css">
    <link href='https://fonts.googleapis.com/css?family=Oswald:300|Poppins:400,700' rel='stylesheet' type='text/css'>

	<style>
		.push-content {
			background-color: aquamarine;
			/* min-height: 20px; */
		}

		.message-wrapper {
			text-align:center;
		}
		.btn-direct {
			text-decoration: none;
			background-color: rgba(255,255,255,.2);
			padding: 1.5rem 2rem;
			border-radius: 5px;
			font-size: 2rem;
			
		}
		.btn-direct:hover {
			background-color: rgba(255,255,255,.3);
		}
	</style>
    <!--/CSS-->

    <!--JS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?= base_url(''); ?>js/maintenance/jquery.plugin.js"></script>
    <script src="<?= base_url(''); ?>js/maintenance/jquery.countdown.js"></script>
    <script>
    $(function() {
        $('#defaultCountdown').countdown({
            until: new Date(2023, 7, 10, 13, 0, 0)
        });
        //Replace above date with your own, to find out more visit http://keith-wood.name/countdown.html
    });
    </script>
    <!--/JS-->

</head>

<body>

    <!--DARK OVERLAY-->
    <div class="overlay"></div>
    <!--/DARK OVERLAY-->

    <!--WRAP-->
    <div id="wrap">
        <!--CONTAINER-->
        <div class="container">
            <div class="envelope">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="120" height="120">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                        d="M7.05 14.121L4.93 16.243l2.828 2.828L19.071 7.757 16.243 4.93 14.12 7.05l1.415 1.414L14.12 9.88l-1.414-1.415-1.414 1.415 1.414 1.414-1.414 1.414-1.414-1.414-1.415 1.414 1.415 1.414-1.415 1.415L7.05 14.12zm9.9-11.313l4.242 4.242a1 1 0 0 1 0 1.414L8.464 21.192a1 1 0 0 1-1.414 0L2.808 16.95a1 1 0 0 1 0-1.414L15.536 2.808a1 1 0 0 1 1.414 0zM14.12 18.363l1.415-1.414 2.242 2.243h1.414v-1.414l-2.242-2.243 1.414-1.414L21 16.757V21h-4.242l-2.637-2.637zM5.636 9.878L2.807 7.05a1 1 0 0 1 0-1.415l2.829-2.828a1 1 0 0 1 1.414 0L9.88 5.635 8.464 7.05 6.343 4.928 4.929 6.343l2.121 2.12-1.414 1.415z" />
                </svg>
            </div>
            <h1>
                <span class="small">Packing App App <span class="yellow">.</span></span>
                <span class="big">Under Maintenance</span>
            </h1>
			<?php if (! empty($message) && $message !== '(null)') : ?>
				<p><?= ($message) ?></p>
			<?php else :  ?>
				<div class="message-wrapper">
					<p style="margin-bottom:100px;">The system is temporarily unavailable. <br> Our team is currently updating the system.</p>
				</div>
			<?php endif ?>
            <!-- <div id="defaultCountdown"></div> -->
        </div>
        <!--/CONTAINER-->
	<div class="push-content"></div>

    </div>
    <!--/WRAP-->


</body>

</html>