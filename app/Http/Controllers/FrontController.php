<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookingRequest;

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

    public function brand(Brand $brand){
        $category_id = session()->get('category_id');
        $products = Product::where('brand_id',$brand->id)
        ->where('category_id', $category_id)
        ->latest()
        ->get();
        
        return view('front.gadgets',compact('brand','products'));
    }

    public function details(Product $product){
        return view('front.details',compact('product'));
    }

    public function booking(Product $product){
        $stores = Store::all();
        return view('front.booking',compact('product','stores'));
    }

    public function booking_save(StoreBookingRequest $request, Product $product){
        $bookingData = $request->only(['duration', 'started_at', 'store_id', 'delivery_type', 'address']);
        session($bookingData);
        return redirect()->route('front.checkout', $product->slug);
    }

    public function checkout(Product $product){
        $duration = session('duration');

        $insurrance = 900000;
        $ppn = 0.11;
        $price = $product->price;

        $subTotal = $price * $duration;
        $totalPpn = $subTotal * $ppn;
        $grandTotal = $subTotal + $totalPpn + $insurrance;
        return view('front.checkout',compact('product','grandTotal','subTotal','totalPpn','insurrance'));
    }

    public function checkout_store(){
        
    }

}
