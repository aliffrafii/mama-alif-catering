<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected array $categories = [
        1 => 'Nasi Box',
        2 => 'Prasmanan',
        3 => 'Nasi Tumpeng',
    ];

    public function index(Request $request)
    {
        $query = Product::orderByDesc('created_at');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::pluck('name', 'id_categories');

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        return view('admin.products.create', ['categories' => $this->categories]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        $validated = $this->prepareData($request, $validated);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => $this->categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request);
        $validated = $this->prepareData($request, $validated);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'category_id' => 'required|integer',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'max_isian'   => 'nullable|integer|min:0',
            'menu_items'  => 'nullable|string',
        ]);
    }

    private function prepareData(Request $request, array $validated): array
    {
        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Susun menu_options sesuai kategori
        if ($validated['category_id'] == 1 && !empty($validated['max_isian'])) {
            $validated['menu_options'] = ['max_isian' => (int) $validated['max_isian']];
        } elseif ($validated['category_id'] == 2 && !empty($validated['menu_items'])) {
            $validated['menu_options'] = [
                'items' => collect(explode("\n", $validated['menu_items']))
                    ->map(fn($i) => trim($i))
                    ->filter()
                    ->values()
                    ->all(),
            ];
        } else {
            $validated['menu_options'] = null;
        }

        unset($validated['max_isian'], $validated['menu_items']);

        return $validated;
    }
}
