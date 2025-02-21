document.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery != 'undefined' && typeof jQuery.ui != 'undefined') {
        const priceFilter = $("#price_filter");
        if (priceFilter.length) {
            const minPrice = parseInt(priceFilter.data('min'));
            const maxPrice = parseInt(priceFilter.data('max'));
            const currentMinValue = parseInt(priceFilter.data('min-value'));
            const currentMaxValue = parseInt(priceFilter.data('max-value'));

            priceFilter.slider({
                range: true,
                min: minPrice,
                max: maxPrice,
                values: [currentMinValue, currentMaxValue],
                slide: function(event, ui) {
                    $("#slider-range-value1").text('$' + ui.values[0].toLocaleString('en-US'));
                    $("#slider-range-value2").text('$' + ui.values[1].toLocaleString('en-US'));
                    $("#price_first").val(ui.values[0]);
                    $("#price_second").val(ui.values[1]);
                }
            });

            // Handle filter button click
            $("#apply-price-filter").on('click', function(e) {
                e.preventDefault();
                const minPrice = $("#price_first").val();
                const maxPrice = $("#price_second").val();
                
                // Get current URL and parameters
                const url = new URL(window.location.href);
                const params = new URLSearchParams(url.search);
                
                // Update or add price parameters
                params.set('min_price', minPrice);
                params.set('max_price', maxPrice);
                
                // Redirect to filtered URL
                window.location.href = `${url.pathname}?${params.toString()}`;
            });
        }
    }
});
