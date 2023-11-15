document.addEventListener('DOMContentLoaded', 
    function (e) {
        let alert_1,alert_2,alert_3;
        
        alert_1 = $('#div-alert-1');
        alert_2 = $('#div-error-1');

        alert_3 = $('#alert-table-purchase');
        let table = $('#table-purchase');

        alert_1.hide();
        alert_2.hide();
        alert_3.hide();

        $('#select-supplier').on('change',
            function ( e ) {
                let option = $(this).val();
                console.log(option);
                let data_filter = {
                    supplier_id: parseInt(option),
                }
                $.ajax(
                    {
                        url: 'purchase-filter-supplier-async',
                        type: 'GET',
                        data: data_filter,
                        success: function(response) {
                            carge_table(response.products, response.categories, response.suppliers);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    }
                );
            }
        );
    }
);