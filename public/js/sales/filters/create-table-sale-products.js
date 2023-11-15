function carge_table(products, categories, suppliers) {
    if (products.length > 0) {
        $('#alert-table').hide();
        $('#table-products').show();
        let cadena = '';
        for (let product of products) {
            cadena += `
                <tr id='${"trproduct-"+product["id"]}'>
                    <td>${product["code"]}</td>
                    <td>${product["name"]}</td>
                    <td>${product["price"]}</td>
                    <td>
                    <input type="number" name='${"qty-"+product["id"] }' id='${"qty-"+product["id"] }'>
                    <span id='${"sp-"+product["id"] }' class="error" aria-live="polite"></span>
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