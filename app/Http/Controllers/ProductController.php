<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        // Using paginate(10) to match the links() call in the view blade image
        $products = Product::paginate(10);
        return view('product.index', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

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

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product);

        $validated = $request->validated();

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
