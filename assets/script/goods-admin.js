function filterProducts() {
    let input = document.getElementById('product-search').value.toLowerCase();
    let productItems = document.getElementsByClassName('product-item');

    for (let i = 0; i < productItems.length; i++) {
        let productName = productItems[i].getElementsByClassName('product-details')[0].innerText.toLowerCase();
        if (productName.includes(input)) {
            productItems[i].style.display = "";
        } else {
            productItems[i].style.display = "none";
        }
    }
}

$(document).ready(function () {
    $('.increase-quantity').click(function () {
        let quantitySpan = $(this).siblings('.quantity');
        let quantity = parseInt(quantitySpan.text()) + 1;
        quantitySpan.text(quantity);

        let productId = $(this).data('id');
        updateStock(productId, quantity);
    });

    $('.decrease-quantity').click(function () {
        let quantitySpan = $(this).siblings('.quantity');
        let quantity = parseInt(quantitySpan.text());
        if (quantity > 0) {
            quantity -= 1;
            quantitySpan.text(quantity);

            let productId = $(this).data('id');
            updateStock(productId, quantity);
        }
    });

    function updateStock(productId, stock) {
        $.ajax({
            url: './public/update_stock.php',
            type: 'POST',
            data: { product_id: productId, stock: stock },
            success: function (response) {
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    console.log('Количество успешно обновлено');
                } else {
                    alert(data.message || 'Ошибка при обновлении количества');
                }
            },
            error: function () {
                alert('Ошибка при отправке данных на сервер');
            }
        });
    }

    $('.remove-product').click(function () {
        let productId = $(this).data('id');
        if (confirm('Вы уверены, что хотите удалить этот товар?')) {
            $.ajax({
                url: './public/delete_product.php',
                type: 'POST',
                data: { product_id: productId },
                success: function (response) {
                    alert('Товар удален');
                    location.reload();
                },
                error: function () {
                    alert('Ошибка при удалении товара');
                }
            });
        }
    });
});