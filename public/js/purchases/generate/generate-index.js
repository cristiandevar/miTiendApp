
$.ajaxSetup(
    {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
);


document.addEventListener('DOMContentLoaded', 
    function (e) {
        let alert_1,alert_2,alert_3,alert_4, table_1, table_2;
        
        alert_1 = $('#div-alert-1');
        alert_2 = $('#div-error-1');
        alert_3 = $('#alert-table-purchase');
        alert_4 = $('#alert-table-options');

        table_1 = $('#table-purchase');
        // table_2 = $('#table-options-1');

        alert_1.hide();
        alert_2.hide();
        alert_3.hide();
        alert_4.hide();

        // table_2.hide();


        $('#add-purchase').on('click',
            function () {
                e.preventDefault();
                let data = carge_rows();

                if (Object.keys(data).length > 1) {
                    let div_alert,div_error;
                    
                    div_alert = $('#div-alert-1');
                    div_error = $('#div-error-1');
                                
                    $.ajax({
                            url: 'purchase-generate-action',
                            type: 'POST',
                            data: data,
                            success: function(response) {
                                div_alert.children().first().text('La compra se registro con exito');
                                div_alert.show();
                                div_error.hide();
                                // $('html, body').animate({scrollTop:0}, 'slow');
                            },
                            error: function(xhr, status, error) {
                                div_error.children().first().text('La compra no se pudo registrar');
                                div_error.show();
                                div_alert.hide();
                                // $('html, body').animate({scrollTop:0}, 'slow');
                            }
                        }
                    ).always(
                        function(){
                            clear_tables();
                        }
            
                    );
                }

            }
        );

    }
);

function carge_rows () {
    let rows, set_rows, row, tds, count, supplier;
    
    set_rows = {};
    
    // supplier = $('#select-supplier').val();
    // if ( supplier != '') {
    //     supplier = parseInt(supplier);
    //     set_rows = {
    //         'supplier_id': supplier,
    //     };
    // }
    
    count = 0;
    rows = $('#tbody-purchase').find('tr');
    // console.log(rows);
    rows.each(
        function () {
            row = {};
            tds = $(this).find('td');
            row['product_id'] = $(this).attr('id').split('-')[1];
            row['quantity'] = tds.eq(4).text();

            set_rows[count] = row;
            count += 1;
            
        }
    );
    set_rows['qty'] = count;
    return set_rows;
}

function clear_tables(){
    // $('#tbody-purchase').find('tr').each(
    //     function(){
    //         $(this).find('td').eq(3).children().first().val('');
    //         $(this).find('td').eq(3).children().last().text('');
    //         $(this).find('td').eq(3).children().last().attr('class','error');
    //     }
    // );
    // let last_tr = $('#tbody-sale').children().last();
    // last_tr.children().last().text('0');
    // $('#tbody-sale').html(last_tr);
    $('#tbody-purchase').html('');
}