// import Chart from '/chart.js/auto';
// import * as from './js';
const MONTHS = [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Augosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Dicimbre'
];

const DAYS = [
    'Domingo',
    'Lunes',
    'Martes',
    'Miercoles', 
    'Jueves', 
    'Viernes', 
    'Sabado',
];

const COLORS = [
'#4dc9f6',
'#f67019',
'#f53794',
'#537bc4',
'#acc236',
'#166a8f',
'#00a950',
'#58595b',
'#8549ba'
];


document.addEventListener('DOMContentLoaded',
    function(){
        let type_graph, range_graph;

        $('#type').on('change',
            function(){
                type_graph = $(this).val();
                range_graph = $('#range').val();
                choose_graph(type_graph, range_graph);
            }
        );

        $('#range').on('change',
            function(){
                range_graph = $(this).val();
                type_graph = $('#type').val();
                choose_graph(type_graph, range_graph);
            }
        );

        choose_graph($('#type').val(), $('#range').val());
    }

);

function choose_graph(optiona, optionb){
    
    if(optiona == 1){
        graph_line_in_out();
    }
    else {
        graph_line_purch_sale(optionb);

    }

    
    
}

function graph_line_purch_sale(option){
    let range;
    if ( option == 1 ) {
        range = 'Y';
    }
    else if(option == 2){
        range = 'M';
    }
    else {
        range = 'W';
    }
    let data = {
        option : range,
    }

    $.ajax(
        {
            url: 'panel/get-data-purch-sale',
            type: 'GET',
            data: data,
            success: function(response) {
                let p,s;
                p = response.purchases;
                s = response.sales;

                x = get_labels(option);

                y1 = prepare_qty(p, option);
                y2 = prepare_qty(s, option);

                title1 = 'Compras';
                title2 = 'Ventas';
                
                graph_line(x, y1, y2, title1, title2);
                $('#lbl-balance').hide();
                $('#balance').hide();
            },
            error: function(xhr, status, error) {
                console.error('Todo mal');
            }
        }
    );

}

function get_range(){
    let range, option;

    option = $('#range').val();

    if ( option == 1 ) {
        range = 'Y';
    }
    else if(option == 2){
        range = 'M';
    }
    else {
        range = 'W';
    }

    return range;
}

function graph_line_in_out(){
    let range = get_range();
    let option = $('#range').val();
    let data = {
        option : range,
    }
    $.ajax(
        {
            url: 'panel/get-data-in-out',
            type: 'GET',
            data: data,
            success: function(response) {
                let p,s,tp,ts;
                p = response.purchases;
                s = response.sales;

                // tp = response.all_out;
                // ts = response.all_in;

                x = get_labels(option);

                y1 = prepare_qty(p, option);
                y2 = prepare_qty(s, option);

                title1 = 'Egresos';
                title2 = 'Ingresos';
                
                graph_line(x, y1, y2, title1, title2);
                update_data_in_out();
            },
            error: function(xhr, status, error) {
                console.error('Todo mal');
            }
        }
    );
}

function get_labels(option){
    let labels;
    if(option == 1){
        labels = months({count: (new Date()).getMonth() + 1});
    }
    else if(option == 2){
        labels = days((new Date()).getDate());
    }
    else {
        labels = days_of_week({count: (new Date()).getDay()+1});
    }
    return labels;
}

function prepare_qty(lista, option){
    let x = [];
    let labels = get_labels(option);
    for(let i=0; i<labels.length; i++){
        x.push(0);
    }
    if(option == 1){
        for(let i=0; i<lista.length; i++){
            x.splice(lista[i]['m']-1, 1, lista[i]['total']);
        }
    }
    else if(option == 2){
        for(let i=0; i<lista.length; i++){
            x.splice(lista[i]['d']-1, 1, lista[i]['total']);
        }
    }
    else{
        let d, d2;
        for(let i=0; i<lista.length; i++){
            d = new Date();
            d2 = new Date(d.getFullYear(), d.getMonth(), lista[i]['d']); 
            x.splice(d2.getDay() -1, 1, lista[i]['total']);
        }
    }
    

    return x;
}

