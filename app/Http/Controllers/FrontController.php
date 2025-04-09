<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Transaction;

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
        session()->put('product_id', $product->id);
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


    public function checkout_store(StorePaymentRequest $request){
        $bookingData = session()->only(['duration', 'started_at', 'store_id', 'delivery_type', 'address','product_id']);

        $duration = (int) $bookingData['duration'];
        $startedDate = Carbon::parse($bookingData['started_at']);

        $productDetails = Product::find($bookingData['product_id']);
        if(!$productDetails){
            return redirect()->back()->withErrors(['product_id' => 'Product Not Found']);
        }
        $insurrance = 900000;
        $ppn = 0.11;
        $price = $productDetails->price;

        $subTotal = $price * $duration;
        $totalPpn = $subTotal * $ppn;
        $grandTotal = $subTotal + $totalPpn + $insurrance;

        $bookingTransactionId = null;

        // Closure based database Transaction
        DB::transaction(function() use ($request, &$bookingTransactionId, $duration, $bookingData, $grandTotal, $productDetails, $startedDate){
            $validated = $request->validated();

            if($request->hasFile('proof')){
                $proofPath = $request->file('proof')->store('proofs','public');
                $validated['proof'] = $proofPath;
            }

            $endedDate = $startedDate->copy()->addDays($duration);

            $validated['started_at'] = $startedDate;
            $validated['ended_at'] = $endedDate;
            $validated['duration'] = $duration;
            $validated['total_amount'] = $grandTotal;
            $validated['store_id'] = $bookingData['store_id'];
            $validated['product_id'] = $productDetails->id;
            $validated['delivery_type'] = $bookingData['delivery_type'];
            $validated['address'] = $bookingData['address'];
            $validated['is_paid'] = false;
            $validated['trx_id'] = Transaction::generateUniqueTrxId();

            $newBooking = Transaction::create($validated);
            $bookingTransactionId = $newBooking->id;
        });

        return redirect()->route('front.success.booking', ['transaction' => $bookingTransactionId]);

    }

}
