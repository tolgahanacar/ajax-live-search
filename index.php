<?php
require_once 'connect.php';
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://code.jquery.com; style-src 'self'; img-src 'self'">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <script type="text/javascript">
        $(document).ready(function() {
            let timeout = null;
            
            $("#sea").on("input", function() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    $.post("ajax.php", { value: $("#sea").val() }, function(response) {
                        $("#result").html(response).show();
                    });
                }, 300); // Delay of 300ms
            });
        });
    </script>
</head>
<body>
    <form method="post" action="#">
        <div>
            <input type="search" name="sea" id="sea" placeholder="Search...">
        </div>
        <div>
            <p id="result"></p>
        </div>
    </form>
</body>
</html>
