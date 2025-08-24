<?php

namespace App\Http\Controllers\User;

use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    // Hiển thị danh sách danh mục cho user
    public function index()
    {
        $categories = Category::all();
        return view('user.categories.index', compact('categories'));
    }
}
