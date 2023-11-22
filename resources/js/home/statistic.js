// import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded',
    function(){
    //    get_data();
    graph_line();
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
                title = 'Compras de este mes, separada por dias';
                
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

function graph_line(){
    const DATA_COUNT = 7;
    const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};
    
    const labels = Utils.months({count: 7});
    const data = {
    labels: labels,
    datasets: [
        {
        label: 'Dataset 1',
        data: Utils.numbers(NUMBER_CFG),
        borderColor: Utils.CHART_COLORS.red,
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
        },
        {
        label: 'Dataset 2',
        data: Utils.numbers(NUMBER_CFG),
        borderColor: Utils.CHART_COLORS.blue,
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
        }
    ]
    };
    const actions = [
        {
          name: 'Randomize',
          handler(chart) {
            chart.data.datasets.forEach(dataset => {
              dataset.data = Utils.numbers({count: chart.data.labels.length, min: -100, max: 100});
            });
            chart.update();
          }
        },
        {
          name: 'Add Dataset',
          handler(chart) {
            const data = chart.data;
            const dsColor = Utils.namedColor(chart.data.datasets.length);
            const newDataset = {
              label: 'Dataset ' + (data.datasets.length + 1),
              backgroundColor: Utils.transparentize(dsColor, 0.5),
              borderColor: dsColor,
              data: Utils.numbers({count: data.labels.length, min: -100, max: 100}),
            };
            chart.data.datasets.push(newDataset);
            chart.update();
          }
        },
        {
          name: 'Add Data',
          handler(chart) {
            const data = chart.data;
            if (data.datasets.length > 0) {
              data.labels = Utils.months({count: data.labels.length + 1});
      
              for (let index = 0; index < data.datasets.length; ++index) {
                data.datasets[index].data.push(Utils.rand(-100, 100));
              }
      
              chart.update();
            }
          }
        },
        {
          name: 'Remove Dataset',
          handler(chart) {
            chart.data.datasets.pop();
            chart.update();
          }
        },
        {
          name: 'Remove Data',
          handler(chart) {
            chart.data.labels.splice(-1, 1); // remove the label first
      
            chart.data.datasets.forEach(dataset => {
              dataset.data.pop();
            });
      
            chart.update();
          }
        }
      ];

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Chart.js Line Chart'
            }
            }
        },
    };
}
