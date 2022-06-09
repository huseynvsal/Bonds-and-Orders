<?php

namespace App\Http\Controllers;

use App\Interfaces\InterestDatesInterface;

class BondController extends Controller
{
    public function interest_dates(InterestDatesInterface $interestDates, $id){
        $dates = $interestDates->calculate_interest_dates($id);

        return response()->json([
            'dates' => $dates
        ]);
    }
}
