<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Interfaces\InterestPaymentsInterface;
use App\Models\Order;

class OrderController extends Controller
{
    public function bond_order(OrderRequest $request, $id){
        $order = Order::create(array_merge($request->validated(), ['bond_id' => $id]));
        return response()->json([
            'message' => 'success',
            'order' => $order
        ]);
    }

    public function interest_payments(InterestPaymentsInterface $interestPayments, $order_id){
        $payouts = $interestPayments->calculate_interest_payments($order_id);

        return response()->json([
            'payouts' => $payouts
        ]);
    }
}
