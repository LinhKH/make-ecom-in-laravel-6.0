<?php

namespace App\Http\View\Composers;

use App\Category;
use Illuminate\View\View;

class FrontPageComposer
{
    private $frontCategories;

    public function __construct()
    {
        // Get All Categories and Sub Categories
        $this->frontCategories = Category::with(['categories' => function($query) {
            $query->withCount('products');
        },'categories.products'])->where('parent_id',0)->get();
        
        foreach ($this->frontCategories as $parentCategory) {
            $parentCategory->products_count = $parentCategory->categories->sum('products_count');
        }
        // $categories = json_decode(json_encode($categories),1);
        // echo "<pre>"; print_r($categories);die;
    }

    public function compose(View $view)
    {
        $view->with('categories', $this->frontCategories);
    }
}
