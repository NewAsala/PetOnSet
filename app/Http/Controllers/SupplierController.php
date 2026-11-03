<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index (){
        $suppliers = Supplier::paginate(10);

        return view('dashboard.suppliers.index',['suppliers'=>$suppliers]);
    }

    public function create (){
        return view('dashboard.suppliers.create');
    }

    public function store(SupplierRequest $request)
    {
        try {

            Supplier::create($request->validated());

            return redirect()
                ->route('supplier.index')
                ->with('success', 'Supplier added successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Supplier could not be added.');

        }
    }

    public function edit(Supplier $supplier){
        return view('dashboard.suppliers.edit', ['supplier' => $supplier]);
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        try {

            $supplier->update($request->validated());

            return redirect()
                ->route('supplier.index')
                ->with('success', 'Supplier updated successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Supplier could not be updated.');

        }
    }

    public function show(Supplier $supplier){
        return view('dashboard.suppliers.show', ['supplier' => $supplier]);
    }

    public function destroy(Supplier $supplier){
        $supplier->delete();

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
