$('#tbody-products').find('tr').each(
    function () {
        addListener($(this).find('input').attr('id'));
    }
);

function addListener(id_input_qty){
    $('#'+id_input_qty).on('input',
        function () {
            let data, max, input_aux;
            // input = $(this);
            input_aux = this;
            data = {
                'id':id_input_qty.split('-')[1]
            }
            $.ajax({
                    url: 'products-filter-async',
                    type: 'GET',
                    data: data,
                    success: function(response) {
                        max = response.products[0]['stock'];
                        let input, span; 
                        input = document.getElementById(id_input_qty);
                        span = document.getElementById('sp-' + id_input_qty.split('-')[1]);
                        

                        input.setAttribute('max',parseInt(max));
                            // input.setAttribute('min',1);
                        if(input.validity.valid){
                            span.textContent = "";
                            span.className = "error";
                        }
                        else if(input.validity.rangeOverflow) {
                            span.textContent = "No hay stock suficiente";
                            span.className = "error active"
                        }
                        else {
                            span.textContent = "Nro no válido";
                            span.className = "error active"
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        max = -1;
                    }
                }
            );
            
        }
    );
}
