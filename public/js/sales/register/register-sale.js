$.ajaxSetup(
    {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
);
$('#add-sale').on('click', function(e) {
    e.preventDefault();
    // var values_filter;
    // var data_filter;
    // var values_update = carge_values('form-update');

    let data = carge_rows();

    if (Object.keys(data).length > 0) {
        // values_filter = carge_values('form-filter');
        // data_filter = {
        //     percentage : values_update['percentage'],
        //     name : values_filter['name'],
        //     supplier_id : values_filter['supplier_id'],
        //     category_id : values_filter['category_id'],
        //     date_since : values_filter['date_since'],
        //     date_to : values_filter['date_to'],
        // }
        console.log('llego');
        $.ajax({
                url: 'sales-register-action',
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    // carge_table(response.products, response.categories, response.suppliers);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            }
        );
    }
});

function carge_rows () {
    let rows, set_rows, row, tds, count;
    
    set_rows = {};
    count = 0;
    rows = $('#tbody-sale').find('tr');

    rows.each(
        function () {
            if ($(this).attr('id') != 'trsale-total'){
                row = {};
                tds = $(this).find('td');
                row['product_id'] = $(this).attr('id').split('-')[1];
                row['code'] = tds.eq(1).text();
                row['name'] = tds.eq(2).text();
                row['price'] = tds.eq(3).text();
                row['quantity'] = tds.eq(4).text();
    
                set_rows[count] = row;
                count += 1;
            }
        }
    );
    set_rows['qty'] = count;
    return set_rows;
}
