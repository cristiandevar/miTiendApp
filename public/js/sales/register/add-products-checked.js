document.addEventListener('DOMContentLoaded', 
    function ( e ) {
        $('#add-products').on('click',
            function ( e ) {
                var rows = $("#table-products tbody tr");
                rows.each(function() {
                    var qty_td = $(this).find("td[id^='qty-']");
                    var ckbx_td = $(this).find("td[id^='ckbx-']");
                    for(let i=0 ; i<=qty_td.length ; i++) {
                        
                    }
                });
            }
        );
    }
);