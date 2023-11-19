document.addEventListener('DOMContentLoaded', function (e) {
    
    $('#alert-table').hide();

    $('#code').on('input', function (e) {
        call_filter();
    });

    $('#name').on('input', function (e) {
        call_filter();
    });

    $('#supplier_id').on('change', function (e) {
        call_filter();
    });

    $('#category_id').on('change', function (e) {
        call_filter();
    });

    $('#price_since').on('input', function (e) {
        call_filter();
    });

    $('#price_to').on('input', function (e) {
        call_filter();
    });

    $('#stock_since').on('input', function (e) {
        call_filter();
    });

    $('#stock_to').on('input', function (e) {
        call_filter();
    });

    $('#date_since').on('change', function (e) {
        call_filter();
    });

    $('#date_to').on('change', function (e) {
        call_filter();
    });

    $('#order-by-1').on('change', function (e) {
        call_filter();
    });

    $('#order-by-2').on('change', function (e) {
        call_filter();
    });
});

function call_filter(){
    var values = carge_values('form-filter');
        var data_filter = {
            code : values['code'],
            name : values['name'],
            supplier_id : values['supplier_id'],
            category_id : values['category_id'],
            price_since : values['price_since'],
            price_to : values['price_to'],
            stock_since : values['stock_since'],
            stock_to : values['stock_to'],
            date_since : values['date_since'],
            date_to : values['date_to'],
            order_by_1 : values['order_by_1'],
            order_by_2 : values['order_by_2'],
        }
        $.ajax({
                url: 'products-filter-async',
                type: 'GET',
                data: data_filter,
                success: function(response) {
                    $('#alert-table').hide();
                    carge_table(response.products, response.categories, response.suppliers);
                },
                error: function(xhr, status, error) {
                    $('#alert-table').show();
                    console.error(error);
                }
            }
        );
}