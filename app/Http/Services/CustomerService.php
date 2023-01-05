<?php

namespace App\Http\Services;

use App\Models\Customer;

class CustomerService
{
    public function __construct()
    {

    }

    public function index()
    {
        return Customer::all();
       
    }

    public function store(array $inputs)
    {
        return Customer::create([
            'name' => $inputs['name'],
            'address' => $inputs['address'],
        ]);
    }

    public function show($id)
    {
        return Customer::find($id);
        
    }

    public function update(array $inputs, $id)
    {
        $customer = Customer::find($id);
        $customer->name = $inputs['name'];
        $customer->address = $inputs['address'];
        $customer->save();
        return  $customer;
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return  $customer;

    }
}
