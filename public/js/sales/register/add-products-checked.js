document.addEventListener('DOMContentLoaded', 
    function ( e ) {
        $('#add-products').on('click',
            function ( e ) {
                e.preventDefault();
                
                let ids, vals, acum, tbody1, tbody2;
                let rows, row, tr, trtotal, td1, td2, td3, td4, td5, tddel, dot, a, ic,sp, input;
                
                ids = [];
                vals = []
                tbody1 = $('#tbody-sale');
                tbody2 = $('#tbody-products');

                rows = $("#table-products tbody tr");
                trtotal_ultimo = tbody1.find('#trsale-total');
                trtotal = trtotal_ultimo.clone(true);
                trtotal_ultimo.remove();
                // console.log(rows);
                rows.each(
                    function(){
                        $(this).find('input[type=number]').each(
                            function(){
                                if ($(this).val() != '') {
                                    ids.push(parseInt($(this).attr('id').split("-")[1]));
                                    vals.push(parseInt($(this).val()));
                                    // console.log('ids: ',ids, 'primer vals: ', vals);
                                }
                            }

                        );
                    }
                );
                // console.log(ids);
                for (let i=0 ; i<ids.length ; i++) {
                    row = $('#table-products').find("#trproduct-"+ids[i]);
                    
                    input = tbody2.find('#trproduct-'+ids[i]).children().last().find('input').first();
                    sp = tbody2.find('#trproduct-'+ids[i]).children().last().find('span').first();
                    
                    // console.log(tbody2.find('#trproduct-'+ids[i]).children().last().find('input').first().val() > 0);
                    if (!tbody1.find('#trsale-'+ids[i]).length && input.val() > 0 && sp.attr('class') != 'error active') {

                        tr = document.createElement('tr');
                        tr.setAttribute('id','trsale-'+ids[i]);
                        
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
                        // console.log('indice', i,'cantidad: ', vals[i]);

                        td5 = document.createElement('td');
                        dot = (parseFloat(row.find('td').eq(2).text()) * parseInt(vals[i])).toFixed(2);
                        td5.innerHTML = dot;
                        tr.appendChild(td5);

                        tbody1.append(tr);
                    }
                    else if(input.val() > 0 && sp.attr('class') != 'error active'){
                        let row_update = tbody1.find('#trsale-'+ids[i]);

                        row_update.find('td').eq(4).text(vals[i]);
                        
                        dot = (parseFloat(row_update.find('td').eq(3).text()) * vals[i]).toFixed(2);
                        row_update.find('td').eq(5).text(dot);
                    }

                }
                acum = calcule_total();
                trtotal.children().last().text(acum);

                tbody1.append(trtotal);
            }
        );
    }
);

function calcule_total() {
    let tbody = $('#tbody-sale');
    let acum = 0;
    tbody.find('tr').each(
        function () {
            if ($(this).attr('id') != 'trsale-total') {

                acum += parseFloat($(this).children().last().text());
            }
        }
    );
    return (acum).toFixed(2);
}

function delete_row(id) {
    let tbody = $('#tbody-sale');
    let tr = tbody.find(`#trsale-${id}`);
    tr.remove();
}

function assingDelListener(a, id) {
    a.addEventListener('click', 
        function (e){
            e.preventDefault();
            let acum;
            delete_row(id);

            acum = calcule_total();
            // console.log('nuevo acum: ', acum);
            $('#tbody-sale').find('#trsale-total').find('td').eq(4).text(acum);
        }
    );
}
