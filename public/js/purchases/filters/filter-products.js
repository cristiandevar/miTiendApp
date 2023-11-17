document.addEventListener('DOMContentLoaded', function (e) {
    
    $('#alert-table-options').hide();

    $('#select-supplier').on('change',
        function ( e ) {
            let option = $(this).val();
            let data_filter = {};

            if ( option != '' ) {
                option = parseInt(option);
                data_filter = {
                    'supplier_id' : option,
                    'code': $('#input-code-1').val(),
                    'name': $('#input-name-1').val(),
                }
            }

            $.ajax(
                {
                    url: 'purchase-filter-async-products',
                    type: 'GET',
                    data: data_filter,
                    success: function(response) {
                        show_products(response.products, response.categories, response.suppliers);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                }
            );
        }
    );

    $('#input-code-1').on('input', function (e) {
        e.preventDefault();
        // var values = carge_values('form-filter');
        console.log($(this).val());
        let data_filter = {
            code: $(this).val(),
            supplier_id:$('#select-supplier').val(),
            name: $('#input-name-1').val(),
        };
        $.ajax({
                url: 'purchase-filter-async-products',
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

    $('#input-name-1').on('input', function (e) {
        e.preventDefault();
        // var values = carge_values('form-filter');
        console.log($(this).val());
        let data_filter = {
            name: $(this).val(),
            supplier_id:$('#select-supplier').val(),
            code: $('#input-code-1').val(),
        };
        $.ajax({
                url: 'purchase-filter-async-products',
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
                    <td><input type='number'/></td>
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