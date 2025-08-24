<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return view('user.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('user.products.show', compact('product'));
    }
}
