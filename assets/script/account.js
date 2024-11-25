$(document).ready(function() {
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        var query = $('#search-query').val();
        $.ajax({
            url: './public/search-handler.php',
            method: 'GET',
            data: { query: query },
            success: function(response) {
                $('#search-results').html(response);
            }
        });
    });

    $(document).on('click', '.add-to-cart', function() {
        var productId = $(this).data('id');
        $.ajax({
            url: './public/add-to-cart.php',
            type: 'POST',
            data: { product_id: productId },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert("Товар добавлен в корзину!");
                    $('#cart-container').load('cart.php');
                } else {
                    alert("Ошибка при добавлении товара.");
                }
            }
        });
    });
});