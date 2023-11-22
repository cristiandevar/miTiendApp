function  update_purchase(id){
    $('#alert-table-purchases-3').hide();

    let data = {
        id:id,
    }
    $.ajax(
        {
            url: 'purchase-filter-async',
            type: 'GET',
            data: data,
            success: function(response) {
                $('#table-purchases-3').show();
                $('#form-update-purchase').show();
                carge_purchase(response.purchase, response.details, response.products, response.suppliers);
                let btn = $('#update-purchase').offset().top;
                $('html, body').animate({scrollTop:btn}, 'slow');
                    

            },
            error: function(xhr, status, error) {
                console.error('Todo mal');
                $('#table-purchases-3').hide();
                $('#form-update-purchase').hide();
                $('#alert-table-purchases-3').show();
                
                $('#alert-table-purchases-3').children().first().text('Problemas al leer la compra');
            }
        }
    );
    
}

function carge_purchase(purchase, details, products, suppliers){
    let tbody, tr, td, td0, td1, td2, td3, input, span, select, option, a, ic;
    let this_supplier = get_object(suppliers, purchase['supplier_id']);
    let this_products = get_products(products, this_supplier);
    tbody = $('#tbody-purchases-3');
    $('#table-purchases-3 thead').first().attr('id',purchase['id']);
    clean_details();
    if(details.length > 0){
        let count = 0;
        for(let detail of details){
            let product = get_object(this_products, detail['product_id']);
            
            tr = $('<tr></tr>',{
                id:'trdetail-'+product['id'],
            });

            td0 = $('<td></td>');
            a = $('<a></a>',{
                href:'#',
                id:'linkdel-'+product['id'],
            })
            a.on('click', 
                function(e) {
                    e.preventDefault();
                    remove_row('trdetail-'+product['id']);
                }
            );
            ic = $('<i></i>',{
                class:'fas fa-trash-alt',
            })
            a.append(ic);
            td0.append(a);
            tr.append(td0);

            td1 = $('<td></td>');
            td1.text(product['name']);
            tr.append(td1);

            td2 = $('<td></td>')
            td2.text(product['stock']);
            tr.append(td2);

            td3 = $('<td></td>');
            input = $('<input/>',{
                id:'qtyupdate-'+product['id'],
                type:'number',
            })
            span = $('<span></span>', {
                id:"spqty-"+product["id"],
                class:"error",
                'aria-live':"polite",
            })
            input.val(detail['quantity_ordered']);
            td3.append(input);
            td3.append($('<br>'));
            td3.append(span);
            tr.append(td3);

            tbody.append(tr);
            count += 1;
        }
    }
    else{
        $('#alert-table-purchases-3').show();
        $('#alert-table-purchases-3').text('No posee detalles');
    }
    let option_product = products_no_selected(this_products);
    
    tr = $('<tr></tr>',{
        id:'tradddetail',
    });
    td = $('<td></td>');
    a = $('<a></a>',{
        id:'linkadd',
        href:'#',
        title:'Agrega otro producto'
    });
    a.on('click',
        function(e){
            e.preventDefault();
            let option_product_2 = products_no_selected(this_products);
            if(option_product_2.length > 0){
                add_row(this_products);
                $(this).hide();
            }
        }
    );
    ic = $('<i></i>',{
        class:'fas fa-plus-square',
        style:'color: #37ff00;',
    });
    a.append(ic);
    td.append(a);
    tr.append(td);
    tbody.append(tr);
    
    if(option_product.length <= 0){
        $('#tradddetail').hide();
    }
    else{
        $('#tradddetail').show();
    }
}

function get_products(products,supplier){
    let set_products = []
    // let count = 0;
    for(let product of products){
        if (product['supplier_id'] == supplier['id']) {
            set_products.push(product);
            // count += 1;
        }
    }
    // set_products['count'] = count;
    return set_products;
}

function clean_details(){
    $('#tbody-purchases-3').html('');
}

function update_row(id){
    $('#tbody-purchases-3').find('#'+id);
}

function products_no_selected(products){
    let tbody, trows, trow, set_products;
    tbody = $('#tbody-purchases-3');
    trows = tbody.find('tr');
    set_products = [];
    for (let product of products) {
        trow = tbody.find('#trdetail-'+product['id']);
        if(trow['length'] == 0){
            set_products.push(product);
        }

    }
    return set_products;
}

