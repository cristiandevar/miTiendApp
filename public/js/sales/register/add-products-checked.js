document.addEventListener('DOMContentLoaded', 
    function ( e ) {
        $('#add-products').on('click',
            function ( e ) {
                e.preventDefault();
                
                let ids = [];
                let vals = [];
                let acum;
                let tbody = $('#tbody-sale');
                let rows, row, tr, trtotal, td1, td2, td3, td4, td5, dot;
                
                rows = $("#table-products tbody tr");
                trtotal_ultimo = $('#tbody-sale').find('#trsale-total');
                trtotal = trtotal_ultimo.clone(true);
                trtotal_ultimo.remove();
                
                acum = parseFloat(trtotal.find('td').eq(3).text());
            
                rows.each(
                    function(){
                        $(this).find('input[type=number]').each(
                            function(){
                                if ($(this).val() != '') {
                                    ids.push(parseInt($(this).attr('id').split("-")[1]));
                                    vals.push(parseInt($(this).val()));
                                }
                            }

                        );
                    }
                );

                for (let i=0 ; i<ids.length ; i++) {
                    row = $("#trproduct-"+ids[i]);
                    if (!$('#tbody-sale').find('#trsale-'+ids[i]).length) {

                        tr = document.createElement('tr');
                        td1 = document.createElement('td');
                        
                        tr.setAttribute('id','trsale-'+ids[i]);

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

                        td5 = document.createElement('td');
                        dot = parseFloat(row.find('td').eq(2).text()) * parseInt(vals[i]);
                        td5.innerHTML = dot;
                        tr.appendChild(td5);

                        // console.log($('#tbody-sale'));
                        // $('#tbody-sale').insertBefore(tr, trtotal);
                        // tr.insertBefore(trtotal)
                        $('#tbody-sale').append(tr);
                        // tr.insertBefore(tbody.find('tr:last')[0], tbody.find('tr:last').next()[0]);
                    }
                    else {
                        let row_update = $('#tbody-sale').find('#trsale-'+ids[i]);
                        
                        row_update.find('td').eq(3).text(vals[i]);
                        
                        dot = parseFloat(row_update.find('td').eq(2).text()) * vals[i];
                        row_update.find('td').eq(4).text(dot);
                    }
                    acum += dot;
                }
                // trtotal.find('td').eq(4).text(acum);
                trtotal.children().last().text(acum);
                // console.log(trtotal.children().last().text());
                tbody.append(trtotal);
                // $('#tbody-sale').append(code_html);
                // tr = document.createElement('tr');
                // td1 = document.createElement('td');
                // td1.innerHTML = '';
                // tr.appendChild(td1);

                // td2 = document.createElement('td');
                // td2.innerHTML = '';
                // tr.appendChild(td2);

                // td3 = document.createElement('td');
                // td3.innerHTML = '';
                // tr.appendChild(td3);

                // td4 = document.createElement('td');
                // td4.innerHTML = '';
                // tr.appendChild(td4);

                // td5 = document.createElement('td');
                // td5.innerHTML = acum;
                // tr.appendChild(td5);


                // let qty_td = $(this).find("td[id^='qty-']");

                // for(let i=0 ; i<=qty_td.length ; i++) {

                // }
            }
        );
    }
);
// function get_rows_checked(){
//     let rows = $("#table-products tbody tr");
//     let ids = [];

//     rows.each(function() {
//         // let qty_td = $(this).find("td[id^='qty-']");
//         // let ckbx_td = $(this).find("td[id^='ckbx-']");
//         // for(let i=0 ; i<=ckbx_td.length ; i++) {
//         //     if (ckbx_td.eq(0).find(":checkbox").prop("checked")) {
//         //         ids.push(parseInt(id.split("-")[1]));
//         //     }
//         // }
//         $('input[type=checkbox]:checked').each(function() {
//             ids.push(parseInt($(this).attr('id').split("-")[1]));
//         });
//     });

//     return ids;
// }
