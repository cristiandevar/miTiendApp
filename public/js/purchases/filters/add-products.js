document.addEventListener('DOMContentLoaded', 
    function (e) {
        $('#add-row-1').on('click',
            function ( e ) {
                
                e.preventDefault();
                let rows, ids, vals, row, tbody, tr, tddel, a, ic, td1, td2, td3, td4;
                
                ids = [];
                vals = [];

                rows = $("#tbody-options tr");
                rows.each(
                    function () {
                        let id = $(this).attr('id').split("-")[1];
                        $(this).find('input[type=number]').each(
                            function(){
                                
                                let span = $('#sp-' + id);
                                let value = $(this).val();
                                if (!span.hasClass('active') && value!='') {
                                    ids.push(parseInt(id));
                                    vals.push(parseInt($(this).val()));
                                }
                            }

                        );
                    }
                );

                
                tbody = $('#tbody-purchase');

                for (let i=0 ; i<ids.length ; i++) {
                    row = $('#table-options-1').find("#trproduct-"+ids[i]);
                    
                    // console.log('row:', row);
                    if (!tbody.find('#trpurchase-'+ids[i]).length) {
                        tr = document.createElement('tr');
                        tr.setAttribute('id','trpurchase-'+ids[i]);
                        
                        tddel = document.createElement('td');
                        a = document.createElement('a');
                        ic = document.createElement('i');
                        ic.setAttribute('class', "fas fa-trash-alt");
                        // a.setAttribute('href', `delete_row(${ids[i]})`);
                        a.setAttribute('id', 'tddel-'+ids[i]);
                        assingDelListener(a, ids[i]);
                        a.appendChild(ic);
                        tddel.appendChild(a);
                        tr.appendChild(tddel);

                        td1 = document.createElement('td');
                        td1.innerHTML = row.find('td').eq(0).text();
                        tr.appendChild(td1);

                        td2 = document.createElement('td');
                        td2.innerHTML = row.find('td').eq(1).text();
                        tr.appendChild(td2);

                        td3 = document.createElement('td');
                        td3.innerHTML = row.find('td').eq(2).text();
                        tr.appendChild(td3);

                        td4 = document.createElement('td');
                        td4.innerHTML = vals[i];
                        tr.appendChild(td4);
                        
                        tbody.append(tr);
                    }
                    else if(!$('sp-'+ids[i]).hasClass('active')){
                        let row_update = tbody.find('#trpurchase-'+ids[i]);
                        row_update.find('td').eq(4).text(vals[i]);
                    }
                    // console.log(!$('sp-'+ids[i]).hasClass('active'));
                }
            }
        );
    }
);
function assingDelListener(a, id) {
    a.addEventListener('click', 
        function (e){
            e.preventDefault();
            let tbody = $('#tbody-purchase');
            let tr = tbody.find(`#trpurchase-${id}`);
            tr.remove();
        }
    );
}

function add_listener(id){
    // console.log(id);
    $('#'+id).on('input',
        function () {
            // let span;
            // // span = $(this).parent().children().find('span').first(); 
            // span = $(this).parent().find('span').first();
            // // span = document.getElementById('sp-' + id_input_qty.split('-')[1]);
            // let value = $(this).val();
            // console.log(value > 0);
            // if (value != '' && value > 0 ) {
            //     span.attr('class', 'error');
            //     span.text('');
            // }
            // else if (value != '') {
            //     $(this).attr('min',1);
            //     // span.textContent = "Cantidad no valida";
            //     // span.className = "error active"
            //     span.attr('class', 'error active');
            //     span.text('Cantidad no valida');
            // }
            // else{
            //     span.attr('class', 'error');
            //     span.text('');
            // }

            let input = document.getElementById(id);
            let span = document.getElementById('sp-' + id.split('-')[1]);
            // console.log(span);

            input.setAttribute('min',1);
                // input.setAttribute('min',1);
            if(input.validity.valid){
                span.textContent = "";
                span.className = "error";
            }
            else {
                span.textContent = "Nro no válido";
                span.className = "error active"
            }
            // console.log($(this).parent().find('span').first());
        }
    );
}
// function delete_row(id) {
//     let tbody = $('#tbody-purchase');
//     let tr = tbody.find(`#trpurchase-${id}`);
//     tr.remove();
// }