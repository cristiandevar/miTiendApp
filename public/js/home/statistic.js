// var ctx = document.getElementById('myChart').getContext('2d');
// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
//         datasets: [{
//             label: 'Ventas',
//             data: [12, 19, 3, 5, 2, 3],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero: true
//                 }
//             }]
//         }
//     }
// });

document.addEventListener('DOMContentLoaded',
    function(){
       get_data();
    }

);

function get_data(){
    let data = {
    }
    $.ajax(
        {
            url: 'panel/get-data-async',
            type: 'GET',
            data: data,
            success: function(response) {
                let pd = response.purchases_day;
                x = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
                y = [pd[0].length, pd[1].length, pd[2].length, pd[3].length, pd[4].length, pd[5].length, pd[6].length ]
                title = 'Ventas de este mes, separada por dias';
                
                console.log(response.purchases_day[0]);
                graph_bar(x, y, title);
                console.log('Paso por aqui');
                // var ctx = document.getElementById('myChart').getContext('2d');
                // $('#table-purchases-3').show();
                // $('#form-update-purchase').show();
                // carge_purchase(response.purchase, response.details, response.products, response.suppliers);
            },
            error: function(xhr, status, error) {
                console.error('Todo mal');
                // $('#table-purchases-3').hide();
                // $('#form-update-purchase').hide();
                // $('#alert-table-purchases-3').show();
                
                // $('#alert-table-purchases-3').children().first().text('Problemas al leer la compra');
            }
        }
    );
}

function graph_bar(x,y,title){
    let ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: x,
            datasets: [{
                label: title,
                data: y,
                // backgroundColor: [
                //     'rgba(255, 99, 132, 0.2)',
                //     'rgba(54, 162, 235, 0.2)',
                //     'rgba(255, 206, 86, 0.2)',
                //     'rgba(75, 192, 192, 0.2)',
                //     'rgba(153, 102, 255, 0.2)'
                // ],
                // borderColor: [
                //     'rgba(255, 99, 132, 1)',
                //     'rgba(54, 162, 235, 1)',
                //     'rgba(255, 206, 86, 1)',
                //     'rgba(75, 192, 192, 1)',
                //     'rgba(153, 102, 255, 1)'
                // ],
                // borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}
