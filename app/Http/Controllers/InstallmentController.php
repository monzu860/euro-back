<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\InstallmentService;
use App\Http\Requests\InstallmentRequest;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use GuzzleHttp\Client;

class InstallmentController extends Controller
{
    private $installmentService;
    public function __construct(InstallmentService $installmentService)
    {
        $this->middleware('auth:api');
        $this->installmentService=$installmentService;
    }

    public function index()
    {
        $installments = $this->installmentService->index();
        return response()->json([
            'status' => 'success',
            'installments' => $installments,
        ],200);
    }

    public function store(InstallmentRequest $request)
    {
        $installment = $this->installmentService->store($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Installment created successfully',
        ],200);
    }

    public function show($customer_id)
    {
        $installments = $this->installmentService->show($customer_id);
        return response()->json([
            'status' => 'success',
            'installments' => $installments,
        ]);
    }

    public function update(InstallmentRequest $request, $customer_id)
    {
        $installments = $this->installmentService->update($request->all(),$customer_id);
        return response()->json([
            'status' => 'success',
            'message' => 'Installment updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $installment = $this->installmentService->destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Installment deleted successfully',
            'installment' => $installment,
        ]);
    }
}
