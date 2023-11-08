function carge_table(products, categories, suppliers) {
    let div;
    if (products.length > 0) {
        div = document.getElementById('card-table');
        let cadena=`
        <table id="table-products" class="table table-striped table-hover w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-uppercase">Nombre</th>
                    <th scope="col" class="text-uppercase">Precio</th>
                    <th scope="col" class="text-uppercase">Categoría</th>
                    <th scope="col" class="text-uppercase">Proveedor</th>
                    <th scope="col" class="text-uppercase">Imagen</th>
                </tr>
            </thead>
            <tbody id="body-table-products">
        `;
        for (let product of products) {
            console.log(product);
            cadena += `
                <tr>
                    <td>${product["id"]}</td>
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
        cadena += `
                </tbody>
            </table>
        `;
        div.innerHTML = cadena;
    }
    else {
        div = document.getElementById('card-table');
        div.innerHTML = `<p class='alert alert-danger small'>Ningun producto coincide</p>`;
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