document.addEventListener('DOMContentLoaded', function () {
    // 削除ボタンのクリックイベント
    document.querySelectorAll('.delete-product').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            
            const productId = this.getAttribute('data-id');

            if (confirm('本当に削除しますか？')) {
                fetch(`/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.ok) {
                        alert('削除しました');
                        location.reload();  // ページをリロードして削除を反映
                    } else {
                        alert('削除に失敗しました');
                    }
                })
                .catch(error => {
                    console.error('エラーが発生しました:', error);
                    alert('エラーが発生しました');
                });
            }
        });
    });
});