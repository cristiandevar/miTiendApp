document.addEventListener('DOMContentLoaded', function (e) {
    
    $('#alert-table').hide();
    $('#input-code-1').on('change', function (e) {
        e.preventDefault();
        // var values = carge_values('form-filter');
        console.log($(this).val());
        let data_filter = {
            code: $(this).val(),
        };

        // data_filter = {
        //     code : values['code'],
        //     name : values['name'],
        //     supplier_id : values['supplier_id'],
        //     category_id : values['category_id'],
        //     price_since : values['price_since'],
        //     price_to : values['price_to'],
        //     date_since : values['date_since'],
        //     date_to : values['date_to'],
        // }
        $.ajax({
                url: 'purchase-filter-code-async',
                type: 'GET',
                data: data_filter,
                success: function(response) {
                    console.log(response.products.length);
                    show_products(response.products);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            }
        );

    });
});

function show_products(products){
    if(products.length>0){
        $('#alert-table-options').hide();
        $('#table-options-1').show();
        let cadena = '';
        for (let product of products) {
            cadena += `
                <tr id='${"trproduct-"+product["id"]}'>
                    <td>${product["code"]}</td>
                    <td>${product["name"]}</td>
                    <td>${product["stock"]}</td>
                    <td>${product["minstock"]}</td>
                    <td>${Math.max(product["minstock"], product["minstock"] - product["stock"])}</td>
                    <td>
                        <a href='#' id="link-${product["id"]}"><i class="fas fa-check" style="color: #00ff1e;"></i></a>
                        <a></a>
                        <a></a>
                    </td>
                </tr>
            `;
        }
        $('#tbody-options').html(cadena);
    }
    else {
        $('#alert-table-options').show();
        $('#table-options-1').hide();
    }
}