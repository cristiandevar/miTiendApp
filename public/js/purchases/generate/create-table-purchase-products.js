function carge_table_purchase(products) {
    if (products.length > 0) {
        $('#alert-table-purchase').hide();
        $('#table-purchase').show();
        let cadena = '';
        for (let product of products) {
            cadena += `
                <tr id='${"trproduct-"+product["id"]}'>
                    <td>${product["code"]}</td>
                    <td>${product["name"]}</td>
                    <td>${get_object(suppliers, product['supplier_id'])['companyname']}</td>
                    <td>${product["stock"]}</td>
                    <td>${product["minstock"] - product["stock"]}</td>
                    <td>
                        <a></a>
                        <a></a>
                        <a></a>
                    </td>
                </tr>
            `;
        }
        $('#tbody-purchase').html(cadena);
    }
    else {
        $('#alert-table-purchase').show();
        $('#table-purchase').hide();
    }
}

function carge_values(id) {
    let values= {};
    let $inputs_form = $("#" + id + " :input");
    $inputs_form.each(function() {
            values[this.name] = $(this).val();
    });
    return values;
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
