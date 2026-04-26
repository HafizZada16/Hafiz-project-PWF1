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
        $products = Product::with(['user', 'category'])->paginate(10);
        return view('product.index', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        
        // If user_id is not provided (not an admin or left blank), set it to the current user
        if (!isset($validated['user_id']) || empty($validated['user_id'])) {
            $validated['user_id'] = auth()->id();
        }

        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function create()
    {
        $users = Gate::allows('manage-product') ? User::orderBy('name')->get() : collect();
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('product.create', compact('users', 'categories'));
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

        $product->update($request->validated());

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        $users = Gate::allows('manage-product') ? User::orderBy('name')->get() : collect();
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('product.edit', compact('product', 'users', 'categories'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}
