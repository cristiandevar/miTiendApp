document.addEventListener('DOMContentLoaded', function (e) {
    
    $('#alert-table').hide();

    $('#btn-filter-1').hide();
    $('#btn-filter-1').on('click', function (e) {
        e.preventDefault();
        call_filter();
    });

    $('#name').on('input', function (e) {
        e.preventDefault();
        call_filter();
    });

    $('#code').on('input', function (e) {
        e.preventDefault();
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
}