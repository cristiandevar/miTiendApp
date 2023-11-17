function carge_table(products, categories, suppliers) {
    if (products.length > 0) {
        $('#alert-table').hide();
        $('#table-products').show();
        let cadena = '';
        for (let product of products) {
            cadena += `
                <tr>
                    <td>${product["code"]}</td>
                    <td>${product["name"]}</td>
                    <td>${product["price"]}</td>
                    <td>${product["stock"]}</td>
                    <td>${get_object(categories,product["category_id"])["name"]}</td>
                    <td>${get_object(suppliers,product["supplier_id"])["companyname"]}</td>
                    <td>
                        <img src="${product["image"]}" alt="${product["name"]}" class="img-fluid" style="width: 150px;">
                    </td>
                </tr>
            `;
        }
        $('#tbody-products').html(cadena);
    }
    else {
        $('#alert-table').show();
        $('#table-products').hide();
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