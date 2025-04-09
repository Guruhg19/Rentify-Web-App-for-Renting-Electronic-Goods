<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $categories = \App\Models\Category::all();
        $latest_products = \App\Models\Product::latest()->take(4)->get();
        $random_products = \App\Models\Product::inRandomOrder()->take(4)->get();
        return view('front.index',compact('categories', 'latest_products', 'random_products'));
    }

    public function category(Category $category){
        session()->put('category_id', $category->id);
        return view('front.brands',compact('category'));
    }
}
