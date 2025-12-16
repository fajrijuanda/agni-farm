<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        $perPage = $request->input('per_page', 10);
        if ($perPage === 'all') {
            $perPage = $query->count();
            if ($perPage == 0) $perPage = 10; // Fallback
        }

        $products = $query->ordered()
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::active()->ordered()->get();

        return view('admin.catalog.index', compact('products', 'categories'));
    }

    /**
     * Bulk delete products
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $count = 0;
        foreach ($request->ids as $id) {
            $product = Product::find($id);
            if ($product) {
                // Delete images
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                }
                Storage::disk('public')->deleteDirectory('products/' . $product->id);
                $product->delete();
                $count++;
            }
        }

        return redirect()->route('admin.catalog.index')
            ->with('success', "{$count} produk berhasil dihapus!");
    }

    /**
     * Show form for creating a new product
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.catalog.create', compact('categories'));
    }

    /**
     * Store a new product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'short_description' => 'nullable|string|max:300',
            'full_description' => 'nullable|string',
            'shopee_link' => 'required|url|max:500',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:100',
            'specifications.*.value' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Create product
            $product = Product::create([
                'user_id' => auth()->id(),
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'full_description' => $validated['full_description'] ?? null,
                'shopee_link' => $validated['shopee_link'],
                'is_featured' => $request->boolean('is_featured'),
                'is_active' => $request->boolean('is_active', true),
                'sort_order' => Product::max('sort_order') + 1,
            ]);

            // Upload images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products/' . $product->id, 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $index,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            // Save specifications
            if (!empty($validated['specifications'])) {
                foreach ($validated['specifications'] as $index => $spec) {
                    if (!empty($spec['key']) && !empty($spec['value'])) {
                        ProductSpecification::create([
                            'product_id' => $product->id,
                            'key' => $spec['key'],
                            'value' => $spec['value'],
                            'sort_order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.catalog.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    /**
     * Show product detail
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images', 'specifications', 'user']);
        return view('admin.catalog.show', compact('product'));
    }

    /**
     * Show form for editing a product
     */
    public function edit(Product $product)
    {
        $product->load(['images', 'specifications']);
        $categories = Category::active()->ordered()->get();
        return view('admin.catalog.edit', compact('product', 'categories'));
    }

    /**
     * Update a product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'short_description' => 'nullable|string|max:300',
            'full_description' => 'nullable|string',
            'shopee_link' => 'required|url|max:500',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'existing_images' => 'nullable|array',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:100',
            'specifications.*.value' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Update product
            $product->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'full_description' => $validated['full_description'] ?? null,
                'shopee_link' => $validated['shopee_link'],
                'is_featured' => $request->boolean('is_featured'),
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Handle existing images
            $existingImageIds = $request->input('existing_images', []);
            $imagesToDelete = $product->images()->whereNotIn('id', $existingImageIds)->get();

            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            // Upload new images
            if ($request->hasFile('images')) {
                $maxOrder = $product->images()->max('sort_order') ?? -1;
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products/' . $product->id, 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $maxOrder + $index + 1,
                        'is_primary' => $product->images()->count() === 0 && $index === 0,
                    ]);
                }
            }

            // Update specifications
            $product->specifications()->delete();
            if (!empty($validated['specifications'])) {
                foreach ($validated['specifications'] as $index => $spec) {
                    if (!empty($spec['key']) && !empty($spec['value'])) {
                        ProductSpecification::create([
                            'product_id' => $product->id,
                            'key' => $spec['key'],
                            'value' => $spec['value'],
                            'sort_order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.catalog.index')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Delete a product
     */
    public function destroy(Product $product)
    {
        // Delete all images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete product directory
        Storage::disk('public')->deleteDirectory('products/' . $product->id);

        $product->delete();

        return redirect()->route('admin.catalog.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Produk berhasil {$status}!");
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        $status = $product->is_featured ? 'ditambahkan ke' : 'dihapus dari';
        return back()->with('success', "Produk berhasil {$status} featured!");
    }

    /**
     * Duplicate a product
     */
    public function duplicate(Product $product)
    {
        DB::beginTransaction();

        try {
            $newProduct = $product->replicate();
            $newProduct->name = $product->name . ' (Copy)';
            $newProduct->slug = Str::slug($newProduct->name);
            $newProduct->view_count = 0;
            $newProduct->sort_order = Product::max('sort_order') + 1;
            $newProduct->save();

            // Duplicate images
            foreach ($product->images as $image) {
                $newImage = $image->replicate();
                $newImage->product_id = $newProduct->id;

                // Copy file
                $newPath = 'products/' . $newProduct->id . '/' . basename($image->image_path);
                Storage::disk('public')->copy($image->image_path, $newPath);
                $newImage->image_path = $newPath;
                $newImage->save();
            }

            // Duplicate specifications
            foreach ($product->specifications as $spec) {
                $newSpec = $spec->replicate();
                $newSpec->product_id = $newProduct->id;
                $newSpec->save();
            }

            DB::commit();

            return redirect()->route('admin.catalog.edit', $newProduct)
                ->with('success', 'Produk berhasil diduplikasi!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal duplikasi produk: ' . $e->getMessage());
        }
    }

    /**
     * Delete a product image
     */
    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Set primary image
     */
    public function setPrimaryImage(ProductImage $image)
    {
        $image->setAsPrimary();
        return response()->json(['success' => true]);
    }
}
