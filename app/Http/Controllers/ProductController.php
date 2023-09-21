<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'products' =>  ProductResource::collection(Product::with('categories','media')->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        $product->categories()->sync(explode(",", $request->categories) ?? []);

        if ($request->hasFile('image1')) {
            $product
                ->addMediaFromRequest('image1')
                ->usingFileName(Str::uuid())
                ->preservingOriginal()
                ->toMediaCollection('image1');
        }

        if ($request->hasFile('image2')) {
            $product
                ->addMediaFromRequest('image2')
                ->usingFileName(Str::uuid())
                ->preservingOriginal()
                ->toMediaCollection('image2');
        }

        return response()->json([
            'product' => $product
        ]);
    }

    public function search(Request $request)
    {
        $products = Product::with('categories','media')
            ->when($request->name, function ($query, $name) {
                $query->where('products.name', 'like', '%' . $name . '%');
            })
            ->when($request->price, function ($query, $price) {
                $query->where('products.price', $price);
            })
            ->when($request->description, function ($query, $description) {
                $query->where('products.description', 'like', '%' . $description . '%');
            })
            ->when($request->category, function ($query) use ($request) {
                $query->whereHas('categories', function ($query) use ($request) {
                    $query->where('categories.name', 'like', '%' . $request->category . '%');
                });
            })
            ->paginate(20);
        // ->get();

        return response()->json([
            'products' => $products,
        ]);
    }

    /**
     * Remove the specified resources from storage.
     */
    public function destroySeveral(Request $request)
    {
        return response()->json([
            'products' => Product::whereIn('id', $request->products)->delete(),
        ]);
    }
}
