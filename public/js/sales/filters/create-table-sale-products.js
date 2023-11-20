function carge_table(products, categories, suppliers) {
    if (products.length > 0) {
        $('#alert-table').hide();
        $('#table-products').show();
        $('#tbody-products').html('');
        // let cadena = '';
        for (let product of products) {
            carge_product(product);
        }
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

function carge_product(product){
    let tr, td1, td2, td3, td4, input, span;

    tr = $('<tr></tr');
    tr.attr('id', "trproduct-"+product['id']);

    td1 = $('<td></td>');
    td1.text(product['code']);
    tr.append(td1);

    td2 = $('<td></td>');
    td2.text(product['name']);
    tr.append(td2);

    td3 = $('<td></td>');
    td3.text(product['price']);
    tr.append(td3);
    
    td4 = $('<td></td>');
    input = $('<input/>', {
        type: 'number',
        id: "qty-"+product["id"],
        name:"qty-"+product["id"],
    });
    td4.append(input);
    span = $('<span></span>', {
        id:"sp-"+product["id"],
        class:"error",
        'aria-live':"polite",
    })
    td4.append(span);
    tr.append(td4);
    
    $('#tbody-products').append(tr);
    addListener("qty-"+product["id"]);
    
}