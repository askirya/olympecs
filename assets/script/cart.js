$(document).ready(function () {
    $(document).on('click', '.increase-quantity', function () {
        var productId = $(this).data('id');
        $.ajax({
            url: './public/update_cart.php',
            type: 'POST',
            data: { product_id: productId, action: 'increase' },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert("Ошибка при обновлении количества.");
                }
            }
        });
    });

    $(document).on('click', '.decrease-quantity', function () {
        var productId = $(this).data('id');
        $.ajax({
            url: './public/update_cart.php',
            type: 'POST',
            data: { product_id: productId, action: 'decrease' },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert("Ошибка при обновлении количества.");
                }
            }
        });
    });

    $(document).on('click', '.remove-from-cart', function () {
        var productId = $(this).data('id');
        $.ajax({
            url: './public/remove_from_cart.php',
            type: 'POST',
            data: { product_id: productId },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert("Товар удален из корзины!");
                    location.reload();
                } else {
                    alert("Ошибка при удалении товара.");
                }
            }
        });
    });

    $('#apply-promo-code').click(function () {
        var promoCode = $('#promo-code').val();
        $.ajax({
            url: './public/apply_promo.php',
            type: 'POST',
            data: { promo_code: promoCode },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert("Промокод применен!");
                    location.reload();
                } else {
                    alert("Некорректный промокод.");
                }
            }
        });
    });

    $('#checkout').click(function () {
        $.ajax({
            url: './public/checkout.php',
            type: 'POST',
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.href = './order.php';  // Перенаправление на order.php
                } else {
                    alert("Ошибка: " + data.message);
                }
            }
        });
    });
});