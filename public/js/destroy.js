document.addEventListener("DOMContentLoaded", function() {
    // 親要素にイベントリスナーを登録して、削除ボタンがクリックされたときに処理を実行
    document.addEventListener("click", function(event) {
        // クリックされた要素が削除ボタンかどうかをチェック
        if (event.target.classList.contains("delete-product")) {
            event.preventDefault();
            const id = event.target.getAttribute("data-id");
            
            if (confirm("本当に削除しますか？")) {
                fetch(`/products/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    }
                })
                .then(response => {
                    if (response.ok) {
                        alert("削除しました");
                        location.reload();
                    } else {
                        alert("削除に失敗しました");
                    }
                })
                .catch(error => {
                    console.error("エラーが発生しました:", error);
                    alert("エラーが発生しました");
                });
            }
        }
    });
});