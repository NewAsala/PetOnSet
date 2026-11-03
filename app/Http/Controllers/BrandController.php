<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    public function index (){
        $brands = Brand::paginate(10);

        return view('dashboard.brands.index',['brands'=>$brands]);
    }

    public function store(BrandRequest $request)
    {
        try {

            Brand::create($request->validated());

            return redirect()
                ->route('brand.index')
                ->with('success', 'Brand added successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Brand could not be added.');

        }
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        try {

            $brand->update($request->validated());

            return redirect()
                ->route('brand.index')
                ->with('success', 'Brand updated successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Brand could not be updated.');

        }
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        if ($brand->products()->exists()) {

            return redirect()
                ->route('brand.index')
                ->with(
                    'error',
                    'This brand cannot be deleted because it is used by one or more products.'
                );
        }

        $brand->delete();

        return redirect()
            ->route('brand.index')
            ->with(
                'success',
                'Brand deleted successfully.'
            );
    }
}