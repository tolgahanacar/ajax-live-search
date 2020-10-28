<?php
require_once 'connect.php';
?>

<!doctype html>
<html lang="tr-TR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <script type="text/javascript">
        $(document).ready(function(){
            $("input[name=sea]").keyup(function(){
                var value = $(this).val();
                var sea = "value="+value;
                $.ajax({
                    type:"POST",
                    url:"ajax.php",
                    data: sea,
                    success: function(sonuc){
                        $("#result").show().html(sonuc);
                    }
                });
            });
        });
    </script>
</head>
<body>
<form action="">
    <div>
        <input type="search" name="sea" id="sea">
    </div>
    <div>
       <p id="result"></p>
    </div>
</form>
</body>
</html>
