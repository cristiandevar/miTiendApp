<head>
  <style>

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
      text-align: left;
    }

    table td {
      padding: 20px;
      text-align: left;
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
    @if(count($purchases) == 1)
      <h1>Comprobante de Orden de Compra nro: {{ $purchases[0]->id }}</h1>
    @endif
    @foreach($purchases as $purchase)
      <header>
        <div id="project">
          <div><span>Fecha Emisión</span> {{ $purchase->created_at }}</div>
          <div><span>Proveedor</span> {{ $purchase->supplier->companyname}}</div>
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
            @foreach ($purchase->details as $key => $detail)
              <tr>
                  @foreach ($columns as $column)
                      @if ($column == 'product_id')
                          <td>{{ $detail->product->name }}</td>
                      @else
                          <td>{{ $detail->$column }}</td>
                      @endif
                  @endforeach
              </tr>
              @endforeach
          </tbody>
        </table>
      </main>
    @endforeach
      <footer>
        Comprobante de venta generada por <strong>"miTiendAPP"</strong>
      </footer>
    
  </body>