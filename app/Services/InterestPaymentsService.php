<?php


namespace App\Services;


use App\Interfaces\InterestDatesInterface;
use App\Interfaces\InterestPaymentsInterface;
use App\Models\Order;
use Carbon\Carbon;

class InterestPaymentsService implements InterestPaymentsInterface
{

    public function __construct(InterestDatesInterface $interestDates)
    {
        $this->interestDates = $interestDates;
    }

    public function calculate_interest_payments($orderId){
        $order = Order::findOrFail($orderId);
        $bond = $order->bond;

        $dates = $this->interestDates->calculate_interest_dates($bond->id);

        $payouts = array();

        $calculating_period = intval($bond->calculating_period);

        foreach ($dates as $key=>$date){
            if ($key){
                $next_interest_date = Carbon::parse(strtotime($date['date']));
                $previous_interest_date = Carbon::parse(strtotime($dates[$key-1]['date']));
                $days = $next_interest_date->diffInDays($previous_interest_date);
            }
            else{
                $next_interest_date = Carbon::parse(strtotime($date['date']));
                $order_date = Carbon::parse(strtotime($order->order_date));
                $days = $next_interest_date->diffInDays($order_date);
            }

            $amount = ($bond->nominal_price / 100 * $bond->coupon_interest) / $calculating_period * $days * $order->bonds_quantity;

            $payout = array("date" => $date['date'], "amount" => round($amount, 4));
            array_push($payouts, $payout);
        }

        return $payouts;
    }
}
