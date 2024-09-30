<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    // Display a listing of the resource
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $customers = Customer::paginate($perPage);
        return view('customers.index', compact('customers', 'perPage'))
        ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('customers.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|min:11|max:11',
            'blocked_until' => 'nullable|date|after:today',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Create customer
        $customer = Customer::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'phone_number' => $validatedData['phone_number'],
            'blocked_until' => $validatedData['blocked_until'] ?? null,
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->store('customer_images', 'public'); 

            // Create the image record in the File model
            $image = new File([
                'url' => $fileName,
                'file_type' => 'image',
            ]);

            // Associate the image with the customer
            $customer->image()->save($image);
        }

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }


    // Display the specified resource
    public function show(Customer $customer)
    {
        $customer->load(['image', 'orders', 'cart.cartItems']);
        return view('customers.show', compact('customer'));
    }

    // Show the form for editing the specified resource
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Customer $customer)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone_number' => 'required|string|min:11|max:11',
            'blocked_until' => 'nullable|date|after:today',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update customer details
        $customer->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'blocked_until' => $validatedData['blocked_until'] ?? null,
        ]);

        // Update password if provided
        if (!empty($validatedData['password'])) {
            $customer->password = bcrypt($validatedData['password']);
            $customer->save();
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image record if it exists
            if ($customer->image()) {
                $customer->image()->delete();
            }

            $file = $request->file('image');
            $fileName = $file->store('customer_images', 'public');

            // Create the image record in the File model
            $image = new File([
                'url' => $fileName,
                'file_type' => 'image',
            ]);

            // Associate the new image with the customer
            $customer->image()->save($image);
        }

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(Customer $customer)
    {
        if ($customer->image) {
            $customer->image->delete();
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
