<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        // Using paginate(10) to match the links() call in the view blade image
        $products = Product::paginate(10);
        return view('product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $product = Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('product.create', compact('users'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('view', $product);
        return view('product.view', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}
