<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sale;
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
}