function months(config) {
    var cfg = config || {};
    var count = cfg.count || 12;
    var section = cfg.section;
    var values = [];
    var i, value;
  
    for (i = 0; i < count; ++i) {
      value = MONTHS[Math.ceil(i) % 12];
      values.push(value.substring(0, section));
    }
  
    return values;
}

function days(to_day) {
    const lista = [];
    for (let i = 1; i <= to_day; i++) {
        lista.push(i);
    }
    return lista;
}

function days_of_week(config){
    var cfg = config || {};
    var count = cfg.count || 7;
    var section = cfg.section;
    var values = [];
    var i, value;
  
    for (i = 1; i <= count; ++i) {
    //   value = DAYS[Math.ceil(i) % 7];
      value = DAYS[i];
      values.push(value.substring(0, section));
    }
  
    return values;
}

function graph_line(x1,y1,y2,title1, title2){
    const data = {
        labels: x1,
        datasets: [
            {
                label: title2,
                data: y2,
                fill: false,
                borderColor: 'rgb(75, 192, 75)',
                tension: 0.1
            },
            {
                label: title1,
                data: y1,
                fill: false,
                borderColor: 'rgb(255, 193, 7)',
                tension: 0.1
            },
        ]
    };
    const config = {
        type: 'line',
        data: data,
      };

    let div_canvas = $('#div-canvas');
    let new_canvas = $('<canvas></canvas>',{
        id: 'myChart',
    })
    div_canvas.html('')
    div_canvas.append(new_canvas);

    let ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx,config);
}


function update_data_in_out(){
    let range = get_range();
    let data = {
        option : range,
    }
    $.ajax(
        {
            url: 'panel/get-data',
            type: 'GET',
            data: data,
            success: function(response) {
                let pp, ps, ppi, psi, tp, ts, sp, spi, ss, ssi;

                tp = response.all_out;
                ts = response.all_in;

                // x = get_labels(option);

                update_total_in_out(tp,ts);
            
                
                pp = response.product_purchase;
                ppi = response.product_purchase_info;
                ps = response.product_sale;
                psi = response.product_sale_info;

                update_product_in_out(pp, ppi, ps, psi);

                
                sp = response.supplier_purchase;
                spi = response.supplier_purchase_info;
                ss = response.supplier_sale;
                ssi = response.supplier_sale_info;

                update_supplier_in_out(sp, spi, ss, ssi);
            },
            error: function(xhr, status, error) {
                console.error('Todo mal');
            }
        }
    );
    
}

function update_total_in_out(tp, ts){
    let spans, option, title;
    option = $('#range').val()
    if(option == 1){
        title = ' de este Año';
    }
    else if(option == 2) {
        title = ' de este Mes';
    }
    else{
        title = ' de esta semana';
    }
    spans = $('#content-title-1').find('span');
    spans.eq(0).text('Total Ingresos' + title);
    spans.eq(1).text(ts);

    spans = $('#content-title-2').find('span');
    spans.eq(0).text('Total Egresos' + title);
    spans.eq(1).text(tp);

    let b = ts - tp;
    if(b>0){
        $('#balance').attr('style','color:green;');
    }
    else {        
        $('#balance').attr('style','color:red;');
    }
    $('#balance').val(b);
    $('#balance').attr('disabled',true);
    
    $('#lbl-balance').show();
    $('#balance').show();

}

function update_product_in_out(pp, ppi, ps, psi){
    let h2, h3, p, option, title;
    option = $('#range').val()
    if(option == 1){
        title = ' del Año';
    }
    else if(option == 2) {
        title = ' del  Mes';
    }
    else{
        title = ' de la semana';
    }
    h3 = $('#data-1').find('h3').first();
    h2 = $('#data-1').find('h2').first();
    p = $('#data-1').find('p').first()

    h3.text(ps[0]['stock_sold']  + ' unidades');
    h2.text(psi['name']);
    p.text('Producto mas vendido'+title);

    
    h3 = $('#data-2').find('h3').first();
    h2 = $('#data-2').find('h2').first();
    p = $('#data-2').find('p').first()

    h3.text(pp[0]['stock_purchased']  + ' unidades');
    h2.text(ppi['name']);
    p.text('Producto mas comprado'+title);
}

