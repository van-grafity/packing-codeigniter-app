<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Auto Complete in CodeIgniter 4!</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#keyword").autocomplete({
                source: "<?= site_url('demo/ajax') ?>"
            });
        });
    </script>
</head>

<body>
    <h3>AutoComplete</h3>
    <input type="text" id="keyword" placeholder="Keyword....">
</body>

</html>