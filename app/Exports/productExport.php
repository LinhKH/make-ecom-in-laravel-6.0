<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class productExport implements WithHeadings,FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $productsData = Product::select('categories.name as category_name','products.product_name', 'products.product_code', 'products.product_color', 'products.price', 'products.created_at')
                                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                                ->where(['products.status' => 1])->orderBy('products.id', 'desc')->get();

        return $productsData;
    }

    public function headings(): array
    {
        return ['Category Name', 'Product Name', 'Product Code', 'Product Color', 'Price', 'Created At'];
    }
}
