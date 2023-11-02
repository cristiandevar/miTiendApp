<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;

class ProductsExport implements FromCollection, WithHeadings
{
    var $content;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(Builder $content)
    {
        $this->content = $content;
    }

    public function collection()
    {
        // $query = Product::query();
        
        // if ($this->request) {
            
        //     if ($this->request->has('name') && Str::length((trim($this->request->name)))>0) {
        //         $query->where('name','like', '%'.$this->request->name.'%');
        //     }
        //     if ($this->request->has('supplier_id') && $this->request->supplier_id) {
        //         $query->where('supplier_id', $this->request->supplier_id);
        //     }
        //     if ($this->request->has('category_id') && $this->request->category_id) {
        //         $query->where('category_id', $this->request->category_id);
        //     }
        //     if ($this->request->has('price_since') && $this->request->price_since) {
        //         $query->where('price','>=', $this->request->price_since);
        //     }
        //     if ($this->request->has('price_to') && $this->request->price_to) {
        //         $query->where('price','<=', $this->request->price_to);
        //     }
        //     if ($this->request->has('date_since') && $this->request->date_since) {
        //         $query->where('created_at','>=', $this->request->date_since);
        //     }
        //     if ($this->request->has('date_to') && $this->request->date_to) {
        //         $date_to = Carbon::createFromFormat('Y-m-d',$this->request->date_to )->startOfDay()->addDay()->toDateTimeString();
        //         $query->where('created_at','<', $date_to);
        //     }

        // }
        // $aux = $query->select('id','name','price','category_name','supplier_id')->get();
        // dd($aux);
    
        // return $query->select('id','name','price','category_id','supplier_id')->get();
        $this->content = $this->content->select('id','name','price','category_id','supplier_id')->latest()->get();
        foreach ($this->content as $element) {
            $element->category_id = Category::find($element->category_id)->name;
            $element->supplier_id = Supplier::find($element->supplier_id)->companyname;
        }
        return $this->content;

    }

    public function headings(): array
    {
        return ["ID", "NOMBRE DEL PRODUCTO", "PRECIO", "CATEGORIA", 'PROVEEDOR'];
    }
}