function add_row(this_products){
    let products = products_no_selected(this_products);
    // $('#alert-table-purchases-3').hide();
    $('#alert-table-purchases-4').hide();
    if(products.length > 0){
        let tr, td0, td1, td2, td3, td4, select, option, input, span, tbody;
        tbody = $('#tbody-purchases-3');
        
        tr = $('<tr></tr>',{
                id:'trdetail-',
        });
        td0 = $('<td></td>');
        a = $('<a></a>',{
            href:'#',
            id:'linkadd-',
        })
        a.on('click',
            function(e){
                e.preventDefault();
                if(is_valid_detail()){
                    create_row(products);
                    option_product = products_no_selected(this_products);
                    // $('#alert-table-purchases-3').hide();
                    $('#alert-table-purchases-4').hide();
                    if(option_product.length > 0){
                        $('#linkadd').show();
                    }
                    else{
                        $('#linkadd').hide();
                    }
                }
                else{
                    // $('#alert-table-purchases-3 p').first().text('Debe ');
                    $('#alert-table-purchases-4').show();
                    // $('#trdetail-').remove();
                }
            }
        );
        ic = $('<i></i>',{
            class:'fas fa-check-square',
            style:'color: #05ff37;',
        })
        a.append(ic);
        td0.append(a);
        tr.append(td0);

        td1 = $('<td></td>');
        select = $('<select></select>',{
            id:'product-',
        })
        select.on('change',
            function(){
                show_stock(products);
            }
        );
        option = $('<option></option>',{
            value:'',
        });
        option.text('Producto...');
        select.append(option);

        for(let p of products){
            option = $('<option></option>',{
                value:p['id'],
            })
            option.text(p['name']);
            select.append(option);
        }
        td1.append(select);
        tr.append(td1);

        td2 = $('<td></td>');
        tr.append(td2);

        td3 = $('<td></td>');
        input = $('<input/>',{
            id:'qtyupdate-',
            type:'number',
        })
        span = $('<span></span>', {
            id:"spqty-",
            class:"error",
            'aria-live':"polite",
        })
        td3.append(input);
        td3.append($('<br>'));
        td3.append(span);
        tr.append(td3);

        tbody.append(tr);
    }
    else{
        console.log('No se pueden agregar mas productos');
    }
}

function is_valid_detail(){
    let row, valid, input, msj, select;
    row = $('#trdetail-');
    valid = true;
    select = row.find('#product-').val();
    input = row.find('#qtyupdate-').val();
    msj = '';


    if( select == ''){
        msj += 'Debe elegir producto'; 
        valid = false;
    }
    if(input == '' || input <= 0){
        msj += 'Debe ingresar una cantidad válida';
        valid = false;
    }

    if(!valid){
        $('#alert-table-purchases-4').children().first().text(msj);
        $('#alert-table-purchases-4').show();
    }

    return valid;
}

function show_stock(products){
    let tds = $('#trdetail-').find('td');
    let select = $('#product-');
    if(select.val() == ''){
        tds.eq(2).text('');
    }
    else {
        for(let p of products){
            if(p['id'] == select.val()){
                tds.eq(2).text(p['stock']);
                break;
            }
        }
    }
}

function create_row(products){
    let row, tr, td0, a, ic, select, input;
    row = $('#trdetail-');
    tds = row.find('td');
    select = $('#product-').val();
    option = get_object(products, select)['name'];
    input = $('#qtyupdate-');
    span = $('#spqty-');

    a = $('<a></a>',{
        href:'#',
        id:'linkdel-'+select,
    })
    a.on('click',
        function(e){
            e.preventDefault();
            remove_row('trdetail-'+select);
        }
    );
    ic = $('<i></i>',{
        class:'fas fa-trash-alt',
    })
    a.append(ic);
    tds.eq(0).html('');
    tds.eq(0).append(a);

    row.attr('id', 'trdetail-'+select);
    tds.eq(1).html('');
    tds.eq(1).text(option);

    input.attr('id','qtyupdate-'+select);
    span.attr('id','spqty-'+select);

    row.insertBefore('#tradddetail');
    
    

}

function remove_row(id){
    if($('#tradddetail').is(':hidden')){
        $('#linkadd').show();
        $('#tradddetail').show();
    }
    $('#'+id).remove();
}