<?php

namespace App\Http\Controllers;

use App\Http\Services\CustomerService;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    private $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->middleware('auth:api');
        $this->customerService=$customerService;
    }

    public function index()
    {
        $customers = $this->customerService->index();

        return response()->json([
            'status' => 'success',
            'customers' => $customers,
        ],200);
    }

    public function store(CustomerRequest $request)
    {
        $customer = $this->customerService->store($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully',
            'customer' => $customer,
        ],200);
    }

    public function show($id)
    {
        $customer = $this->customerService->show($id);

        return response()->json([
            'status' => 'success',
            'customer' => $customer,
        ],200);
    }

    public function update(CustomerRequest $request, $id)
    {
        $customer = $this->customerService->update($request->all(),$id);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer updated successfully',
            'customer' => $customer,
        ],200);
    }

    public function destroy($id)
    {
        $customer = $this->customerService->destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer deleted successfully',
            'customer' => $customer,
        ],200);
    }
}
