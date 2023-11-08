// import 'create-table-products.js';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}
);
document.addEventListener('DOMContentLoaded', function (e) {
    
    $('#alert-table').hide();
    $('#btn-filter-1').on('click', function (e) {
        e.preventDefault();
        var my_array;
        var values = carge_values('form-filter');
        var data_filter = {
            code : values['code'],
            name : values['name'],
            supplier_id : values['supplier_id'],
            category_id : values['category_id'],
            price_since : values['price_since'],
            price_to : values['price_to'],
            date_since : values['date_since'],
            date_to : values['date_to'],
        }
        $.ajax({
                url: 'products-filter-async',
                type: 'GET',
                data: data_filter,
                success: function(response) {
                    carge_table(response.products, response.categories, response.suppliers);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            }
        );

    });
});