document.addEventListener('DOMContentLoaded',
    function () {
        $('#alert-table-purchases-2').hide();
        $('#alert-table-purchases-3').hide();
        $('#alert-table-purchases-4').hide();

        $('#table-purchases-3').hide();
        $('#form-update-purchase').hide()

        
        $('#update-purchase').on('click',
            function(e){
                e.preventDefault();
                let title, msj, data, div_error_1, div_alert_1;

                title = '¿Esta seguro de modificar la Orden de Compra?'
                msj = '¡Si, Modificala!';

                // $('#alert-table-purchases-2').hide();
                $('#alert-table-purchases-3').hide();

                div_alert_1 = $('#div-alert-1');
                div_error_1 = $('#div-error-1');
                // $('#table-purchases-2').hide();
                // $('#tbody-purchases-2').html('');


                if(can_update()){
                    
                    show_confirm_sweet(title, msj).then((result) => {
                        if (result.isConfirmed) {
                            data = {}
                            $('#tbody-purchases-3 tr').last().first().remove();
                            let rows = $('#tbody-purchases-3 tr');
                            let count = 0;
                            rows.each(
                                function(){
                                    data[count] = {}
                                    let tds = $(this).find('td');
                                    data[count]['product_id'] = $(this).attr('id').split('-')[1];
                                    data[count]['quantity_ordered'] = tds.eq(3).children().first().val();
                                    count += 1;
                                }
                            );
                            data['purchase_id'] = $('#table-purchases-3 thead').first().attr('id');
                            data['qty'] = count;

                            $.ajax(
                                {
                                    url: 'purchase-update-action',
                                    type: 'POST',
                                    data: data,
                                    success: function(response) {
                                        if(response.msg){
                                            div_alert_1.children().first().text(response.msg);
                                            div_alert_1.show();
                                            div_error_1.hide();
                                            $('#table-purchases-3').hide();
                                            $('#form-update-purchase').hide();
                                            $('#tbody-purchases-3').html('');
                                            update_table_purchases();
                                            if(response.error){
                                                div_error_1.children().first().text(response.error);
                                                div_error_1.show();
                                            }
                                        }
                                        else if (response.error){
                                            div_error_1.children().first().text(response.error);
                                            div_error_1.show();
                                            div_alert_1.hide();
                                        }
                                        Swal.close();
                                        // let btn = $('#select-supplier').offset().top;
                                        $('html, body').animate({scrollTop:0}, 'slow');
                 
                                        // carge_purchase(response.purchase, response.details, response.products, response.suppliers);
                                    },
                                    beforeSend: function() {
                                        show_charge_message();
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Ocurrio un error al actualizar la orden');
                                        $('#table-purchases-3').hide();
                                        $('#form-update-purchase').hide();
                                        $('#alert-table-purchases-3').show();
                                        $('#alert-table-purchases-3').children().first().text('Problemas al actualizar la compra');
                                        update_table_purchases();
                                        Swal.close();
                                        // let btn = $('#select-supplier').offset().top;
                                        $('html, body').animate({scrollTop:0}, 'slow');
                     
                                    }
                                }
                            );
                        }
                    });
                }
                else {
                    if($('#tbody-purchases-3 tr').length == 1){
                        title = 'Al no tener detalles se Cancelará la compra, ¿Esta seguro de proceder?'
                        msj = '¡Si, Cancelala!';
                        
                        show_confirm_sweet(title, msj).then((result) => {
                            if (result.isConfirmed) {
                                let data = {
                                    id:$('#table-purchases-3 thead').first().attr('id'),
                                }
                                $.ajax(
                                    {
                                        url: 'purchase-cancel-action',
                                        type: 'POST',
                                        data: data,
                                        success: function(response) {
                                            $('#table-purchases-3').hide();
                                            $('#form-update-purchase').hide();
                                            $('#tbody-purchases-3').html('');
                                            update_table_purchases();
                                            Swal.close();
                                            let btn = $('#select-supplier').offset().top;
                                            $('html, body').animate({scrollTop:btn}, 'slow');
                     

                                            // carge_purchase(response.purchase, response.details, response.products, response.suppliers);
                                        },
                                        beforeSend: function() {
                                            show_charge_message();
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Ocurrio un error al actualizar la orden');
                                            $('#table-purchases-3').hide();
                                            $('#form-update-purchase').hide();
                                            $('#alert-table-purchases-3').show();
                                            $('#alert-table-purchases-3').children().first().text('Problemas al actualizar la compra');
                                            update_table_purchases(); 
                                            Swal.close();                                           
                                            let btn = $('#select-supplier').offset().top;
                                            $('html, body').animate({scrollTop:btn}, 'slow');
                                        }
                                    }
                                );
                            }
                        });
                    }
                    else{
                        let msj_error='';
                        if($('#trdetail-').length == 1){
                            msj_error = 'Debe terminar de agregar el producto';
                        }
                        else{
                            msj_error = 'Debe ingresar cantidades validas'
                        }
                        $('#alert-table-purchases-3').children().first().text(msj_error);
                        $('#alert-table-purchases-3').show();
                    }
                    
                }
            }
        );
    }

);

function can_update(){
    let can;
    can = true;
    if($('#trdetail-').length == 1){
        can = false;
    }

    $('#tbody-purchases-3 input').each(
        function(){
            input = $(this).val();
            
            if(input=='' || input<=0){
                can = false;
            }
        }
    );

    if ($('#tbody-purchases-3 tr').length == 1){
        can = false;
    }

    
    return can;
}