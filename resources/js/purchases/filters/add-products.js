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
                                if ($(this).val() != '') {
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
                    
                    console.log('row:', row);
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
                    else {
                        let row_update = tbody.find('#trpurchase-'+ids[i]);
                        row_update.find('td').eq(4).text(vals[i]);
                    }
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
// function delete_row(id) {
//     let tbody = $('#tbody-purchase');
//     let tr = tbody.find(`#trpurchase-${id}`);
//     tr.remove();
// }