function update_supplier_in_out(sp, spi, ss, ssi){
    let h2, h3, p, option, title;
    option = $('#range').val()
    if(option == 1){
        title = ' del Año';
    }
    else if(option == 2) {
        title = ' del  Mes';
    }
    else{
        title = ' de la semana';
    }
    h3 = $('#data-3').find('h3').first();
    h2 = $('#data-3').find('h2').first();
    p = $('#data-3').find('p').first()

    h3.text(ss[0]['cant_sale']  + ' ventas');
    h2.text(ssi['companyname']);
    p.text('Proveedor mas rentable '+title);

    
    h3 = $('#data-4').find('h3').first();
    h2 = $('#data-4').find('h2').first();
    p = $('#data-4').find('p').first()

    h3.text(sp[0]['cant_purchase']  + ' compras');
    h2.text(spi['companyname']);
    p.text('Proveedor mas solicitado'+title);
}

function update_total_in_canceled(){

}

function update_total_out_canceled(){

}




// function graph_bar(x1, y1, y2, title1, title2){
//     const data = {
//         labels: x1,
//         datasets: [
//             {
//                 label: title1,
//                 data: y1,
//                 // fill: false,
//                 borderColor: 'rgb(255, 51, 51)',
//                 // tension: 0.1,
//                 backgroundColor: 'rgba(255, 99, 132, 0.2)',
//                 // borderColor: 'rgba(255, 99, 132, 1)',
//                 borderWidth: 1
//             },
//             {
//                 label: title2,
//                 data: y2,
//                 // fill: false,
//                 borderColor: 'rgb(75, 192, 75)',
//                 // tension: 0.1,
//                 backgroundColor: 'rgba(54, 162, 235, 0.2)',
//                 // borderColor: 'rgba(54, 162, 235, 1)',
//                 borderWidth: 1
//             },
//         ]
//     };
//     const config = {
//         type: 'bar',
//         data: data,
//         options: {
//             scales: {
//                 yAxes: [{
//                     ticks: {
//                         beginAtZero: true
//                     }
//                 }],
//                 xAxes: [{
//                     barPercentage: 0.5
//                 }]
//             }
//         }
//       };
//       let ctx = document.getElementById('myChart').getContext('2d');
//       var myChart = new Chart(ctx,config);
// }







// function get_data(){
//     let data = {
//     }
//     $.ajax(
//         {
//             url: 'panel/get-data-async',
//             type: 'GET',
//             data: data,
//             success: function(response) {
//                 let pd = response.purchases_day;
//                 x = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
//                 y = [pd[0].length, pd[1].length, pd[2].length, pd[3].length, pd[4].length, pd[5].length, pd[6].length ]
//                 title = 'Compras de este mes, separada por dias';
                
//                 console.log(response.purchases_day[0]);
//                 graph_bar(x, y, title);
//                 console.log('Paso por aqui');
//                 // var ctx = document.getElementById('myChart').getContext('2d');
//                 // $('#table-purchases-3').show();
//                 // $('#form-update-purchase').show();
//                 // carge_purchase(response.purchase, response.details, response.products, response.suppliers);
//             },
//             error: function(xhr, status, error) {
//                 console.error('Todo mal');
//                 // $('#table-purchases-3').hide();
//                 // $('#form-update-purchase').hide();
//                 // $('#alert-table-purchases-3').show();
                
//                 // $('#alert-table-purchases-3').children().first().text('Problemas al leer la compra');
//             }
//         }
//     );
// }

