<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Banner;

class IndexController extends Controller
{
    public function index(){

        $productsAll = Product::inRandomOrder()->where('status',1)->where('feature_item',1)->paginate(3);

        $banners = Banner::where('status','1')->get();
        
		// Meta tags
		$meta_title = "E-shop Sample Website";
		$meta_description = "Online Shopping Site for Men, Women and Kids Clothing";
		$meta_keywords = "eshop website, online shopping, men clothing";
    	return view('index')->with(compact('productsAll','banners','meta_title','meta_description','meta_keywords'));
    }
}
