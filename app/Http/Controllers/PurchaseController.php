<?php

namespace App\Http\Controllers;

use App\Mail\PurchaseCancel;
use App\Mail\PurchaseGenerate;
use App\Mail\PurchaseRegister;
use App\Mail\PurchaseUpdate;
use App\Mail\SendMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
{
    public function index(){
        $purchases = Purchase::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); //Convierte los datos extraidos de la BD en un array
        $suppliers = Supplier::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); 
            // Retornamos una vista y enviamos la variable 'sales'
        return view('panel.purchases.crud.index', compact('purchases', 'suppliers'));
    
    }

    public function create(){
        // Creamos un producto nuevo para cargarle datos
        $purchase = new Purchase();

        $date = date("d-m-Y");

        // Recuperamos todas las categorias de la BD
        $suppliers = Supplier::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get();

        return view('panel.purchases.crud.create', compact('purchase', 'suppliers', 'date'));
    
    
    }

    public function store(Request $request){
        $request->validate([
            // 'date' => 'required',
            'supplier_id' => 'required'
        ]);

        $purchase = new Purchase();

        if ($request->get('active')) {
            $purchase->active = 1;
        }
        else {
            $purchase->active = 0;
        }
        $purchase->supplier_id = $request->get('supplier_id');

        // Almacena la info del saleo en la BD
        $purchase->save();

        return redirect()
            ->route('purchase.index')
            ->with('alert', 'Compra nro:"' . $purchase->id . '" agregada exitosamente.');
    
    
    }

    public function show(Purchase $purchase){
        return view('panel.purchases.crud.show', compact('purchase'));
    
    }

    public function show_edit(Purchase $purchase)
    {
        $date = $purchase->created_at;
        
        $suppliers = Supplier::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get();

        $back = true;

        return view('panel.purchases.crud.edit', compact('purchase', 'suppliers', 'date', 'back'));
    }

    public function edit(Purchase $purchase){

        $date = $purchase->created_at;

        // Recuperamos todas las categorias de la BD
        $suppliers = Supplier::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get();

        return view('panel.purchases.crud.edit', compact('purchase', 'suppliers', 'date'));
    
    }

    public function update_show(Request $request, Purchase $purchase){
        $request->validate([
            // 'date' => 'required',
            'supplier_id' => 'required'
        ]);

        if ($request->get('active')) {
            $purchase->active = 1;
        }
        else {
            $purchase->active = 0;
        }

        if ($request->has('received_date')) {
            $purchase->received_date = $request->received_date;
        }
        
        if ($request->has('total_paid')) {
            $purchase->total_paid = $request->total_paid;
        }

        $purchase->supplier_id = $request->get('supplier_id');

        // Almacena la info de la venta en la BD
        $purchase->update();

        return redirect()
            ->route('purchase.show', compact('purchase'))
            ->with('alert', 'Compra nro:"' . $purchase->id . '" modificada exitosamente.');
    
    }

    public function update(Request $request, Purchase $purchase){
        $request->validate([
            // 'date' => 'required',
            'supplier_id' => 'required'
        ]);

        if ($request->get('active')) {
            $purchase->active = 1;
        }
        else {
            $purchase->active = 0;
        }

        if ($request->has('received_date')) {
            $purchase->received_date = $request->received_date;
        }
        if ($request->has('total_paid')) {
            $purchase->total_paid = $request->total_paid;
        }

        $purchase->supplier_id = $request->get('supplier_id');

        // Almacena la info de la venta en la BD
        $purchase->update();

        return redirect()
            ->route('purchase.index')
            ->with('alert', 'Compra nro:"' . $purchase->id . '" modificada exitosamente.');
    
    }

    public function destroy(Purchase $purchase){

        $diff = \Carbon\Carbon::parse($purchase->created_at->format('Y-m-d'))->diffInDays(\Carbon\Carbon::now());
        if($diff <= 1){
            $purchase->active = 0;
            foreach($purchase->details as $detail){
                $detail->active = 0;
                $detail->update();
            }
            $purchase->update();
            return redirect()
                    ->route('purchase.index')
                    ->with('alert', 'Compra nro: "'.$purchase->id.'" cancelada exitosamente.');
        }
        else {
            return redirect()
                    ->route('purchase.index')
                    ->with('error', 'Compra nro: "'.$purchase->id.'" no se puede cancelar, tiempo limite superado.');
    
        }
    
    }

    public function generate_index(){
        
        // $query = Product::query();

        // $query->whereRaw('stock <= minstock');
        
        
        // $products = $query->where('active', 1)
        $products = Product::where('active', 1)->orderBy('name','asc')->get();

        $categories = Category::where('active', 1)->orderBy('name','asc')->get();
        
        $suppliers = Supplier::where('active', 1)->orderBy('companyname','asc')->get();
        
        return view('panel.purchases.generate.index', compact('products', 'categories', 'suppliers'));
    
    }

    public function generate_action(Request $request){
        
        try{
            // $request->validate([
            // ]);
                //in_array("banana", $frutas)

            $purchases = [];
            $purchases_id = [];
            $suppliers = [];
            $msj = '';
            
            for ($i = 0; $i<$request->qty;$i++){
                $product = Product::where('active',1)
                    ->where('id',$request->$i['product_id'])->first();
                    // dd($product->supplier_id);
                // dd(!in_array($product->supplier_id, $suppliers));
                if(!in_array($product->supplier_id, $suppliers)){
                    $suppliers[] = $product->supplier_id;
                    $purchase = new Purchase();
                    $purchase->supplier_id = $product->supplier_id;
                    $purchase->save();
                    $purchases[] = $purchase;
                    $purchases_id[] = $purchase->id;
                }
                
                $detail = new PurchaseDetail();
                $detail->product_id = $product->id;
                $detail->quantity_ordered = $request->$i['quantity'];
                
                $pos = array_search($product->supplier_id, $suppliers);
                $purchase = $purchases[$pos];
                // dd($purchase);
                $detail->purchase_id = $purchase->id;
                $detail->save();  
                
                // dd('entro');                  
            }
            // dd($purchases);
            foreach($purchases as $purchase){
                // $purchase->save();
                
                $data = array(
                    'companyname' => $purchase->supplier->companyname,
                    'email' => $purchase->supplier->email,
                    'fecha creacion' => $purchase->created_at,
                    'details' => $purchase->details,
                    'supplier' => $purchase->supplier, 
                    'purchase' => $purchase,
                );

                $pdf = PDF::loadView('emails.purchase_generate', compact('data'));
                $data['filename'] = 'OC_'.$data['companyname'].'_'.$data['fecha creacion'].'.pdf';
                $data['filename'] = str_replace(' ','_',$data['filename']);
                $data['filename'] = str_replace(':','',$data['filename']);
                $data['filename'] = str_replace('-','_',$data['filename']);
                
                $pdfPath = 'pdfs/'.$data['filename'];
                Storage::put($pdfPath, $pdf->output());
                $data['path'] = Storage::url($pdfPath);
                try {
                    Mail::to($data['email'])->send(new PurchaseGenerate($data));
                }
                catch (Exception $e) {
                    $msj += 'Falló envio de email para: '.$purchase->supplier->companyname;
                }
            }

            // foreach(){

            // }

            // $query = Supplier::query();

            // $suppliers = $query->where('active',1)->get();
            
            // $b = 0;
            // $msj = '';
            // $purchase = new Purchase();
            // $purchases_id = [];
            // foreach ( $suppliers as $supplier ) {
            //     if ( $b==1 ) {
            //         $purchase = new Purchase();
            //         $b=0;
            //     }
            //     $purchase->supplier_id = $supplier->id;
                
            //     for ($i = 0; $i<$request->qty;$i++){
            //         $product = Product::where('id',$request->$i['product_id'])->first();
                    
            //         if ($product->supplier_id == $supplier->id){
                        
            //             $detail = new PurchaseDetail();
            //             $detail->product_id = $product->id;
            //             // dd($request);
            //             $detail->quantity_ordered = $request->$i['quantity'];
            //             if($b==0){
            //                 $purchase->save();
            //                 $b=1;
            //                 $purchases_id[] = $purchase->id;
            //             }
            //             $detail->purchase_id = $purchase->id;
            //             $detail->save();
            //         }
            //     }
                
            //     if ( $b==1 ) {
                    
            //         $data = array(
            //             'companyname' => $purchase->supplier->companyname,
            //             'email' => $purchase->supplier->email,
            //             'fecha creacion' => $purchase->created_at,
            //             'details' => $purchase->details,
            //             'supplier' => $purchase->supplier, 
            //             'purchase' => $purchase,
            //         );

            //         // dd('llego');
            //         $pdf = PDF::loadView('emails.purchase_generate', compact('data'));
            //         $data['filename'] = 'OC_'.$data['companyname'].'_'.$data['fecha creacion'].'.pdf';
            //         $data['filename'] = str_replace(' ','_',$data['filename']);
            //         $data['filename'] = str_replace(':','',$data['filename']);
            //         $data['filename'] = str_replace('-','_',$data['filename']);
                    
            //         $pdfPath = 'pdfs/'.$data['filename'];
            //         Storage::put($pdfPath, $pdf->output());
            //         $data['path'] = Storage::url($pdfPath);
            //         try {
            //             Mail::to($data['email'])->send(new PurchaseGenerate($data));
            //         }
            //         catch (Exception $e) {
            //             $msj += 'Falló envio de email para: '.$purchase->supplier->companyname;
            //         }
            //     }
                
            // }
            return response()->json([
                'msj'=> $msj,
                'purchases' => $purchases_id,
            ]);
        }
        catch(Exception $e){
            dd($e);
            return response()->json([
                'msj'=> $e,
                'purchases' => null,
            ]);
        }

    }
    
    public function register_index(){
        
        $suppliers = Supplier::where('active', 1)->latest()->get();
        $purchases = Purchase::where('active', 1)
        ->whereNull('received_date')
        ->orderBy('created_at','desc')
        ->get();
        
        
        return view('panel.purchases.register.index', compact('purchases', 'suppliers'));
    
    }
    
    public function register_action(Request $request){
        // dd($request);
        for ($i = 0; $i<$request->qty;$i++){

            $detail = PurchaseDetail::where('id',$request->$i['id'])->first();
            $detail->quantity_received = $request->$i['quantity_received'];
            $detail->cost_price = $request->$i['cost_price'];
            
            if($detail->quantity_received > 0){
                $product = Product::where('active',1)
                ->where('id',$detail->product_id)->first();

                $product->stock += $detail->quantity_received;
                $product->update();
            }
            $detail->update();    
        }
        if($request->qty > 0){
            $i = 0;
            $detail = PurchaseDetail::where('id',$request->$i['id'])->first();
            $purchase = Purchase::where('active',1)->where('id',$detail->purchase_id)->first();
            $purchase->received_date = now()->format('Y-m-d H:i:s');
            $purchase->total_paid = $request->total_paid;
            $purchase->update();
            
            $data = array(
                'details' => $purchase->details,
                'supplier' => $purchase->supplier, 
                'purchase' => $purchase,
            );
            
            $pdf = PDF::loadView('emails.purchase_register', compact('data'));
            $data['filename'] = 'OC_'.$data['supplier']->companyname.'_'.$data['purchase']->received_date.'.pdf';
            $data['filename'] = str_replace(' ','_',$data['filename']);
            $data['filename'] = str_replace(':','',$data['filename']);
            $data['filename'] = str_replace('-','_',$data['filename']);
            
            $pdfPath = 'pdfs/'.$data['filename'];
            Storage::put($pdfPath, $pdf->output());
            
            $data['path'] = Storage::url($pdfPath);
            try {
                Mail::to($data['supplier']->email)->send(new PurchaseRegister($data));
                
            }
            catch (Exception $e) {
                // dd($e);
                return response()->json([
                    'msj'=> 'Falló envio de email',
                ]);
            }
            
        }
        
        return response()->json([
            'msj'=> 'Respuesta',
        ]);
    }

    public function export_file_purchase($purchase, $action){
        $columns = ['id','product_id','quantity_ordered'];
        $headings = ['ID','NOMBRE PROD.','CANT. SOLICITADA'];
            
        if ($action == 'excel') {
            $headings = ['ID','NOMBRE PROD.','CANT. SOLICITADA'];
            $content = $purchase->details;
            // return Excel::download(new SaleExport($content,$columns, $headings),'sale_'.$purchase->created_at->format('Y_m_d').'.xlsx');
        }
        else if ($action == 'pdf') {
            // $content = $this->filter_gral($request)->latest()->get();
            $content = $purchase->details;
            return $this->export_pdf($content, $purchase, 'Comprobante de Orden de compra ', 'Compra nro: '.$purchase->id, 'purchase_voucher_'.$purchase->id.'_'.$purchase->created_at->format('Y_m_d'), $columns, $headings);
        }
    }

    public function export_file_many_purchase($purchases, $action){
        $columns = ['id','product_id','quantity_ordered'];
        $headings = ['ID','NOMBRE PROD.','CANT. SOLICITADA'];
            
        if ($action == 'excel') {
            $headings = ['ID','NOMBRE PROD.','CANT. SOLICITADA'];
        }
        else if ($action == 'pdf') {
            $data = [
                'purchases' => $purchases,
                'columns' => $columns,
                'headings' => $headings,
            ];
            
            $pdf = PDF::loadView('pdf.purchase_many_voucher', $data);
            $today = new Date();
            $file_title = 'OsC_'.Carbon::now()->format('Y_m_d_H_i_s');

            return $pdf->download($file_title.'.pdf');
        }
    }

    public function export_pdf(Collection $content, $purchase, string $title, string $subtitle, string $file_title, $columns, $headings){
        // $total = PurchaseDetail::selectRaw('SUM(quantity * price) as total')->where('active',1)->where('sale_id', $purchase->id)->first()->total;
        // dd($total);
        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'details' => $content,
            'columns' => $columns,
            'headings' => $headings,
            'purchase' => $purchase,
            'supplier' => $purchase->supplier,
        ];
        
        $pdf = PDF::loadView('pdf.purchase_voucher', $data);
        
        return $pdf->download($file_title.'.pdf');
        // dd('llego');
    }
    
    public function cancel_action(Request $request){
        if ($request->has('id')){
            $purchase = Purchase::where('id', $request->id)->first();
            $diff = \Carbon\Carbon::parse($purchase->created_at->format('Y-m-d'))->diffInDays(\Carbon\Carbon::now());
            if($diff <= 1){

            

                $data = array(
                    'details' => $purchase->details,
                    'supplier' => $purchase->supplier, 
                    'purchase' => $purchase,
                );
                try {
                    Mail::to($data['supplier']->email)->send(new PurchaseCancel($data));
                    
                    foreach($purchase->details as $detail){
                        $detail->active = 0;
                        $detail->save();
                    }
        
                    $purchase->active = 0;
                    $purchase->save();
                }
                catch (Exception $e) {
                    // dd($e);
                    return response()->json([
                        'error'=> 'Falló envio de email, pero se almaceno la orden',
                    ]);
                }


                return response()->json([
                    'msj' => 'Se Cancelo correctamente',
                ]);
            }
            else{
                return response()->json([
                    'error' => 'No se pudo cancelar, debido a que supero el timepo limite',
                ]);
            }
        }
        else {
            // return new Exception('No se pudo cancelar la orden de compra');
            return response()->json([
                'error' => 'No se pudo cancelar la orden de compra',
            ]);
        }
    }

    public function update_action(Request $request){
        if($request->qty > 0){
            // dd($request);
            $purchase = Purchase::where('id', $request->purchase_id)->first();
            $diff = \Carbon\Carbon::parse($purchase->created_at->format('Y-m-d'))->diffInDays(\Carbon\Carbon::now());
            if($diff <= 1){
                foreach($purchase->details as $details){
                    $details->delete();
                }
                
                for($i = 0; $i < $request->qty; $i++){
                    $detail = new PurchaseDetail();
                    $detail->purchase_id = $purchase->id;
                    $detail->product_id = $request->$i['product_id'];
                    $detail->quantity_ordered = $request->$i['quantity_ordered'];
                    $detail->save();
                }
                $purchase->touch();
                $purchase->save();

                $data = array(
                    'details' => $purchase->details,
                    'supplier' => $purchase->supplier, 
                    'purchase' => $purchase,
                );

                $pdf = PDF::loadView('emails.purchase_update', compact('data'));
                $data['filename'] = 'OC_UPDATE_'.$data['supplier']->companyname.'_'.$data['purchase']->received_date.'.pdf';
                $data['filename'] = str_replace(' ','_',$data['filename']);
                $data['filename'] = str_replace(':','',$data['filename']);
                $data['filename'] = str_replace('-','_',$data['filename']);
                
                $pdfPath = 'pdfs/'.$data['filename'];
                Storage::put($pdfPath, $pdf->output());
                
                $data['path'] = Storage::url($pdfPath);

                try {
                    Mail::to($data['supplier']->email)->send(new PurchaseUpdate($data));
                }
                catch(Exception $e){
                    return response()->json([
                        'msg' =>'Se Modifico la compra con exito',
                        'error' => 'No se pudo enviar el email',
                    ]); 
                }

                return response()->json([
                    'msg' =>'Se Modificó la compra con exito',
                ]);
            }
            else{
                

                return response()->json([
                    'error' =>'No se puede modificar la compra, porque excede el tiempo limite',
                ]);
            }
        }
        else {
            return response()->json([
                'msg' => 'No Se Modificó la compra, porque no habian detalles',
            ]);
        }

    }

    public function filter_async_products(Request $request){
        
        $query = Product::query();

        if ($request->has('code') && Str::length((trim($request->code)))>0) {
            $query->where('code', 'like' ,'%'.$request->code.'%');
        }
        if ($request->has('name') && Str::length((trim($request->name)))>0) {
            $query->where('name', 'like' ,'%'.$request->name.'%');
        }
        if ($request->has('supplier_id') && Str::length((trim($request->supplier_id)))>0) {
            $query->where('supplier_id', '=' ,$request->supplier_id);
        }
        if (Str::length((trim($request->code))) == 0 && Str::length((trim($request->name))) == 0 && Str::length((trim($request->supplier_id))) == 0) {
            $query->whereRaw('stock <= minstock');
        }
    
        $products = $query
            ->where('active',1)
            ->latest()
            ->get();
            
        return response()->json(
            [
                'products' => $products,
            ]
        );
        
    }
    
    public function filter_async_purchases_register(Request $request){
        $query = Purchase::query();
        // dd($request->all());

        $query->whereNull('received_date');

        if ($request->has('supplier_id') && $request->supplier_id != null) {
            $query->where('supplier_id', '=' ,$request->supplier_id);
        }
        if ($request->has('date_since') && $request->date_since != null) {
            $query->where('created_at', '>=' ,$request->date_since);
        }
        if ($request->has('date_to') && $request->date_to != null) {
            $date_to = Carbon::createFromFormat('Y-m-d',$request->date_to )->startOfDay()->addDay()->toDateTimeString();
            $query->where('created_at','<', $date_to);
            // $query->where('created_at', '<=' ,$request->date_to);
        }

        
        // dd($query->get());
        $purchases = $query
            ->where('active',1)
            ->orderBy('created_at','desc')
            ->get();

        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();
        
        return response()->json(
            [
                'purchases' => $purchases,
                'suppliers' => $suppliers,
            ]
        );
        
    }

    public function filter_async(Request $request){
        
        $query = Purchase::query();

        if ($request->has('id') && Str::length((trim($request->id)))>0) {
            $query->where('id', '=' ,$request->id);
        }
        if ($request->has('supplier_id') && Str::length((trim($request->supplier_id)))>0) {
            $query->where('supplier_id', '=' ,$request->supplier_id);
        }
        if ($request->has('date_from') && Str::length((trim($request->date_from)))>0) {
            $query->where('created_at', '>=' ,$request->date_from);
        }
        if ($request->has('date_to') && Str::length((trim($request->date_to)))>0) {
            $query->where('created_at', '<=' ,$request->date_to);
        }
    
        $purchases = $query
            ->where('active',1)
            ->latest()
            ->get();
        

        $suppliers = Supplier::where('active',1)
        ->latest()
        ->get();

        return response()->json(
            [
                'purchases' => $purchases,
                'suppliers' => $suppliers,
            ]
        );
        
    }

    public function filter_async_id(Request $request){
        
        $query = Purchase::query();

        if ($request->has('id') && Str::length((trim($request->id)))>0) {
            $query->where('id', '=' ,$request->id);
        }
    
        $purchase = $query
            ->where('active',1)
            ->first();
        
        $details = $purchase->details()->get();
        // dd($details);
        

        $suppliers = Supplier::where('active',1)
        ->latest()
        ->get();

        $products = Product::where('active',1)
        ->latest()
        ->get();


        return response()->json(
            [
                'purchase' => $purchase,
                'suppliers' => $suppliers,
                'details' => $details,
                'products' => $products,
            ]
        );
        
    }

    public function test_pdf(){
        $purchase = Purchase::where('id',72)->first();

        $data = array(
            'companyname' => $purchase->supplier->companyname,
            'email' => $purchase->supplier->email,
            'fecha creacion' => $purchase->created_at,
            'details' => $purchase->details,
            'supplier' => $purchase->supplier, 
            'purchase' => $purchase,
        );

        $pdf = PDF::loadView('emails.purchase_generate', compact('data'));

        $data['filename'] = 'OC_'.$data['companyname'].'_'.$data['fecha creacion'].'.pdf';
        $data['filename'] = str_replace(' ','_',$data['filename']);
        $data['filename'] = str_replace(':','',$data['filename']);
        $data['filename'] = str_replace('-','_',$data['filename']);
        
        $pdfPath = 'pdfs/'.$data['filename'];
        Storage::put($pdfPath, $pdf->output());
    
        $data['path'] = Storage::url($pdfPath);
        return $pdf->stream($data['filename']);
    }


}
