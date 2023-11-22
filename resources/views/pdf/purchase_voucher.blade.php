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
      <h1>Comprobante de Orden de Compra nro: {{ $purchase->id }}</h1>
      <!-- <div id="company" class="clearfix">
        <div>Puesto 13</div>
        <div>Direccion falsa, 123</div>
        <div>(387) 4111-222</div>
        <div><a href="mailto:puesto_13@example.com">puesto_13@example.com</a></div>
      </div> -->
      <div id="project">
        <div><span>Fecha Emisión</span> {{ $purchase->created_at }}</div>
        <div><span>Proveedor</span> {{ $supplier->companyname}}</div>
        {{-- <div><span>Email</span> <a href="mailto:{{ $data['supplier']->email}}">{{ $data['supplier']->email}}</a></div>
        <div><span>Fecha Solicitud</span> {{ $data['purchase']->created_at}}</div> --}}
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
              @foreach ($headings as $heading)
                  <th scope="col">{{ $heading }}</th>
              @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($details as $key => $detail)
            <tr>
                @foreach ($columns as $column)
                    @if ($column == 'product_id')
                        <td>{{ $detail->product->name }}</td>
                    {{-- @elseif ($column == 'supplier_id') 
                        <td>{{ $detail->supplier->companyname }}</td>
                    @elseif ($column == 'image')
                        <td>
                            <img src="{{ $detail->image }}" alt="{{ $detail->name }}" class="img-fluid" style="width: 150px;">
                        </td>--}}
                    @else
                        <td>{{ $detail->$column }}</td>
                    @endif
                @endforeach
            </tr>
            @endforeach
            {{-- <tr>
              @for ($c = 0; $c < count($columns)-2; $c ++)
                <td></td>
              @endfor
              <td>Total</td>
              <td>{{ $total }}</td>
            </tr> --}}
        </tbody>
      </table>
      {{-- <div id="notices">
        <div class="notice">¡Gracias por trabajar junto a nosotros!.</div>
      </div> --}}
    </main>
    <footer>
      Comprobante de venta generada por <strong>"miTiendAPP"</strong>
    </footer>
  </body>
  {{-- </body>
</html> --}}


{{-- 
<div class="row">
    <div class="col-12 text-center">
        {{ $title }}
    </div>
    <div class="col-6 text-center">
        {{ $subtitle }}
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body" id="card-table">
                {{-- @if (count($products) > 0)
                    <table id="table-products" class="table table-border w-100">
                        <thead>
                            <tr>
                                @foreach ($headings as $heading)
                                    <th scope="col">{{ $heading }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody id="body-table-products">
                            @foreach ($products as $key => $product)
                            <tr>
                                @foreach ($columns as $column)
                                    @if ($column == 'category_id')
                                        <td>{{ $product->category->name }}</td>
                                    @elseif ($column == 'supplier_id') 
                                        <td>{{ $product->supplier->companyname }}</td>
                                    @elseif ($column == 'imgage')
                                        <td>
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid" style="width: 150px;">
                                        </td>
                                    @else
                                        <td>{{ $product->$column }}</td>
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                {{-- @else
                    <p>No Hay productos que coincidadn con los filtros</p>
                @endif
            </div>
        </div>
    </div>
</div> --}}