// function graph_bar(x,y,title){
//     let ctx = document.getElementById('myChart').getContext('2d');
//     var myChart = new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: x,
//             datasets: [
//                 {
//                     label: title,
//                     data: y,
//                 // backgroundColor: [
//                 //     'rgba(255, 99, 132, 0.2)',
//                 //     'rgba(54, 162, 235, 0.2)',
//                 //     'rgba(255, 206, 86, 0.2)',
//                 //     'rgba(75, 192, 192, 0.2)',
//                 //     'rgba(153, 102, 255, 0.2)'
//                 // ],
//                 // borderColor: [
//                 //     'rgba(255, 99, 132, 1)',
//                 //     'rgba(54, 162, 235, 1)',
//                 //     'rgba(255, 206, 86, 1)',
//                 //     'rgba(75, 192, 192, 1)',
//                 //     'rgba(153, 102, 255, 1)'
//                 // ],
//                 // borderWidth: 1
//                 },

//             ]
//         },
//         options: {
//             scales: {
//                 yAxes: [{
//                     ticks: {
//                         beginAtZero: true
//                     }
//                 }]
//             }
//         }
//     });
// }

// function graph_line_days(){
//     let x1, x2, y1, y2, title1, title2, pd, sd;
//     let data = {
//     }
//     $.ajax(
//         {
//             url: 'panel/get-data-async',
//             type: 'GET',
//             data: data,
//             success: function(response) {
//                 pd = response.purchases_day;
//                 sd = response.sales_day;

//                 x1 = DAYS;
//                 y1 = 
//                 [
//                     pd[0].length, 
//                     pd[1].length, 
//                     pd[2].length, 
//                     pd[3].length, 
//                     pd[4].length, 
//                     pd[5].length, 
//                     pd[6].length 
//                 ];
//                 y2 = 
//                 [
//                     sd[0].length, 
//                     sd[1].length, 
//                     sd[2].length, 
//                     sd[3].length, 
//                     sd[4].length, 
//                     sd[5].length, 
//                     sd[6].length 
//                 ];
                
                
//                 title1 = 'Compras de este mes, separada por dias';
//                 title2 = 'Ventas de este mes, separada por dias';
//                 graph_line(x1,y1,y2,title1);
//                 // console.log(response.purchases_day[0]);
//             },
//             error: function(xhr, status, error) {
//                 // div_error.children().first().text('La compra no se pudo registrar');
//                 // div_error.show();
//                 // div_alert.hide();
//                 // $('html, body').animate({scrollTop:0}, 'slow');
//             }
//         }
//     );
    
//     // const labels = months({count: 7});
   
    
// // const actions = [
// //     {
// //       name: 'Randomize',
// //       handler(chart) {
// //         chart.data.datasets.forEach(dataset => {
// //           dataset.data = numbers({count: chart.data.labels.length, min: -100, max: 100});
// //         });
// //         chart.update();
// //       }
// //     },
// //     {
// //       name: 'Add Dataset',
// //       handler(chart) {
// //         const data = chart.data;
// //         const dsColor = namedColor(chart.data.datasets.length);
// //         const newDataset = {
// //           label: 'Dataset ' + (data.datasets.length + 1),
// //           backgroundColor: dsColor,
// //           borderColor: dsColor,
// //           data: numbers({count: data.labels.length, min: -100, max: 100}),
// //         };
// //         chart.data.datasets.push(newDataset);
// //         chart.update();
// //       }
// //     },
// //     {
// //       name: 'Add Data',
// //       handler(chart) {
// //         const data = chart.data;
// //         if (data.datasets.length > 0) {
// //           data.labels = months({count: data.labels.length + 1});
  
// //           for (let index = 0; index < data.datasets.length; ++index) {
// //             data.datasets[index].data.push(rand(-100, 100));
// //           }
  
// //           chart.update();
// //         }
// //       }
// //     },
// //     {
// //       name: 'Remove Dataset',
// //       handler(chart) {
// //         chart.data.datasets.pop();
// //         chart.update();
// //       }
// //     },
// //     {
// //       name: 'Remove Data',
// //       handler(chart) {
// //         chart.data.labels.splice(-1, 1); // remove the label first
  
// //         chart.data.datasets.forEach(dataset => {
// //           dataset.data.pop();
// //         });
  
// //         chart.update();
// //       }
// //     }
// //   ];

