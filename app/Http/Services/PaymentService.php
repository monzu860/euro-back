<?php

namespace App\Http\Services;

use App\Models\Installment;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use GuzzleHttp\Client;

class PaymentService
{
    public function __construct()
    {

    }

   

    public function store(array $inputs)
    {
        $installment = Installment::join('customers', function($join)  {
            $join->on('customers.id', '=', 'installments.customer_id');
        })
        ->where('installments.id',$inputs['installment_id'])
        ->get([
            'installments.id',
            'installments.amount',
            'customers.name',
            'customers.address',
        ])
        ->first();
        $rootUrl = $inputs['base_url'];
        $successUrl = $rootUrl."/payment/success/".$installment->id;
        $cancelUrl = $rootUrl."/payment/failed/".$installment->id;


        $apiSecretKey = env('STRIPE_API_SECRET_KEY');
        $apiPublishKey = env('STRIPE_API_PUBLISH_KEY');
        Stripe::setApiKey($apiSecretKey);
        $amount = round($installment->amount * 100);//converting in cents
        $quantity = 1;
        $customerEmail = 'test@example.com';

        $checkout_session = Session::create([
        'customer_email' => $customerEmail,
        'line_items' => [
            [
                "price_data"=>[
                    "currency"=>'eur',
                    "unit_amount"=>$amount,
                    "product_data"=>[
                        "name"=>"Installment-".$installment->installment_id
                    ]
                ],
                'quantity' => 1,
            ]
        ],
        'mode' => 'payment',
        'success_url' => $successUrl,
        'cancel_url' => $cancelUrl,
        ]);

       return [
            'status' => 'success',
            'sessionId'=>$checkout_session->id,
            'publishKey'=>$apiPublishKey,
        ];
    }

    public function update(array $inputs, $id)
    {
        $installment = Installment::find($id);
        $installment->paid_at  = date('Y-m-d h:i:s');
        $installment->save();
        return  $installment;
    }
    
}
