document.addEventListener('DOMContentLoaded', function (e) {
    
    $('#alert-table-options').hide();

    $('#code').on('input', 
        function (e) {
            e.preventDefault();
            call_filter();
        }
    );
    $('#name').on('input', 
        function (e) {
            e.preventDefault();
            call_filter();
        }
    );
    $('#stock_since').on('input', 
        function (e) {
            e.preventDefault();
            call_filter();
        }
    );
    $('#stock_to').on('input', 
        function (e) {
            e.preventDefault();
            call_filter();
        }
    );
    $('#order-by-1').on('input', 
        function (e) {
            e.preventDefault();
            call_filter();
        }
    );
    $('#order-by-2').on('input', 
        function (e) {
            e.preventDefault();
            call_filter();
        }
    );
    $('#select-supplier').on('input', 
        function (e) {
            e.preventDefault();
            call_filter();
        }
    );
});

function show_products(products, suppliers){
    // console.log(products);
    if(products.length>0){
        $('#alert-table-options').hide();
        $('#table-options-1').show();
        let cadena = '';
        for (let product of products) {
            cadena += `
                <tr id='${"trproduct-"+product["id"]}'>
                    <td>${product["code"]}</td>
                    <td>${product["name"]}</td>
                    <td>${get_object(suppliers, product['supplier_id'])['companyname']}</td>
                    <td>${product["stock"]}</td>
                    <td>
                        <input id='qty-${product['id'] }' type='number'/><br>
                        <span id='sp-${product['id'] }' class="error" aria-live="polite"></span>
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

function call_filter(){
    var values = carge_filter('fields-filter');
    // console.log(values)
    var data_filter = {
        code : values['code'],
        name : values['name'],
        price_since : values['price_since'],
        price_to : values['price_to'],
        supplier_id : values['supplier_id'],
        stock_since : values['stock_since'],
        stock_to : values['stock_to'],
        category_id : values['category_id'],
        order_by_1 : values['order_by_1'],
        order_by_2 : values['order_by_2'],
    }
    $.ajax({
            url: 'products-filter-async',
            type: 'GET',
            data: data_filter,
            success: function(response) {
                $('#alert-table-options').hide();
                $('#table-options-1').show();
                show_products(response.products, response.suppliers);
                rows = $("#tbody-options tr");
                rows.each(
                    function () {
                        let id = $(this).attr('id').split("-")[1];
                        $(this).find('input[type=number]').each(
                            function(){

                                add_listener($(this).attr('id'));
                            }
                        )
                    }
                );

            },
            error: function(xhr, status, error) {
                $('#alert-table-options').show();
                $('#table-options-1').hide();
                console.error(error);
            }
        }
    );
}

function carge_filter(id){
    let values= {};
    let $inputs_form = $("#" + id + " :input");
    $('#fields-filter').find('input, select').each(function() {
        values[$(this).attr('name')] = $(this).val();
    });
    return values;
}
