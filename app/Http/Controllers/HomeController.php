<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()) {
            
            $purchases_all = Purchase::where('active',1)
            ->latest()
            ->get();

            $sales_all = Sale::where('active',1)
            ->latest()
            ->get();

            $purchases_month = $this->get_purchases_this_month();
            $sales_month = $this->get_sales_this_month();

            return view('panel.index', compact('purchases_all', 'sales_all', 'purchases_month', 'sales_month'));
        }
        else { 
            return view('vendor.adminlte.auth.login');
        }
    }

    public function get_purchases_this_month(){
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth();
        $endOfMonth = $now->endOfMonth();

        $purchases = Purchase::where('active',1)
                // ->whereBetween('created_at',[$startOfMonth,$endOfMonth])
                ->whereMonth('created_at','=',date('m'))
                ->latest()
                ->get();
        // dd($purchases);
        return $purchases;
    }

    public function get_sales_this_month(){
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth();
        $endOfMonth = $now->endOfMonth();

        $sales = Sale::where('active',1)
                // ->whereBetween('created_at',[$startOfMonth,$endOfMonth])
                ->whereMonth('created_at','=',date('m'))
                ->latest()
                ->get();

        return $sales;
    }

    public function get_data(Request $request){
        if($request->option == 'Y'){
            // $purchases = Purchase::selectRaw('MONTH(received_date) as m, SUM(total_paid) as total')
            //     ->where('received_date','<>',null)
            //     ->whereYear('received_date', date('Y'))
            //     ->where('active',1)
            //     ->groupBy('m');
                // ->get();
            

            $all_out = Purchase::selectRaw('SUM(total_paid) as total')
                ->where('received_date','<>',null)
                ->whereYear('received_date', date('Y'))
                ->where('active',1)
                // ->groupBy('m')
                ->first();
            
            $product_purchase = Purchase::join('purchase_details', 'purchases.id', '=', 'purchase_details.purchase_id')
                ->join('products', 'purchase_details.product_id', '=', 'products.id')
                ->selectRaw('products.id as p_id, SUM(purchase_details.quantity_ordered) as stock_purchased, COUNT(purchase_details.id) as total_purchase, SUM(total_paid) as total_invested')
                ->where('purchases.active',1)
                ->whereYear('purchases.received_date', date('Y'))
                ->groupBy('p_id')
                ->orderBy('stock_purchased', 'desc')
                ->get();
            // dd($product_purchase);
            
            // $sales = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            //     ->selectRaw('MONTH(sales.created_at) as m, SUM(sale_details.quantity * sale_details.price) as total')
            //     ->whereYear('sales.created_at', date('Y'))
            //     ->where('sales.active',1)
            //     ->groupBy('m')
            //     ->get();
            
            $all_in = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->selectRaw('SUM(sale_details.quantity * sale_details.price) as total')
                ->whereYear('sales.created_at', date('Y'))
                ->where('sales.active',1)
                // ->groupBy('m')
                ->first();

            $product_sale = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->join('products', 'sale_details.product_id', '=', 'products.id')
                ->selectRaw('products.id as p_id, SUM(sale_details.quantity) as stock_sold, COUNT(sale_details.id) as total_sales, SUM(sale_details.quantity * sale_details.price) as total_generated')
                ->where('sales.active',1)
                ->whereYear('sales.created_at', date('Y'))
                ->groupBy('p_id')
                ->orderBy('stock_sold', 'desc')
                ->get();

            // dd($product_sale);

            // dd($all_in);
            // $all_out = $purchases;
            // $all_out->selectRaw('SUM(total)');
            // dd($purchases->get());

            // dd($sales);
        }
        else if($request->option == 'M'){
            // $purchases = Purchase::selectRaw('DAY(received_date) as d, SUM(total_paid) as total')
            //     ->where('received_date','<>',null)
            //     ->whereYear('received_date', date('Y'))
            //     ->whereMonth('received_date', date('m'))
            //     ->where('active',1)
            //     ->groupBy('d')
            //     ->get();

            $all_out = Purchase::selectRaw('SUM(total_paid) as total')
                ->where('received_date','<>',null)
                ->whereYear('received_date', date('Y'))
                ->whereMonth('received_date', date('m'))
                ->where('active',1)
                // ->groupBy('d')
                ->first();

            $product_purchase = Purchase::join('purchase_details', 'purchases.id', '=', 'purchase_details.purchase_id')
                ->join('products', 'purchase_details.product_id', '=', 'products.id')
                ->selectRaw('products.id as p_id, SUM(purchase_details.quantity_ordered) as stock_purchased, COUNT(purchase_details.id) as total_purchase, SUM(total_paid) as total_invested')
                ->where('purchases.active',1)
                ->whereYear('purchases.received_date', date('Y'))
                ->whereMonth('purchases.received_date', date('m'))
                ->groupBy('p_id')
                ->orderBy('stock_purchased', 'desc')
                ->get();
            
            // $sales = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            //     ->selectRaw('DAY(sales.created_at) as d, SUM(sale_details.quantity * sale_details.price) as total')
            //     ->whereYear('sales.created_at', date('Y'))
            //     ->whereMonth('sales.created_at', date('m'))
            //     ->where('sales.active',1)
            //     ->groupBy('d')
            //     ->first();

            
            $all_in = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->selectRaw('SUM(sale_details.quantity * sale_details.price) as total')
                ->whereYear('sales.created_at', date('Y'))
                ->whereMonth('sales.created_at', date('m'))
                ->where('sales.active',1)
                // ->groupBy('d')
                ->first();

            $product_sale = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->join('products', 'sale_details.product_id', '=', 'products.id')
                ->selectRaw('products.id as p_id, SUM(sale_details.quantity) as stock_sold, COUNT(sale_details.id) as total_sales, SUM(sale_details.quantity * sale_details.price) as total_generated')
                ->where('sales.active',1)
                ->whereYear('sales.created_at', date('Y'))
                ->whereMonth('sales.created_at', date('m'))
                ->groupBy('p_id')
                ->orderBy('stock_sold', 'desc')
                ->get();
            // dd($sales);
        }
        else {
            // $purchases = Purchase::selectRaw('DAY(received_date) as d, SUM(total_paid) as total')
            //     ->where('received_date','<>',null)
            //     ->where('received_date', '>=', Carbon::now()->startOfWeek())
            //     ->where('active',1)
            //     ->groupBy('d')
            //     ->first();

            $all_out = Purchase::selectRaw('SUM(total_paid) as total')
                ->where('received_date','<>',null)
                ->where('received_date', '>=', Carbon::now()->startOfWeek())
                ->where('active',1)
                // ->groupBy('d')
                ->first();

            $product_purchase = Purchase::join('purchase_details', 'purchases.id', '=', 'purchase_details.purchase_id')
                ->join('products', 'purchase_details.product_id', '=', 'products.id')
                ->selectRaw('products.id as p_id, SUM(purchase_details.quantity_ordered) as stock_purchased, COUNT(purchase_details.id) as total_purchase, SUM(total_paid) as total_invested')
                ->where('purchases.active',1)
                ->where('purchases.received_date','<>',null)
                ->where('purchases.received_date', '>=', Carbon::now()->startOfWeek())
                ->groupBy('p_id')
                ->orderBy('stock_purchased', 'desc')
                ->get();

            // $sales = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            //     ->selectRaw('DAY(sales.created_at) as d, SUM(sale_details.quantity * sale_details.price) as total')
            //     ->where('sales.active',1)
            //     ->where('sales.created_at', '>=', Carbon::now()->startOfWeek())
            //     ->groupBy('d')
            //     ->first();

            $all_in = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->selectRaw('SUM(sale_details.quantity * sale_details.price) as total')
                ->where('sales.active',1)
                ->where('sales.created_at', '>=', Carbon::now()->startOfWeek())
                // ->groupBy('d')
                ->first();
            
            $product_sale = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->join('products', 'sale_details.product_id', '=', 'products.id')
                ->selectRaw('products.id as p_id, SUM(sale_details.quantity) as stock_sold, COUNT(sale_details.id) as total_sales, SUM(sale_details.quantity * sale_details.price) as total_generated')
                ->where('sales.active',1)
                ->where('sales.created_at', '>=', Carbon::now()->startOfWeek())
                ->groupBy('p_id')
                ->orderBy('stock_sold', 'desc')
                ->get();


            // dd($sales);
        }
        $product_sale_info = Product::where('active', 1)
            ->where('id', $product_sale->first()->p_id)
            ->first();

        
        $product_purchase_info = Product::where('active', 1)
            ->where('id', $product_purchase->first()->p_id)
            ->first();
        // dd($product);


        // dd($all_in);

        return response()->json([
            'all_out' => $all_out->total,
            'all_in' => $all_in->total,
            'product_sale' => $product_sale,
            'product_purchase' => $product_purchase,
            'product_sale_info' => $product_sale_info,
            'product_purchase_info' => $product_purchase_info,
        ]);
        // $purchases = Purchase::where('active',1);
        // $purchase_for_days = [];
        
        // $sale_for_days = [];

        // // $purchases->whereMonth('created_at','=',12);
        // // dd($purchases->get());


        // for($i=1; $i<=7; $i++){
        //     $purchases = Purchase::where('active',1);
        //     $purchase_for_days[] = $purchases
        //     ->whereRaw('DAYOFWEEK(created_at) = ?', [$i])
        //     ->get();

        //     $sales = Sale::where('active',1);
        //     $sale_for_days[] = $sales
        //     ->whereRaw('DAYOFWEEK(created_at) = ?', [$i])
        //     ->get();
        // }
        // return response()->json([
        //     'purchases_day' => $purchase_for_days,
        //     'sales_day' => $sale_for_days,
        // ]);
    }

    public function get_data_purch_sale(Request $request){
        
        // dd($request->all());
        if($request->option == 'H'){
            $purchases = Purchase::selectRaw('YEAR(created_at) as y, COUNT(*) as total')
                ->where('active',1)
                ->groupBy('y')
                ->get();

            $sales = Sale::selectRaw('YEAR(created_at) as y, COUNT(*) as total')
                ->where('active',1)
                ->groupBy('y')
                ->get();
        }
        else if($request->option == 'Y'){
            $purchases = Purchase::selectRaw('MONTH(created_at) as m, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->where('active',1)
                ->groupBy('m')
                ->get();
            $sales = Sale::selectRaw('MONTH(created_at) as m, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->where('active',1)
                ->groupBy('m')
                ->get();
        }
        else if($request->option == 'M'){
            $purchases = Purchase::selectRaw('DAY(created_at) as d, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->groupBy('d')
                ->get();
            $sales = Sale::selectRaw('DAY(created_at) as d, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->groupBy('d')
                ->get();
        }
        else {
            $purchases = Purchase::selectRaw('DAY(created_at) as d, COUNT(*) as total')
                ->where('created_at', '>=', Carbon::now()->startOfWeek())
                // ->where('created_at', '<=', Carbon::now()->endOfWeek())
                ->where('active',1)
                ->groupBy('d')
                ->get();
            $sales = Sale::selectRaw('DAY(created_at) as d, COUNT(*) as total')
                ->where('created_at', '>=', Carbon::now()->startOfWeek())
                // ->where('created_at', '<=', Carbon::now()->endOfWeek())
                ->where('active',1)
                ->groupBy('d')
                ->get();

            // dd($sales);
        }


        // dd($purchases);

        return response()->json([
            'purchases' => $purchases,
            'sales' => $sales,
        ]);
    }

    public function get_data_in_out(Request $request){
        if($request->option == 'Y'){
            $purchases = Purchase::selectRaw('MONTH(received_date) as m, SUM(total_paid) as total')
                ->where('received_date','<>',null)
                ->whereYear('received_date', date('Y'))
                ->where('active',1)
                ->groupBy('m');
                // ->get();

            // $all_out = Purchase::selectRaw('SUM(total_paid) as total')
            //     ->where('received_date','<>',null)
            //     ->whereYear('received_date', date('Y'))
            //     ->where('active',1)
            //     // ->groupBy('m')
            //     ->first();
            
            $sales = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->selectRaw('MONTH(sales.created_at) as m, SUM(sale_details.quantity * sale_details.price) as total')
                ->whereYear('sales.created_at', date('Y'))
                ->where('sales.active',1)
                ->groupBy('m')
                ->get();
            
            // $all_in = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            //     ->selectRaw('SUM(sale_details.quantity * sale_details.price) as total')
            //     ->whereYear('sales.created_at', date('Y'))
            //     ->where('sales.active',1)
            //     // ->groupBy('m')
            //     ->first();

            // dd($all_in);
            // $all_out = $purchases;
            // $all_out->selectRaw('SUM(total)');
            // dd($purchases->get());

            // dd($sales);
        }
        else if($request->option == 'M'){
            $purchases = Purchase::selectRaw('DAY(received_date) as d, SUM(total_paid) as total')
                ->where('received_date','<>',null)
                ->whereYear('received_date', date('Y'))
                ->whereMonth('received_date', date('m'))
                ->where('active',1)
                ->groupBy('d')
                ->get();

            // $all_out = Purchase::selectRaw('SUM(total_paid) as total')
            //     ->where('received_date','<>',null)
            //     ->whereYear('received_date', date('Y'))
            //     ->whereMonth('received_date', date('m'))
            //     ->where('active',1)
            //     // ->groupBy('d')
            //     ->get();
            
            $sales = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->selectRaw('DAY(sales.created_at) as d, SUM(sale_details.quantity * sale_details.price) as total')
                ->whereYear('sales.created_at', date('Y'))
                ->whereMonth('sales.created_at', date('m'))
                ->where('sales.active',1)
                ->groupBy('d')
                ->get();

            
            // $all_in = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            //     ->selectRaw('SUM(sale_details.quantity * sale_details.price) as total')
            //     ->whereYear('sales.created_at', date('Y'))
            //     ->whereMonth('sales.created_at', date('m'))
            //     ->where('sales.active',1)
            //     // ->groupBy('d')
            //     ->get();
            // dd($sales);
        }
        else {
            $purchases = Purchase::selectRaw('DAY(received_date) as d, SUM(total_paid) as total')
                ->where('received_date','<>',null)
                ->where('received_date', '>=', Carbon::now()->startOfWeek())
                ->where('active',1)
                ->groupBy('d')
                ->get();

            // $all_out = Purchase::selectRaw('SUM(total_paid) as total')
            //     ->where('received_date','<>',null)
            //     ->where('received_date', '>=', Carbon::now()->startOfWeek())
            //     ->where('active',1)
            //     // ->groupBy('d')
            //     ->get();

            $sales = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->selectRaw('DAY(sales.created_at) as d, SUM(sale_details.quantity * sale_details.price) as total')
                ->where('sales.active',1)
                ->where('sales.created_at', '>=', Carbon::now()->startOfWeek())
                ->groupBy('d')
                ->get();

            // $all_in = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            //     ->selectRaw('SUM(sale_details.quantity * sale_details.price) as total')
            //     ->where('sales.active',1)
            //     ->where('sales.created_at', '>=', Carbon::now()->startOfWeek())
            //     // ->groupBy('d')
            //     ->get();


            // dd($sales);
        }


        // dd($all_in);

        return response()->json([
            'purchases' => $purchases,
            'sales' => $sales,
            // 'all_out' => $all_out->total,
            // 'all_in' => $all_in->total,
        ]);
    }
}
