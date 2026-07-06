$(document).ready(function() {
    let timeout = null;
    const $searchInput = $("#sea");
    const $resultsWrapper = $("#results-wrapper");
    const $resultsContainer = $("#result");

    // Skeleton loader HTML
    const skeletonHTML = `
        <div class="skeleton-item">
            <div class="skeleton-icon"></div>
            <div class="skeleton-text"></div>
            <div class="skeleton-text short"></div>
        </div>
        <div class="skeleton-item">
            <div class="skeleton-icon"></div>
            <div class="skeleton-text"></div>
        </div>
        <div class="skeleton-item">
            <div class="skeleton-icon"></div>
            <div class="skeleton-text"></div>
            <div class="skeleton-text short"></div>
        </div>
    `;

    // No results HTML
    const noResultsHTML = `
        <div class="no-results">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>No results matched your search!</p>
        </div>
    `;

    // Error HTML
    const errorHTML = (message) => `
        <div class="no-results">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#ef4444">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p style="color: #f87171;">Error: ${message}</p>
        </div>
    `;

    // Function to render items
    function renderResults(items) {
        if (!items || items.length === 0) {
            $resultsContainer.html(noResultsHTML);
            return;
        }

        let html = '';
        items.forEach(function(item) {
            // Escape values for safe injection in attributes/content
            const safeId = $('<div>').text(item.id).html();
            const safeDescription = $('<div>').text(item.description).html();
            
            html += `
                <a href="get.php?id=${safeId}" class="result-item">
                    <div class="item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="item-text">${safeDescription}</div>
                </a>
            `;
        });
        $resultsContainer.html(html);
    }

    // Input handler
    $searchInput.on("input", function() {
        const query = $searchInput.val().trim();
        
        clearTimeout(timeout);

        if (query === '') {
            $resultsWrapper.removeClass("active");
            $resultsContainer.empty();
            return;
        }

        // Show skeleton loader
        $resultsWrapper.addClass("active");
        $resultsContainer.html(skeletonHTML);

        timeout = setTimeout(function() {
            $.ajax({
                url: "ajax.php",
                type: "POST",
                dataType: "json",
                data: { value: query },
                success: function(response) {
                    if (response.success) {
                        renderResults(response.data);
                    } else {
                        $resultsContainer.html(errorHTML(response.message || "Unknown error occurred."));
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    $resultsContainer.html(errorHTML("Could not connect to the search server."));
                }
            });
        }, 300); // 300ms debounce
    });

    // Close results when clicking outside
    $(document).on("click", function(event) {
        if (!$(event.target).closest('.search-container').length) {
            $resultsWrapper.removeClass("active");
        }
    });

    // Re-open results if input is focused and has text
    $searchInput.on("focus", function() {
        if ($searchInput.val().trim() !== '') {
            $resultsWrapper.addClass("active");
        }
    });
});
