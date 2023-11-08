$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}
);
$('#btn-update-1').on('click', function(e) {
    e.preventDefault();
    var values_filter;
    var data_filter;
    var values_update = carge_values('form-update');

    if (values_update['percentage'] !== '' && values_update['percentage'] !== '0') {
        values_filter = carge_values('form-filter');
        data_filter = {
            percentage : values_update['percentage'],
            name : values_filter['name'],
            supplier_id : values_filter['supplier_id'],
            category_id : values_filter['category_id'],
            date_since : values_filter['date_since'],
            date_to : values_filter['date_to'],
        }
        
        $.ajax({
                url: 'products-filter-price-update-async',
                type: 'POST',
                data: data_filter,
                success: function(response) {
                    console.log(response);
                    carge_table(response.products, response.categories, response.suppliers);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            }
        );
    }
});