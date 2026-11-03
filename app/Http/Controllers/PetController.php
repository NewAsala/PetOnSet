<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Models\Customer;
use App\Models\Pet;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PetController extends Controller
{
    /**
     * Display a listing of pets.
     */
    public function index(): View
    {
        $pets = Pet::with('customer')
            ->latest()
            ->paginate(10);

        return view('dashboard.pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new pet.
     */
    public function create(): View
    {
        $customers = Customer::orderBy('name')->get();

        return view('dashboard.pets.create', compact('customers'));
    }

    /**
     * Store a newly created pet.
     */
    public function store(PetRequest $request): RedirectResponse
    {
        Pet::create($request->validated());

        return redirect()
            ->route('pet.index')
            ->with('success', 'Pet added successfully.');
    }

    /**
     * Show the form for editing the specified pet.
     */
    public function edit(Pet $pet): View
    {
        $customers = Customer::orderBy('name')->get();

        return view('dashboard.pets.edit', compact('pet', 'customers'));
    }

    /**
     * Update the specified pet.
     */
    public function update( PetRequest $request, Pet $pet ): RedirectResponse {
        $pet->update($request->validated());

        return redirect()
            ->route('pet.index')
            ->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove the specified pet.
     */
    public function destroy(Pet $pet): RedirectResponse
    {
        $pet->delete();

        return redirect()
            ->route('pet.index')
            ->with('success', 'Pet deleted successfully.');
    }
}