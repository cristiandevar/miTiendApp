
<h6 class="card-header">Elija los parametros de búsqueda</h6>
    <div class="form-group row">
        <input title="Ingrese el código de algun producto" class="form-control col-xs-12 col-2 m-1" type="text" id="code" name="code" placeholder="Código" value={{ isset($inputs) && isset($inputs['code'])? $inputs['code'] : '' }}>
        <input title="Ingrese el nombre de algun producto" class="form-control col-xs-12 col-2 m-1" type="text" id="name" name="name" placeholder="Nombre" value={{ isset($inputs) && isset($inputs['name'])? $inputs['name'] : '' }}>
        {{-- <input title="Ingrese Precio desde" class="form-control col-xs-12 col-2 m-1" type="number" id="price_since" name="price_since" placeholder="Precio desde..." value={{ isset($inputs['price_since'])? $inputs['price_since'] : '' }}>
        <input title="Ingrese Precio hasta" class="form-control col-xs-12 col-2 m-1" type="number" id="price_to" name="price_to" placeholder="Precio hasta..." value={{ isset($inputs['price_to'])? $inputs['price_to'] : '' }}> --}}
        <select title="Seleccione algun Proveedor" id="supplier_id" name="supplier_id" class="form-control col-xs-12 col-2 m-1">
        <option value="" {{ !isset($inputs['supplier_id']) || $inputs['supplier_id']==''? 'selected':''}}>Proveedor...</option>
            @foreach ($suppliers as $supplier)
                <option {{ isset($inputs['supplier_id']) && $inputs['supplier_id'] == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                    {{ $supplier->companyname }}
                </option>
            @endforeach
        </select>
    {{-- </div>                        
    <div class="form-group row"> --}}
        {{-- <input title="Ingrese Stock desde" class="form-control col-xs-12 col-2 m-1" type="number" id="stock_since" name="stock_since" placeholder="Stock desde..." value={{ isset($inputs['stock_since'])? $inputs['stock_since'] : '' }}>
        <input title="Ingrese Stock hasta" class="form-control col-xs-12 col-2 m-1" type="number" id="stock_to" name="stock_to" placeholder="Stock hasta..." value={{ isset($inputs['stock_to'])? $inputs['stock_to'] : '' }}>
        <input title="Ingrese Fecha desde" class="form-control col-xs-12 col-2 m-1" type="date" id="date_since" name="date_since" placeholder="Fecha desde..." value={{ isset($inputs['date_since'])? $inputs['date_since'] : '' }}>
        <input title="Ingrese Fecha hasta" class="form-control col-xs-12 col-2 m-1" type="date" id="date_to" name="date_to" placeholder="Fecha hasta..." value={{ isset($inputs['date_to'])? $inputs['date_to'] : '' }}> --}}
        <select title="Seleccione alguna Categoria" id="category_id" name="category_id" class="form-control col-xs-12 col-2 m-1">
            <option value=""  {{ !isset($inputs['category_id'])? 'selected':''}}>Categoria...</option>
            @foreach ($categories as $category)
                <option {{ isset($inputs['category_id']) && $inputs['category_id'] == $category->id ? 'selected': ''}} value="{{ $category->id }}"> 
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>