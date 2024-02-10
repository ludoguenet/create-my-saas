<?php

namespace App\Http\Controllers\Subscribe;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $products = Product::all();

        return view('subscribe.create', [
            'intent' => auth()->user()->createSetupIntent(),
            'products' => $products,
        ]);
    }
}
