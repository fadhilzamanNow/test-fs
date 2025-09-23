<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/products?q=...
    public function index(Request $request)
    {
        $q = $request->query('q');
        $perPage = (int) $request->query('per_page', 7);

        $query = Product::query()->orderByDesc('created_at');

        if ($q) {
            $like = "%{$q}%";
            $query->where('name', 'ilike', $like);
        }

        return response()->json($query->paginate($perPage));
    }

    // GET /api/products/{id}
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    // POST /api/products
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product = Product::create([
            'name'       => $data['name'],
            'created_at' => now(),
        ]);

        return response()->json($product, 201);
    }

    // PATCH /api/products/{id}
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product->update($data);
        return response()->json($product);
    }

    // DELETE /api/products/{id}
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Deleted']);
    }
}