<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with(['productType', 'productImages'])->paginate(10);
        if (request()->wantsJson()) {
            return response()->json([
                'products' => $products,
            ]);
        }
        return inertia('Products/Index', [
            'products' => Product::with(['productType', 'productImages'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if (request()->wantsJson()) {
            return response()->json([
                'product' => $product->load(['productType', 'productImages']),
            ]);
        }
        return inertia('Products/Show', [
            'product' => $product->load(['productType', 'productImages']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Search for a product.
     */

    public function search(Request $request): JsonResponse
    {
        try {
            $products = Product::where('name', 'like', '%' . $request->query('s') . '%')->get();
            if ($products->isEmpty()) {
                return response()->json([
                    'message' => 'No products found for the search query.',
                ], 404);
            }
            return response()->json([
                'products' => $products,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for products.',
            ], 500);
        }
    }
}
