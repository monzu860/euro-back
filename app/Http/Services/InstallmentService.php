<?php

namespace App\Http\Services;

use App\Models\Installment;

class InstallmentService
{
    public function __construct()
    {

    }

    public function index()
    {
        $installments = \DB::select("
        SELECT 
        installments.customer_id,
        customers.name,
        GROUP_CONCAT( round(amount)
        ORDER BY installments.id ASC
        SEPARATOR '€, ') as installment,
        count(installments.id) as no_of_installment 
        FROM 
        installments 
        left join customers on customers.id=installments.customer_id
        GROUP BY 
        installments.customer_id,
        customers.name
        ORDER BY
        installments.customer_id
        ");

        return $installments;
       
    }

    public function store(array $inputs)
    {
        foreach($inputs['installments'] as $key=>$installment){
            $install = Installment::create([
                'customer_id' => $inputs['customer_id'],
                'amount' => $installment['amount'],
                'expire_date' => $installment['expire_date'],
                'note' => $installment['note'],
            ]);  
        };
        return $install;
    }

    public function show($customer_id)
    {
        return $installments = Installment::where('customer_id',$customer_id)->get(['id','amount','expire_date','note','paid_at']);
        
    }

    public function update(array $inputs, $customer_id)
    {
        foreach($inputs['installments'] as $key=>$installment){
            $install = Installment::updateOrcreate([
                'id'=>$installment['id'],
            ],[
                'customer_id' => $inputs['customer_id'],
                'amount' => $installment['amount'],
                'expire_date' => $installment['expire_date'],
                'note' => $installment['note'],
            ]);  
        };
        return  $install;
    }

    public function destroy($id)
    {
        $installment = Installment::find($id);
        $installment->delete();
        return  $installment;

    }
}
