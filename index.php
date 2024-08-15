<?php
require_once 'connect.php';
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#sea").on("input", function() {
                $.post("ajax.php", { value: $(this).val() }, function(response) {
                    $("#result").html(response).show();
                });
            });
        });
    </script>
</head>
<body>
    <form>
        <div>
            <input type="search" name="sea" id="sea" placeholder="Search...">
        </div>
        <div>
            <p id="result"></p>
        </div>
    </form>
</body>
</html>
