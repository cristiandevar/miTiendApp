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
    var $columns;
    var $headings;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(Builder $content, $columns, $headings)
    {
        $this->content = $content;
        $this->columns = $columns;
        $this->headings = $headings;
    }

    public function collection()
    {
        $this->content = $this->content->select($this->columns)->latest()->get();
        foreach ($this->content as $element) {
            $element->category_id = Category::find($element->category_id)->name;
            $element->supplier_id = Supplier::find($element->supplier_id)->companyname;
        }
        return $this->content;

    }

    public function headings(): array
    {
        return $this->headings;
    }
}
