<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): View
    {
        $request = request();
        $availableMinPrice = (float) (Product::min('selling_price') ?? 0);
        $availableMaxPrice = (float) (Product::max('selling_price') ?? 0);

        if ($availableMaxPrice <= $availableMinPrice) {
            $availableMaxPrice = $availableMinPrice + 1;
        }

        $minPrice = is_numeric($request->query('price_min'))
            ? (float) $request->query('price_min')
            : $availableMinPrice;
        $maxPrice = is_numeric($request->query('price_max'))
            ? (float) $request->query('price_max')
            : $availableMaxPrice;

        $minPrice = min(max($minPrice, $availableMinPrice), $availableMaxPrice);
        $maxPrice = min(max($maxPrice, $availableMinPrice), $availableMaxPrice);

        if ($minPrice > $maxPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        $categoryIds = collect((array) $request->query('categories', []))
            ->filter(fn ($id) => filter_var($id, FILTER_VALIDATE_INT) !== false)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $brandIds = collect((array) $request->query('brands', []))
            ->filter(fn ($id) => filter_var($id, FILTER_VALIDATE_INT) !== false)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $stockStatus = $request->query('stock_status', '');
        $status = $request->query('status', '');

        $query = Product::with(['category', 'brand'])
            ->whereBetween('selling_price', [$minPrice, $maxPrice])
            ->when($categoryIds, fn ($query) => $query->whereIn('category_id', $categoryIds))
            ->when($brandIds, fn ($query) => $query->whereIn('brand_id', $brandIds));

        if ($stockStatus === 'in_stock') {
            $query->where('stock_quantity', '>', 0);
        } elseif ($stockStatus === 'low_stock') {
            $query->where('stock_quantity', '>', 0)
                ->whereColumn('stock_quantity', '<=', 'min_stock');
        } elseif ($stockStatus === 'out_of_stock') {
            $query->where('stock_quantity', '<=', 0);
        }

        if (in_array($status, ['Active', 'Inactive'], true)) {
            $query->where('status', $status);
        }

        $products = $query->orderByDesc('id')->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('dashboard.products.index', compact(
            'products',
            'categories',
            'brands',
            'categoryIds',
            'brandIds',
            'stockStatus',
            'status',
            'availableMinPrice',
            'availableMaxPrice',
            'minPrice',
            'maxPrice'
        ));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('dashboard.products.create', compact('categories', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $validatedData['image'] = $request->file('image')->store('product_images', 'public');
            }

            Product::create($validatedData);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product added successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Product could not be added.');
        }
    }

    public function show(Product $product){
        return view('dashboard.products.show', ['product' => $product]);
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('dashboard.products.edit', compact('categories', 'brands', 'product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $validatedData['image'] = $request->file('image')->store('product_images', 'public');
            }

            $product->update($validatedData);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Product could not be updated.');
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);

        try {
            Excel::import(
                new ProductsImport,
                $request->file('file')
            );

            return redirect()
                ->route('product.index')
                ->with('success', 'Products imported successfully.');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->failures())
                ->withInput();
        }
    }
}
