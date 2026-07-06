<?php
require_once 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Strict and secure Content-Security-Policy -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://code.jquery.com; style-src 'self' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self';">
    
    <title>Ajax Live Search</title>
    
    <!-- Premium stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="search-container">
        <div class="search-header">
            <h1>Ajax Live Search</h1>
            <p>Start typing to search programming languages and frameworks instantly.</p>
        </div>
        
        <form method="post" action="#" onsubmit="return false;">
            <div class="input-wrapper">
                <input type="search" name="sea" id="sea" placeholder="Search (e.g. php, javascript, react)..." autocomplete="off" autofocus>
            </div>
            <div class="results-wrapper" id="results-wrapper">
                <div id="result"></div>
            </div>
        </form>
    </div>

    <!-- Externalized scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="assets/js/search.js"></script>
</body>
</html>
