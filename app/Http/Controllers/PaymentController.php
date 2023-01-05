<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PaymentService;
use App\Http\Requests\PaymentRequest;


class PaymentController extends Controller
{
    private $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->middleware('auth:api');
        $this->paymentService=$paymentService;
    }

   

    public function store(PaymentRequest $request)
    {
       $data=$this->paymentService->store($request->all());
       return response()->json($data);

    }

    

    public function update(PaymentRequest $request, $id)
    {
        $data=$this->paymentService->update($request->all(),$id);
        return response()->json([
            'status' => 'success',
            'installments' => $id,
            'message' => 'Installment updated successfully',
        ]);
    }

    
}
