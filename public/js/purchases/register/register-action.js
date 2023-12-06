$.ajaxSetup(
    {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
);

document.addEventListener('DOMContentLoaded',
    function (e) {
        
        $('#form-register-purchase').hide();
        $('#alert-table-purchases-2').hide();

        carge_links();

        $('#register-purchase').on('click',
            function (e) {
                e.preventDefault();
                let div_alert,div_error, total_paid;
                let data = carge_rows();

                div_alert = $('#div-alert-1');
                
                div_error = $('#alert-table-purchases-2');
                total_paid = $('#total-price-input');
                

                div_alert.hide();
                div_error.hide();
                if (Object.keys(data).length > 2 && !data['error'] && parseFloat(total_paid.val()) >= 0) {
                    div_error.hide();
                    div_alert.hide();
                    let title, msj;
                    title = '¿Estás seguro que deseas Registrar la Orden de Compra?';
                    msj = 'Sí, Registrala!';
                    show_confirm_sweet(title, msj).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax(
                                {
                                    url: 'purchase-register-action',
                                    type: 'POST',
                                    data: data,
                                    success: function(response) {
                                        // clear_tables();
                                        Swal.close();
                                        div_alert.children().first().text('La compra se registro con exito');
                                        div_alert.show();
                                        div_error.hide();
                                        update_table_purchases();
                                        clear_details();
                                        $('html, body').animate({scrollTop:0}, 'slow');
                                    },
                                    beforeSend: function() {
                                        show_charge_message();
                                    },
                                    error: function(xhr, status, error) {
                                        // clear_tables();
                                        
                                        // clear_details();
                                        Swal.close();
                                        div_error.children().first().text('La compra no se pudo registrar');
                                        div_error.show();
                                        div_alert.hide();
                                        $('html, body').animate({scrollTop:0}, 'slow');
                                    }
                                }
                            ).always(
                                function(){
                                    // clear_tables();
                                    // $('#loading-spinner').hide();
                                    // Swal.close();
                                }
                    
                            );
                        }
                    });
                }
                else {
                    div_error.show();
                    div_alert.hide();
                    if (!data['error'] && Object.keys(data).length > 2 ) {
                        div_error.find('p').first().text('Debe ingresar un "Total Pagado" valido o cero');

                    }
                    else if(!data['error']){
                        div_error.find('p').first().text('Debe elegir una orden para registrar');
                    }
                    else{
                        div_error.find('p').first().text('Debe ingresar cantidades y/o precios válidos');
                    }

                    $('html, body').animate({scrollTop:div_error.offset().top}, 'slow');
                            
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
                btn = $('#register-purchase').offset().top;
                $('html, body').animate({scrollTop:btn}, 'slow');
                    
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        }
    );
}

function carge_links(){
    $('#tbody-purchases-1 tr').each(
        function () {
            let id;
            $(this).children().last().find('a').each(
                function(){
                    // id = $(this).attr('id');
                    type_link = $(this).attr('id').split('-')[0];
                    if(type_link == 'linkr'){
                        $(this).on('click',
                            function(e){
                                let id = $(this).attr('id');
                                id = id.split('-')[1]
                                e.preventDefault();

                                // $('#tbody-purchases-3').html('');
                                $('#table-purchases-3').hide();
                                $('#form-update-purchase').hide();

                                $('#table-purchases-2').show();
                                show_rows(id);   
                            }
                        );
                    }
                    else if(type_link == 'linke') {
                        $(this).on('click',
                            function(e){
                                let id = $(this).attr('id');
                                e.preventDefault();

                                // $('#tbody-purchases-2').html('');
                                $('#table-purchases-2').hide();
                                $('#form-register-purchase').hide();

                                $('#table-purchases-3').show();

                                update_purchase(id.split('-')[1]);
                            }
                        );
                    }
                    else {
                        $(this).on('click',
                            function(e){
                                e.preventDefault();
                                let id = $(this).attr('id');
                                cancel_purchase(id.split('-')[1]);
                            }
                        );
                    }
                }
            );
        }
    );
}

function cancel_purchase(id){
    let title, msj, div_alert, div_error;

    div_alert = $('#div-alert-1');
    div_error = $('#alert-table-purchases-1');
    title = '¿Estás seguro que deseas Cancelar la Orden de Compra?';
    msj = 'Sí, Eliminala!';
    
    show_confirm_sweet(title, msj).then((result) => {
        if (result.isConfirmed) {
            data = {
                id:id,
            }
            $.ajax(
                {
                    url: 'purchase-cancel-action',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        div_alert.children().first().text('La compra se cancelo con exito');
                        div_alert.show();
                        div_error.hide();
                        update_table_purchases();
                        clear_details();
                        Swal.close();
                        $('html, body').animate({scrollTop:0}, 'slow');
                    },
                    beforeSend: function() {
                        show_charge_message();
                    },
                    error: function(xhr, status, error) {
                        div_error.children().first().text('La compra no se pudo cancelar');
                        div_error.show();
                        div_alert.hide();
                        Swal.close();
                        $('html, body').animate({scrollTop:0}, 'slow');
                    }
                }
            ).always(
                function(){
                    // clear_tables();
                    // $('#loading-spinner').hide();
                }
    
            );
        }
    });
}

