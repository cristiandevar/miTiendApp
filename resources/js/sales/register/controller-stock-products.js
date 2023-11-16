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
                        // console.log(response.products[0]['stock']);
                        max = response.products[0]['stock'];
                        // console.log(!(parseInt(input.val())<=max));
                        let input, span; 
                        input = document.getElementById(id_input_qty);
                        span = document.getElementById('sp-' + id_input_qty.split('-')[1]);
                        // console.log();

                        input.setAttribute('max',parseInt(max));
                        
                        if(input.validity.valid){
                            span.innerHTML = "";
                            span.className = "error";
                        }
                        else {
                            span.textContent = "No hay stock suficiente";
                            span.className = "error active"
                        }
                        // if (!(parseInt(input.val())>0) || !(parseInt(input.val())<=max)){
                        //     input_aux.setCustomValidity('Ingrese un número válido');
                        //     // this.setCustomValidity('Ingrese un número válido');
                        
                        // }
                        // else {
                        //     input_aux.setCustomValidity('');
                        // }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        max = -1;
                    }
                }
            );
            // console.log(max);
            
        }
    );
}
