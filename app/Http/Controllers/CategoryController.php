<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'categories' =>  Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        return response()->json([
            'category' => Category::create($request->validated())
        ]);
    }

    public function search(Request $request)
    {
        $categories = Category::when($request->name, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })->get();

        return response()->json([
            'categories' =>  CategoryResource::collection($categories),
        ]);
    }
}
