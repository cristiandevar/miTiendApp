{{-- <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Orden de compra</title>
    <link rel="stylesheet" href="{{ asset('css/pdf/style.css') }}" media="all" />
  </head>
  <body>
    <header class="clearfix"> --}}
      {{-- <div id="logo">
        <img src="logo.png">
      </div> --}}
<head>
  <style>
.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 100%;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  margin-top: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
</style>
</head>
<body>
    <header>
      <h1>Registro de Orden de Compra</h1>
      <div id="company" class="clearfix">
        <div>Puesto 13</div>
        <div>Direccion falsa, 123</div>
        <div>(387) 4111-222</div>
        <div><a href="mailto:puesto_13@example.com">puesto_13@example.com</a></div>
      </div>
      <div id="project">
        <div><span>Proveedor</span> {{ $data['supplier']->companyname }}</div>
        <div><span>Dirección</span> {{ $data['supplier']->address}}</div>
        <div><span>Email</span> <a href="mailto:{{ $data['supplier']->email}}">{{ $data['supplier']->email}}</a></div>
        <div><span>Fecha Registro</span> {{ $data['purchase']->received_date}}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">CÓDIGO</th>
            <th class="desc">NOMBRE</th>
            <th>CANT. PEDIDA</th>
            <th>CANT. RECIBIDA</th>
            <th>PRECIO COSTO</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data['details'] as $detail)
            <tr>
              <td class="service">{{ $detail->product->code }}</td>
              <td class="desc" >{{ $detail->product->name }}</td>
              <td class="qty" style="text-align:center">{{ $detail->quantity_ordered }}</td>
              <td class="qty" style="text-align:center">{{ $detail->quantity_received }}</td>
            </tr>
          @endforeach
          <tr>
            <td class="qty" style="text-align:center"></td>
            <td class="desc" ></td>
            <th class="service">TOTAL PAGADO</th>
            <td class="qty" style="text-align:center">{{ $data['purchase']->total_paid }}</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div class="notice">¡Gracias por trabajar junto a nosotros!.</div>
      </div>
    </main>
    <footer>
      Orden de compra registrada por <strong>"miTiendAPP"</strong>
    </footer></body>
  {{-- </body>
</html> --}}