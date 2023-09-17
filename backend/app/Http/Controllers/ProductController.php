<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        // Retrieve a list of products
        $products = Product::all();

        return response()->json($products, 200);
    }
    public function getProductById($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $product], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|string', // Validate the 'image' field
            'category' => 'required|string', // Validate the 'category' field
            'status' => 'required|string', // Validate the 'status' field
        ]);

        // Create a new product
        $product = Product::create($validatedData);

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }



    public function update(Request $request, $id)
    {
        // Find the product by ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'stock' => 'integer',
            'image' => 'string',
            'category' => 'string',
            'status' => 'string',
        ]);

        // Update the product with the validated data
        $product->update($validatedData);

        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
    }



    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Delete the product
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 204);
    }

    public function getImage($imageName)
{
    $path = public_path('images/products/' . $imageName);

    if (!file_exists($path)) {
        return response()->json(['error' => 'Image not found'], 404);
    }

    return response()->file($path);
}


}