function show_details (purchase, details, products) {
    let tbody, tr, td0, td1, td2, td3, td4, input1, input2, span1, span2;

    tbody = $('#tbody-purchases-2');
    
    if (details.length > 0) {
        
        $('#form-register-purchase').show();
        $('#alert-table-purchases-2').hide();

        for( let i = 0; i< details.length; i++){

            tr = $('<tr></tr>',{
                id:'trdetail-'+details[i]['id'],
            });

            td0 = $('<td></td>');
            td0.text(i+1);
            tr.append(td0);

            td1 = $('<td></td>');
            td1.text(get_object(products, details[i]['product_id'])['name']);
            tr.append(td1);

            td2 = $('<td></td>');
            td2.text(details[i]['quantity_ordered']);
            tr.append(td2);
            
            td3 = $('<td></td>');
            input1 = $('<input/>',{
                type:'number',
                id:'qty-'+details[i]['id'],
                value: details[i]['quantity_ordered'],
            })
            
            span1 = $('<span></span>', {
                id:"spqty-"+details[i]["id"],
                class:"error",
                'aria-live':"polite",
            })
            td3.append(input1);
            td3.append($('<br>'));
            td3.append(span1);
            tr.append(td3);
            

            td4 = $('<td></td>');
            input2 = $('<input/>',{
                type:'number',
                id:'price-'+details[i]['id'],
            })
            
            span2 = $('<span></span>', {
                id:"spprice-"+details[i]["id"],
                class:"error",
                'aria-live':"polite",
            })
            td4.append(input2);
            td4.append($('<br>'));
            td4.append(span2);
            tr.append(td4);
            
            tbody.append(tr);
            add_listener_control_quantity(input1.attr('id'));
            add_listener_control_price(input2.attr('id'));
        }
    }
    else {
        $('#form-register-purchase').hide();
        $('#alert-table-purchases-2').show();
    }
}

function clear_details(){
    $('#tbody-purchases-2').html('');
    $('#form-register-purchase').hide();
}

function carge_rows () {
    let rows, set_rows, row, tds, count;
    
    set_rows = {};
    count = 0;
    rows = $('#tbody-purchases-2').find('tr');
    rows.each(
        function () {
            let qty, price, span;
            tds = $(this).find('td');
            qty = tds.eq(3).children().first().val();
            span = tds.eq(3).find('span').first();
            console.log(span.hasClass('active'));

            row = {};
            row['id'] = $(this).attr('id').split('-')[1];
            if(qty != '' && !span.hasClass('active')){
                row['quantity_received'] = parseInt(qty);
            }
            else if(qty!=''){
                set_rows['error'] = true;
                return set_rows;
            }
            else {
                row['quantity_received'] = 0;
            }

            price = tds.eq(4).find('input').first().val();
            span = tds.eq(4).find('span').first();
            if(!span.hasClass('active') && price!=''){
                row['cost_price'] = parseFloat(price);
            }
            else if(!span.hasClass('active')){
                row['cost_price'] = 0;
            }
            else{
                set_rows['error'] = true;
                return set_rows;
            }

            set_rows[count] = row;
            count += 1;
        }
    );
    set_rows['qty'] = count;
    set_rows['total_paid'] = parseFloat($('#total-price-input').val());
    return set_rows;
}

function update_rows(){
    let option = $('#select-supplier').val();
    let data_filter = {};

    if ( option != '' ) {
        option = parseInt(option);
        data_filter = {
            'supplier_id' : option,
        }
    }

    $.ajax(
        {
            url: 'purchase-filter-async-purchases-register',
            type: 'GET',
            data: data_filter,
            success: function(response) {
                show_purchases(response.purchases, response.suppliers);
                carge_links();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        }
    );
}

function add_listener_control_quantity(id_input){
    let span = $('#spqty-'+id_input.split('-')[1]);
    let input = $('#'+id_input);
    input.on('input',
        function () {
            let val_split_dot = input.val().split('.');
            let val_split_comma = input.val().split(',');
            if (input.val() < 0  || val_split_dot.length > 1 || val_split_comma.length > 1 ){
                span.attr('class', 'error active');
                span.text('Cantidad no valida');
            }
            else {
                span.attr('class', 'error');
                span.text('');
            }
        }    
    );
}

function add_listener_control_price(id_input){
    let span = $('#spprice-'+id_input.split('-')[1]);
    let input = $('#'+id_input);
    input.on('input',
        function () {
            let val_split_dot = input.val().split('.');
            let val_split_comma = input.val().split(',');
            if (input.val() < 0 || val_split_dot.length > 2 || val_split_comma.length > 1){
                
                span.attr('class', 'error active');
                span.text('Precio no valido');
            }
            else {
                span.attr('class', 'error');
                span.text('');
            }
        }    
    );
}