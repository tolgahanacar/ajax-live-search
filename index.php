<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Strict and secure Content-Security-Policy -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://code.jquery.com; style-src 'self' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self';">
    
    <title>Ajax Live Search</title>
    
    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
                <input type="search" name="sea" id="sea" placeholder="Search (e.g. php, javascript, react)..." autocomplete="off" autofocus role="combobox" aria-expanded="false" aria-autocomplete="list" aria-controls="result">
                <button type="button" id="clear-search" class="clear-btn" aria-label="Clear search input" title="Clear search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <span class="shortcut-kbd" id="shortcut-hint" title="Press / to focus search"><kbd>/</kbd></span>
            </div>
            <div class="results-wrapper" id="results-wrapper">
                <div id="result" role="listbox" aria-label="Search Results"></div>
                <div class="results-footer" id="results-footer">
                    <span class="results-count" id="results-count">0 results</span>
                    <span class="keyboard-hints">
                        <kbd>↑</kbd><kbd>↓</kbd> navigate <kbd>↵</kbd> select <kbd>esc</kbd> close
                    </span>
                </div>
            </div>
            <div id="search-aria-status" class="sr-only" aria-live="polite" aria-atomic="true"></div>
        </form>
    </div>

    <!-- Externalized scripts - Updated to jQuery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="assets/js/search.js"></script>
</body>
</html>
