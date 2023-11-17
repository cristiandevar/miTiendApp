$.ajaxSetup(
    {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
);
document.addEventListener('DOMContentLoaded',
    function (e) {
        
        $('#table-purchases-2').hide();
        $('#alert-table-purchases-2').hide();

        $('#tbody-purchases-1 tr').each(
            function () {
                let id = $(this).attr('id').split('-')[1];
                $(this).children().last().find('a').first().on('click',
                    function ( e ) {
                        e.preventDefault();
                        show_rows(id);
                    }

                );            
            }
        );
        $('#register-purchase').on('click',
            function (e) {
                e.preventDefault();

                let data = carge_rows();

                if (Object.keys(data).length > 1) {
                    let div_alert,div_error;
        
                    div_alert = $('#div-alert-1');
                    div_error = $('#div-error-1');
                    $.ajax(
                        {
                            url: 'purchase-register-action',
                            type: 'POST',
                            data: data,
                            success: function(response) {
                                div_alert.children().first().text('La compra se registro con exito');
                                div_alert.show();
                                div_error.hide();
                                $('html, body').animate({scrollTop:0}, 'slow');
                            },
                            error: function(xhr, status, error) {
                                div_error.children().first().text('La compra no se pudo registrar');
                                div_error.show();
                                div_alert.hide();
                                $('html, body').animate({scrollTop:0}, 'slow');
                            }
                        }
                    ).always(
                        function(){
                            clear_details();
                        }
            
                    );
                }

            }
        );



    }
);

function show_rows ( id ) {
    let data_filter = {
        'id': id,
    }
    $.ajax(
        {
            url: 'purchase-filter-async',
            type: 'GET',
            data: data_filter,
            success: function(response) {
                clear_details();
                show_details(response.purchase, response.details, response.products);
                
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        }
    );
}

function show_details (purchase, details, products) {
    // console.log(purchase, details);
    let tbody, tr, td0, td1, td2, td3, td4, input1, input2;

    tbody = $('#tbody-purchases-2');
    
    if (details.length > 0) {
        
        $('#table-purchases-2').show();
        $('#alert-table-purchases-2').hide();

        for( let i = 0; i< details.length; i++){
            // console.log(products); 

            tr = document.createElement('tr');
            tr.setAttribute('id','trdetail-'+details[i]['id']);
            
            td0 = document.createElement('td');
            td0.innerHTML = i + 1;
            tr.appendChild(td0);

            td1 = document.createElement('td');
            td1.innerHTML = get_object(products, details[i]['product_id'])['name'];
            tr.appendChild(td1);

            td2 = document.createElement('td');
            td2.innerHTML = details[i]['quantity_ordered']
            tr.appendChild(td2);
            
            td3 = document.createElement('td');
            input1 = document.createElement('input');
            input1.setAttribute('type','number');
            input1.setAttribute('min','0');
            td3.appendChild(input1);
            tr.appendChild(td3);

            td4 = document.createElement('td');
            input2 = document.createElement('input');
            input2.setAttribute('type','number');
            input2.setAttribute('min','0');
            td4.appendChild(input2);
            tr.appendChild(td4);
            
            tbody.append(tr);
        }
    }
    else {
        $('#table-purchases-2').hide();
        $('#alert-table-purchases-2').show();
    }

    // $('#tbody-purchases-2')
}

function clear_details(){
    $('#tbody-purchases-2').html('');
}

function carge_rows () {
    let rows, set_rows, row, tds, count;
    
    set_rows = {};
    count = 0;
    rows = $('#tbody-purchases-2').find('tr');
    // console.log(rows);
    rows.each(
        function () {
            let qty, price;
            // if ($(this).attr('id') != 'trsale-total'){
                row = {};
                tds = $(this).find('td');
                row['id'] = $(this).attr('id').split('-')[1];
                qty = tds.eq(3).text();
                if(qty != ''){
                    row['quantity_received'] = parseInt(qty);
                }
                else{
                    row['quantity_received'] = 0;
                }

                price = tds.eq(4).text();
                if(price != ''){
                    row['cost_price'] = parseFloat(price);
                }
                else {
                    row['cost_price'] = 0;
                }
    
                set_rows[count] = row;
                count += 1;
            // }
        }
    );
    set_rows['qty'] = count;
    return set_rows;
}