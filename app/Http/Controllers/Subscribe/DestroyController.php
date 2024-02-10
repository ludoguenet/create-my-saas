<?php

namespace App\Http\Controllers\Subscribe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        auth()->user()->subscription()->cancel();

        return redirect()->route('dashboard');
    }
}
