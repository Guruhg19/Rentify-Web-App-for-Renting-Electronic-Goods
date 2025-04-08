<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $categories = \App\Models\Category::all();
        $latest_products = \App\Models\Product::latest()->take(4)->get();
        $random_products = \App\Models\Product::inRandomOrder()->take(4)->get();
        return view('front.index',compact('categories', 'latest_products', 'random_products'));
    }
}
