$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}
);

document.addEventListener('DOMContentLoaded',
    function () {
        $('#percentage').on('input',
            function () {
                let span;
                let value = parseFloat($(this).val());
                let input = document.getElementById('percentage');
                input.setAttribute('max',100);
                input.setAttribute('min',-100);
                span = document.getElementById('sp-percentage');
                        
                if (!input.validity.valid) {
                    if(value > 100){
                        span.textContent = "El valor es muy alto";
                    }
                    else if (value < -100){
                        span.textContent = "El valor es muy bajo";    
                    }
                    else {
                        span.textContent = "El valor no es válido";
                    }
                    span.className = "error active"
                }
                else {
                    span.innerHTML = "";
                    span.className = "error";
                }
            }
        );

        
        $('#price').on('input',
            function () {
                let span;
                let value = parseFloat($(this).val());
                let input = document.getElementById('price');
                // input.setAttribute('max',100);
                input.setAttribute('min',1);
                span = document.getElementById('sp-price');
                        
                if (!input.validity.valid) {
                    if (value <= 0){
                        span.textContent = "El valor es muy bajo";    
                    }
                    else {
                        span.textContent = "El valor no es válido";
                    }
                    span.className = "error active"
                }
                else {
                    span.innerHTML = "";
                    span.className = "error";
                }
            }
        );
    }
);

$('#btn-update-1').on('click', function(e) {
    e.preventDefault();
    var values_filter;
    var data_filter;
    var values_update = carge_values('form-update');

    if ((values_update['percentage'] !== '' && values_update['percentage'] !== '0' && !$('#sp-percentage').hasClass('active')) || (values_update['price'] !== '' && values_update['price'] !== '0' && !$('#sp-price').hasClass('active')) ) {
        Swal.fire({
            title: '¿Estás seguro que deseas Actualizar?',
            text: "No podrás recuperar los datos después de Actualizarlos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Actualizalos!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                values_filter = carge_values('form-filter');
                if(values_update['percentage'] !== ''){
                    values_update['price'] = 0;
                }
                else{
                    values_update['percentage'] = 0;
                }
                // console.log(values_update);
                data_filter = {
                    percentage : values_update['percentage'],
                    price : values_update['price'],
                    name : values_filter['name'],
                    supplier_id : values_filter['supplier_id'],
                    category_id : values_filter['category_id'],
                    date_since : values_filter['date_since'],
                    date_to : values_filter['date_to'],
                    order_by_1 : values_filter['order_by_1'],
                    order_by_2 : values_filter['order_by_2'],
                }
        
                $.ajax({
                        url: 'products-filter-price-update-async',
                        type: 'POST',
                        data: data_filter,
                        success: function(response) {
                            console.log(response);
                            carge_table(response.products, response.categories, response.suppliers);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    }
                );
            }
        });
        
    }
});
