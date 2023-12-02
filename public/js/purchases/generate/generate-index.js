
$.ajaxSetup(
    {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
);


document.addEventListener('DOMContentLoaded', 
    function (e) {
        let alert_1,alert_2,alert_3,alert_4, table_1, table_2;
        let div_alert,div_error;
        
        alert_1 = $('#div-alert-1');
        alert_2 = $('#div-error-1');
        alert_3 = $('#alert-table-purchase');
        alert_4 = $('#alert-table-options');

        table_1 = $('#table-purchase');

        alert_1.hide();
        alert_2.hide();
        alert_3.hide();
        alert_4.hide();

        
        div_alert = $('#div-alert-1');
        div_error = $('#div-error-1');
        // $('#loading-spinner').hide();
        $('#add-purchase').on('click',
            function (e) {
                e.preventDefault();
                let data = carge_rows();

                if (Object.keys(data).length > 1) {
                    // $('#loading-spinner').show();
                    let title, msj;
                    title = '¿Estás seguro que deseas Generar la Orden de Compra?';
                    msj = 'Sí, Generala!';
                    show_confirm_sweet(title, msj).then((result) => {
                        if (result.isConfirmed) {
                                
                            $.ajax(
                                {
                                    url: 'purchase-generate-action',
                                    type: 'POST',
                                    data: data,
                                    success: function(response) {
                                        div_alert.children().first().text('La compra se genero con exito');
                                        div_alert.show();
                                        div_error.hide();
                                        console.log(response);
                                        
                                        Swal.close();
                                        title = '¿Desea descargar comprobante de Orden Generada?'
                                        show_yes_no_sweet(title).then((result) =>{
                                            if (result.isConfirmed) { 
                                                let input, action;
                                                // action = $('#form-voucher').preventDefault();
                                                // input = $('#purchase_id');
                                                show_charge_message();
                                                let ids = response.purchases

                                                // ids.forEach(
                                                //     function(id) {
                                                //         var xhr = new XMLHttpRequest();
                                                //         xhr.open('GET', '/purchase/voucher/?id=' + id);
                                                
                                                //         xhr.onload = function() {
                                                //             // Continuar con el ciclo cuando se reciba la respuesta de la petición AJAX
                                                            
                                                //         };
                                            
                                                //         xhr.send();
                                                //     }
                                                // );

                                                // ids.forEach(function(id) {
                                                //     var xhr = new XMLHttpRequest();
                                                //     xhr.open('GET', '/panel/purchase/voucher/' + id);
                                            
                                                //     xhr.onload = function() {
                                                //         if (xhr.status === 200) {
                                                //             // Continuar con el ciclo cuando se reciba la respuesta de la petición AJAX
                                                            
                                                //         }
                                                //     };
                                            
                                                //     xhr.send();
                                                // });
                                                for (let i = 0; i < response.purchases.length; i++){
                                                    // input.val(response.purchases[i]);
                                                    input = $('<input>',{
                                                        name:i,
                                                        type:'hidden',
                                                        value: ids[i]
                                                    })
                                                    $('#form-voucher').append(input);
                                                    // $('#form-voucher').submit();
                                                    // console.log('Entro con id:', response.purchases[i]);
                                                }
                                                
                                                $('#form-voucher').submit();
                                                Swal.close();
                                                // return true;
            
                                            }
                                        }); 
                                        

                                        $('html, body').animate({scrollTop:0}, 'slow');
                                    },
                                    beforeSend: function() {
                                        show_charge_message();
                                    },
                                    error: function(xhr, status, error) {
                                        div_error.children().first().text('La compra no se pudo registrar');
                                        div_error.show();
                                        div_alert.hide();
                                        console.error(error);
                                        
                                        Swal.close();
                                        $('html, body').animate({scrollTop:0}, 'slow');
                                    }
                                }
                            ).always(
                                function(){
                                    clear_tables();
                                    // $('#loading-spinner').hide();
                                }
                    
                            );
                        }
                    });
                }
                else {
                    let error = $('#alert-table-purchase');
                    error.show();
                    error.find('p').first().text('Debe agregar primero un producto');
                    // div_error.show();
                    // div_alert.hide();
                    div_error.children().first().find('p').first().text('Debe agregar al menos un producto');
                    
                    $('html, body').animate({scrollTop:error.offset().top}, 'slow');
                            
                }

            }
        );

        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Detener el comportamiento predeterminado del formulario
        
            var ids = [1, 2, 3]; // IDs de órdenes a descargar
        
            ids.forEach(function(id) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/descargar_pdf?id=' + id);
        
                xhr.onload = function() {
                    // Continuar con el ciclo cuando se reciba la respuesta de la petición AJAX
                };
        
                xhr.send();
            });
        });

    }
);

function carge_rows () {
    let rows, set_rows, row, tds, count, supplier;
    
    set_rows = {};
    
    count = 0;
    rows = $('#tbody-purchase').find('tr');
    rows.each(
        function () {
            row = {};
            tds = $(this).find('td');
            row['product_id'] = $(this).attr('id').split('-')[1];
            row['quantity'] = tds.eq(4).text();

            set_rows[count] = row;
            count += 1;
        }
    );
    set_rows['qty'] = count;
    return set_rows;
}

function clear_tables(){
    $('#tbody-purchase').html('');
}

function show_charge_message(){
    Swal.fire({
        title: 'Cargando...',
        allowOutsideClick: false,
        showConfirmButton: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    });
}