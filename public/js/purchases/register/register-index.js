document.addEventListener('DOMContentLoaded', 
    function (e) {
        let alert_1,alert_2,alert_3,alert_4, table_1, table_2;
        
        alert_1 = $('#div-alert-1');
        alert_2 = $('#div-error-1');
        alert_3 = $('#alert-table-purchases-1');

        table_1 = $('#table-purchases-1');

        alert_1.hide();
        alert_2.hide();
        alert_3.hide();

        $('#select-supplier').on('change',
        function ( e ) {
            update_table_purchases();

        }
    );

    }
);

function show_purchases(purchases, suppliers){

    let tbody, tr, td0, td1, td2, td3, a1, a2, a3, i1, i2, i3, input1, input2, span1, span2;

    tbody = $('#tbody-purchases-1');
    tbody.html('');;
    if(purchases.length > 0){
        
        $('#alert-table-purchases-1').hide();
        $('#table-purchases-1').show();

        for (let purchase of purchases) {

            tr = $('<tr></tr>',{
                id:"trpurchase-"+purchase["id"],
            });

            td0 = $('<td></td>');
            td0.text(purchase["id"]);
            tr.append(td0);

            td1 = $('<td></td>');
            td1.text(get_object(suppliers,purchase["supplier_id"])['companyname']);
            tr.append(td1);

            td2 = $('<td></td>');
            td2.text(get_time(purchase["created_at"]));
            tr.append(td2);
            
            td3 = $('<td></td>');

            a1 = $('<a></a>',{
                id:'linkr-'+purchase["id"],
                href:'#',
                title: 'Registrar compra'
            })
            i1 = $('<i></i>',{
                class:'fas fa-check-square',
                style:'color: #05ff37;',
            })
            a1.append(i1);
            td3.append(a1);

            a2 = $('<a></a>',{
                id:'linke-'+purchase["id"],
                href:'#',
                title: 'Modificar compra'
            })
            i2 = $('<i></i>',{
                class:'fas fa-pen-square',
                style:'color: #e2dc12;margin:3px;',
            })
            a2.append(i2);
            td3.append(a2);
            
            a3 = $('<a></a>',{
                id:'linkd-'+purchase["id"],
                href:'#',
                title: 'Cancelar compra'
            })
            i3 = $('<i></i>',{
                class:'fas fa-window-close',
                style:'color: #ff0000;;',
            })
            a3.append(i3);
            td3.append(a3);

            tr.append(td3);

            tbody.append(tr);
        }
    }
    else {
        $('#form-register-purchase').hide();
        $('#alert-table-purchases-2').show();
    }
}

function get_object(list_object, id){
    let i = 0;
    while ( i<list_object.length && list_object[i]['id'] != id) {
        i+=1;
    }
    if ( i<list_object.length ) {
        return list_object[i];
    }
    else {
        return null;
    }
}

function get_time(string_date){
    let new_date = new Date(string_date);
    let options = { day: 'numeric', month: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', timeZone: 'America/Argentina/Salta' };
    let formated_date = new_date.toLocaleDateString('es-AR', options).replace(',', '');

    return formated_date;
}

function update_table_purchases(){
    let option = $('#select-supplier').val();
    let data_filter = {};

    if ( option != '' ) {
        option = parseInt(option);
        data_filter = {
            'supplier_id' : option
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
                // console.log(option);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        }
    );
}