//     // const config = {
//     //     type: 'line',
//     //     data: data,
//     //     options: {
//     //         responsive: true,
//     //         plugins: {
//     //         legend: {
//     //             position: 'top',
//     //         },
//     //         title: {
//     //             display: true,
//     //             text: 'Chart.js Line Chart'
//     //         }
//     //         }
//     //     },
//     // };
    
// }


// // import colorLib from '@kurkle/color';
// // import {DateTime} from 'luxon';
// // import 'chartjs-adapter-luxon';
// // import {valueOrDefault} from '../../dist/helpers.js';

// // Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/

// function valueOrDefault(value, def){
//     let val;
//     value? val = value : val = def;
//     return val;
// }
// var _seed = Date.now();

// function srand(seed) {
//   _seed = seed;
// }

// function rand(min, max) {
//   min = valueOrDefault(min, 0);
//   max = valueOrDefault(max, 0);
//   _seed = (_seed * 9301 + 49297) % 233280;
//   return min + (_seed / 233280) * (max - min);
// }

// function numbers(config) {
//   var cfg = config || {};
//   var min = valueOrDefault(cfg.min, 0);
// //   cfg.min? min = cfg.min : min = 0;
//   var max = valueOrDefault(cfg.max, 100);
// //   cfg.max? max = cfg.max : max = 100;
//   var from = valueOrDefault(cfg.from, []);
// //   cfg.from? from = cfg.from : from = [];
//   var count = valueOrDefault(cfg.count, 8);
// //   cfg.count? count = cfg.count : count = 8;
//   var decimals = valueOrDefault(cfg.decimals, 8);
// //   cfg.decimals? decimals = cfg.decimals : decimals = 8;
//   var continuity = valueOrDefault(cfg.continuity, 1);
// //   cfg.continuity? continuity = cfg.continuity : continuity = 1;
//   var dfactor = Math.pow(10, decimals) || 0;
//   var data = [];
//   var i, value;

//   for (i = 0; i < count; ++i) {
//     value = (from[i] || 0) + this.rand(min, max);
//     if (this.rand() <= continuity) {
//       data.push(Math.round(dfactor * value) / dfactor);
//     } else {
//       data.push(null);
//     }
//   }

//   return data;
// }

// function points(config) {
//   const xs = this.numbers(config);
//   const ys = this.numbers(config);
//   return xs.map((x, i) => ({x, y: ys[i]}));
// }

// function bubbles(config) {
//   return this.points(config).map(pt => {
//     pt.r = this.rand(config.rmin, config.rmax);
//     return pt;
//   });
// }

// function labels(config) {
//   var cfg = config || {};
//   var min = cfg.min || 0;
//   var max = cfg.max || 100;
//   var count = cfg.count || 8;
//   var step = (max - min) / count;
//   var decimals = cfg.decimals || 8;
//   var dfactor = Math.pow(10, decimals) || 0;
//   var prefix = cfg.prefix || '';
//   var values = [];
//   var i;

//   for (i = min; i < max; i += step) {
//     values.push(prefix + Math.round(dfactor * i) / dfactor);
//   }

//   return values;
// }




// function color(index) {
//   return COLORS[index % COLORS.length];
// }


// const CHART_COLORS = {
//   red: 'rgb(255, 99, 132)',
//   orange: 'rgb(255, 159, 64)',
//   yellow: 'rgb(255, 205, 86)',
//   green: 'rgb(75, 192, 192)',
//   blue: 'rgb(54, 162, 235)',
//   purple: 'rgb(153, 102, 255)',
//   grey: 'rgb(201, 203, 207)'
// };

// const NAMED_COLORS = [
//   CHART_COLORS.red,
//   CHART_COLORS.orange,
//   CHART_COLORS.yellow,
//   CHART_COLORS.green,
//   CHART_COLORS.blue,
//   CHART_COLORS.purple,
//   CHART_COLORS.grey,
// ];

// function namedColor(index) {
//   return NAMED_COLORS[index % NAMED_COLORS.length];
// }

// function newDate(days) {
//   return DateTime.now().plus({days}).toJSDate();
// }

// function newDateString(days) {
//   return DateTime.now().plus({days}).toISO();
// }

// function parseISODate(str) {
//   return DateTime.fromISO(str);
// }
