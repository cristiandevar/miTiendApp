function carge_table(products, categories, suppliers) {
    if (products.length > 0) {
        $('#alert-table').hide();
        $('#table-products').show();
        let cadena = '';
        // let td, tr, img, btn_show, btn_edit, btn_del;
        for (let product of products) {
            // tr = $('<tr></tr>');
            // td = $('<td></td>');

            // td.html(product["code"]);
            // tr.append(td);
            
            // td.html(product["name"]);
            // tr.append(td);
            
            // td.html(product["price"]);
            // tr.append(td);
            
            // td.html(product["stock"]);
            // tr.append(td);
            
            // td.html(get_object(categories,product["category_id"])["name"]);
            // tr.append(td);
            
            // td.html(get_object(suppliers,product["supplier_id"])["companyname"]);
            // tr.append(td);
            
            // img = $('<img></img>',{
            //     src:product['image']
            // })
            // td.append(img);
            // tr.append(td);

            // btn_show = $('<a></a>',{
                
            // });
            // td.html(product["code"]);
            // tr.append(td);



            // console.log(product);
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
        
        $('#btn-pdf-1').attr('disabled',false);
        $('#btn-excel-1').attr('disabled',false);
    }
    else {
        $('#btn-pdf-1').attr('disabled',true);
        $('#btn-excel-1').attr('disabled',true);
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