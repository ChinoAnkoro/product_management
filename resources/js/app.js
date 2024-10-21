import './destroy.js';
import './search.js';

$(document).ready(function() {
    $('#search-form').on('submit', function(event) {
        event.preventDefault();
        
        let formData = $(this).serialize();

        $.ajax({
            url: '/products', // 変更: Laravelのルートを直接指定
            method: 'GET',
            data: formData,
            success: function(response) {
                $('#product-list').html(response.html);
                $('#pagination-links').html(response.pagination);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});