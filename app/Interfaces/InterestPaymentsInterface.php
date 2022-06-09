<?php


namespace App\Interfaces;


interface InterestPaymentsInterface
{
    public function calculate_interest_payments(int $orderId);
}
