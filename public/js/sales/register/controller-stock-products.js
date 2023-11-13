$('#tbody-products').find('tr').each(
    function () {
        addListener($(this).find('input').attr('id'));
    }
);

function addListener(id_input_qty){
    $('#'+id_input_qty).on('input',
        function () {
            let data, max;
            data = {
                'id':id_input_qty.split('-')[1]
            }
            $.ajax({
                    url: 'products-filter',
                    type: 'GET',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        max = response.product.stock;
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        max = Math.inf();
                    }
                }
            );

            if (!$(this).val()>0 || !$(this).val()<=max){
                $(this).setCustomValidity('Ingrese un número válido');
            }
            else {
                $(this).setCustomValidity('');
            }
        }
    );
}