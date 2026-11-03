<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index (){
        // $customers = Customer::paginate(10);
        $customers = Customer::withCount('pets')
                    ->latest()
                    ->paginate(10);

        return view('dashboard.customers.index',['customers'=>$customers]);
    }

    public function create (){
        return view('dashboard.customers.create');
    }

    public function store(CustomerRequest $request)
    {
        try {

            Customer::create($request->validated());

            return redirect()
                ->route('customer.index')
                ->with('success', 'Customer added successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Customer could not be added.');

        }
    }

    public function edit(Customer $customer){
        return view('dashboard.customers.edit', ['customer' => $customer]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try {

            $customer->update($request->validated());

            return redirect()
                ->route('customer.index')
                ->with('success', 'Customer updated successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Customer could not be updated.');

        }
    }

    public function show(Customer $customer){
        return view('dashboard.customers.show', ['customer' => $customer]);
    }

    public function destroy(Customer $customer){
        $customer->delete();

        return redirect()
            ->route('customer.index')
            ->with('success', 'Customer deleted successfully.');
    }
    
}
