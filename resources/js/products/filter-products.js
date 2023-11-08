import 'create-table-products.js';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}
);
document.addEventListener('DOMContentLoaded', function (e) {
// $('#form-update').hide();
// $('#body-table-products').html(`
//     @foreach ($products as $product)
//         <tr>
//             <td>{{ $product->id }}</td>
//             <td>{{ $product->name }}</td>
//             <td>{{ $product->price }}</td>
//             <td>{{ $product->category->name }}</td>
//             <td>{{ $product->supplier->companyname }}</td>
//             <td>
//                 <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid" style="width: 150px;">
//             </td>
//         </tr>
//     @endforeach
// `);
$('#btn-filter-1').on('click', function (e) {
    e.preventDefault();
    var my_array;
    var values = carge_values('form-filter');
    // var $inputs_form_filter = $('#form-filter :input')
    // var values = {};
    // var miArray;
    // $inputs_form_filter.each(function() {
    //     values[this.name] = $(this).val();
    // });

    var data_filter = {
        name : values['name'],
        supplier_id : values['supplier_id'],
        category_id : values['category_id'],
        date_since : values['date_since'],
        date_to : values['date_to'],
    }
    $.ajax({
            url: 'products-filter-price-async',
            type: 'GET',
            data: data_filter,
            success: function(response) {
                // console.log(response);
                // $('#form-update').show();
                // try{
                //     my_array = JSON.parse(decodeURIComponent(response.products));
                // }
                // catch (e) {
                    // console.log('Error al leer el array products');
                // }
                carge_table(response.products, response.categories, response.suppliers);
                
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        }
    );

});