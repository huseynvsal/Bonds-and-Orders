<?php


namespace App\Interfaces;


interface InterestDatesInterface
{
    public function calculate_interest_dates(int $bondId);
}
