$(document).ready(function () {
    // 検索フォームの送信処理
    $('#search-form').on('submit', function (e) {
        e.preventDefault(); // フォームのデフォルトの送信を防止

        let formData = $(this).serialize();

        // Ajaxリクエストを送信
        $.ajax({
            url: productsIndexUrl,
            method: "GET",
            data: formData,
            dataType: 'html',
            success: function (response) {
                $('#product-list').html($(response).find('#product-list').html());
                $('#pagination-links').html($(response).find('#pagination-links').html());
            },
            error: function (xhr) {
                console.error('検索処理中にエラーが発生しました。', xhr);
            }
        });
    });

    // ページネーションリンククリック時もAjaxを使用
    $(document).on('click', '#pagination-links a', function (e) {
        e.preventDefault();

        let pageUrl = $(this).attr('href');

        $.ajax({
            url: pageUrl,
            method: "GET",
            dataType: 'html',
            success: function (response) {
                $('#product-list').html($(response).find('#product-list').html());
                $('#pagination-links').html($(response).find('#pagination-links').html());
            },
            error: function (xhr) {
                console.error('ページネーション処理中にエラーが発生しました。', xhr);
            }
        });
    });
});