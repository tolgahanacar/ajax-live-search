$(document).ready(function() {
    let timeout = null;
    let currentRequest = null;
    let selectedIndex = -1;

    const $searchInput = $("#sea");
    const $resultsWrapper = $("#results-wrapper");
    const $resultsContainer = $("#result");
    const $resultsFooter = $("#results-footer");
    const $resultsCount = $("#results-count");
    const $clearBtn = $("#clear-search");
    const $shortcutHint = $("#shortcut-hint");
    const $ariaStatus = $("#search-aria-status");

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
    const noResultsHTML = (query) => `
        <div class="no-results">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>No results matched "<strong>${$('<div>').text(query).html()}</strong>"</p>
            <span class="no-results-hint">Try searching for keywords like PHP, JavaScript, Python, or React</span>
        </div>
    `;

    // Error HTML
    const errorHTML = (message) => `
        <div class="no-results error-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#ef4444">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="error-msg">${$('<div>').text(message).html()}</p>
        </div>
    `;

    // Safe keyword highlighting using regex escaping
    function highlightMatch(text, query) {
        if (!text) return '';
        const safeText = $('<div>').text(text).html();
        if (!query) return safeText;
        const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escaped})`, 'gi');
        return safeText.replace(regex, '<mark class="highlight">$1</mark>');
    }

    function toggleControls(hasText) {
        if (hasText) {
            $clearBtn.addClass("visible");
            $shortcutHint.addClass("hidden");
        } else {
            $clearBtn.removeClass("visible");
            $shortcutHint.removeClass("hidden");
        }
    }

    function openResults() {
        $resultsWrapper.addClass("active");
        $searchInput.attr("aria-expanded", "true");
    }

    function closeResults() {
        $resultsWrapper.removeClass("active");
        $searchInput.attr("aria-expanded", "false");
        $searchInput.removeAttr("aria-activedescendant");
        selectedIndex = -1;
    }

    // Function to render items
    function renderResults(items, currentQuery) {
        selectedIndex = -1;
        $searchInput.removeAttr("aria-activedescendant");

        if (!items || items.length === 0) {
            $resultsContainer.html(noResultsHTML(currentQuery));
            $resultsFooter.hide();
            $ariaStatus.text("No results found for " + currentQuery);
            return;
        }

        let html = '';
        items.forEach(function(item, index) {
            const safeId = $('<div>').text(item.id).html();
            const rawTitle = item.title || item.description;
            const rawCategory = item.category || 'Technology';
            
            const highlightedTitle = highlightMatch(rawTitle, currentQuery);
            const highlightedCategory = highlightMatch(rawCategory, currentQuery);
            const itemId = `result-item-${index}`;
            
            html += `
                <a href="get.php?id=${safeId}" id="${itemId}" class="result-item" role="option" aria-selected="false">
                    <div class="item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="item-content">
                        <div class="item-title">${highlightedTitle}</div>
                        <div class="item-category">${highlightedCategory}</div>
                    </div>
                    <div class="item-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            `;
        });

        $resultsContainer.html(html);
        $resultsCount.text(items.length === 1 ? '1 result' : `${items.length} results`);
        $resultsFooter.show();
        $ariaStatus.text(`${items.length} results found for ${currentQuery}`);
    }

    function updateActiveItem($items) {
        $items.removeClass("selected").attr("aria-selected", "false");
        if (selectedIndex >= 0 && selectedIndex < $items.length) {
            const $selected = $items.eq(selectedIndex);
            $selected.addClass("selected").attr("aria-selected", "true");
            $searchInput.attr("aria-activedescendant", $selected.attr("id"));

            // Ensure the active item is visible inside scrolling container
            const container = $resultsWrapper[0];
            const elem = $selected[0];
            if (elem.offsetTop < container.scrollTop) {
                container.scrollTop = elem.offsetTop;
            } else if (elem.offsetTop + elem.offsetHeight > container.scrollTop + container.clientHeight) {
                container.scrollTop = elem.offsetTop + elem.offsetHeight - container.clientHeight;
            }
        } else {
            $searchInput.removeAttr("aria-activedescendant");
        }
    }

    // Input handler
    $searchInput.on("input", function() {
        const query = $searchInput.val().trim();
        toggleControls(query !== '');
        
        clearTimeout(timeout);

        if (query === '') {
            if (currentRequest && currentRequest.readyState !== 4) {
                currentRequest.abort();
            }
            closeResults();
            $resultsContainer.empty();
            $resultsFooter.hide();
            return;
        }

        // Show skeleton loader
        openResults();
        $resultsContainer.html(skeletonHTML);
        $resultsFooter.hide();

        timeout = setTimeout(function() {
            // Abort previous in-flight request to prevent race conditions
            if (currentRequest && currentRequest.readyState !== 4) {
                currentRequest.abort();
            }

            currentRequest = $.ajax({
                url: "ajax.php",
                type: "POST",
                dataType: "json",
                data: { value: query },
                success: function(response) {
                    if (response.success) {
                        renderResults(response.data, query);
                    } else {
                        $resultsContainer.html(errorHTML(response.message || "Unknown error occurred."));
                        $resultsFooter.hide();
                    }
                },
                error: function(xhr, status, error) {
                    if (status === 'abort') return;
                    console.error("AJAX Error:", status, error);
                    $resultsContainer.html(errorHTML("Could not connect to the search server."));
                    $resultsFooter.hide();
                }
            });
        }, 300); // 300ms debounce
    });

    // Clear button click handler
    $clearBtn.on("click", function() {
        $searchInput.val('');
        toggleControls(false);
        if (currentRequest && currentRequest.readyState !== 4) {
            currentRequest.abort();
        }
        closeResults();
        $resultsContainer.empty();
        $resultsFooter.hide();
        $searchInput.focus();
    });

    // Keyboard navigation (Arrow keys, Enter, Escape)
    $searchInput.on("keydown", function(e) {
        const $items = $resultsContainer.find(".result-item");

        if (e.key === "ArrowDown" || e.keyCode === 40) {
            if ($items.length > 0 && $resultsWrapper.hasClass("active")) {
                e.preventDefault();
                selectedIndex = (selectedIndex + 1) % $items.length;
                updateActiveItem($items);
            }
        } else if (e.key === "ArrowUp" || e.keyCode === 38) {
            if ($items.length > 0 && $resultsWrapper.hasClass("active")) {
                e.preventDefault();
                selectedIndex = (selectedIndex - 1 + $items.length) % $items.length;
                updateActiveItem($items);
            }
        } else if (e.key === "Enter" || e.keyCode === 13) {
            if (selectedIndex >= 0 && selectedIndex < $items.length) {
                e.preventDefault();
                const targetUrl = $items.eq(selectedIndex).attr("href");
                if (targetUrl) {
                    window.location.href = targetUrl;
                }
            }
        } else if (e.key === "Escape" || e.keyCode === 27) {
            closeResults();
        }
    });

    // Global shortcut: press '/' anywhere on the page to focus the search box
    $(document).on("keydown", function(e) {
        if (e.key === "/" && !$(e.target).is("input, textarea")) {
            e.preventDefault();
            $searchInput.focus().select();
        } else if (e.key === "Escape") {
            closeResults();
        }
    });

    // Close results when clicking outside
    $(document).on("click", function(event) {
        if (!$(event.target).closest('.search-container').length) {
            closeResults();
        }
    });

    // Re-open results if input is focused and has text
    $searchInput.on("focus", function() {
        if ($searchInput.val().trim() !== '') {
            openResults();
        }
    });

    // Initialize initial control state
    toggleControls($searchInput.val().trim() !== '');
});


