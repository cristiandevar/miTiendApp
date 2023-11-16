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
