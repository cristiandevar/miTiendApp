document.addEventListener('DOMContentLoaded', 
    function (e) {
        let alert_1,alert_2,alert_3,alert_4, table_1, table_2;
        
        alert_1 = $('#div-alert-1');
        alert_2 = $('#div-error-1');
        alert_3 = $('#alert-table-purchases-1');
        // alert_4 = $('#alert-table-options');

        table_1 = $('#table-purchases-1');
        // table_2 = $('#table-options-1');

        alert_1.hide();
        alert_2.hide();
        alert_3.hide();
        // alert_4.hide();

        // table_2.hide();
        $('#select-supplier').on('change',
        function ( e ) {
            let option = $(this).val();
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
    );

    }
);

function show_purchases(purchases, suppliers){

    if(purchases.length > 0){
        $('#alert-table-purchases-1').hide();
        $('#table-purchases-1').show();
        let cadena = '';
        for (let purchase of purchases) {
            cadena += `
                <tr id='${"trpurchase-"+purchase["id"]}'>
                    <td>${purchase["id"]}</td>
                    <td>${get_object(suppliers,purchase["supplier_id"])['companyname']}</td>
                    <td>${get_time(purchase["created_at"])}</td>
                    <td><a href='#'>Registrar</></td>
                </tr>
            `;
        }
        $('#tbody-purchases-1').html(cadena);
    }
    else {
        $('#alert-table-purchases-1').show();
        $('#table-purchases-1').hide();
    }
}
function get_object(list_object, id){
    let i = 0;
    // console.log(list_object);
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