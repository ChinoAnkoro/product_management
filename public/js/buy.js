document.getElementById('purchase-button').addEventListener('click', function() {
    const productId = this.getAttribute('data-product-id');
    const quantity = document.getElementById('quantity-input').value;

    fetch('/api/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            // 必要に応じてページをリロードしたり、UIを更新したりします
        }
    })
    .catch(error => {
        console.error('エラーが発生しました:', error);
        alert('購入に失敗しました。');
    });
});