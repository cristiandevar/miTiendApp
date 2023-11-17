document.addEventListener('DOMContentLoaded',
    function(){
        $('#div-alert-1').hide();
        $('#div-error-1').hide();
    }
);


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

    if (Object.keys(data).length > 1) {
        let div_alert,div_error;
        
        div_alert = $('#div-alert-1');
        div_error = $('#div-error-1');
                    
        $.ajax({
                url: 'sales-register-action',
                type: 'POST',
                data: data,
                success: function(response) {
                    div_alert.children().first().text('La venta se registro con exito');
                    div_alert.show();
                    div_error.hide();
                    $('html, body').animate({scrollTop:0}, 'slow');
                },
                error: function(xhr, status, error) {
                    div_error.children().first().text('La venta no se pudo registrar');
                    div_error.show();
                    div_alert.hide();
                    $('html, body').animate({scrollTop:0}, 'slow');
                }
            }
        ).always(
            function(){
                clear_tables();
            }

        );
    }
});

function carge_rows () {
    let rows, set_rows, row, tds, count;
    
    set_rows = {};
    count = 0;
    rows = $('#tbody-sale').find('tr');
    console.log(rows);
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

function clear_tables(){
    $('#tbody-products').find('tr').each(
        function(){
            $(this).find('td').eq(3).children().first().val('');
            $(this).find('td').eq(3).children().last().text('');
            $(this).find('td').eq(3).children().last().attr('class','error');
        }
    );
    let last_tr = $('#tbody-sale').children().last();
    last_tr.children().last().text('0');
    $('#tbody-sale').html(last_tr);
}