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
                    <td>${categories[product["category_id"]-1]["name"]}</td>
                    <td>${suppliers[product["supplier_id"]-1]["companyname"]}</td>
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