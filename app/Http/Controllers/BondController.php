<?php

namespace App\Http\Controllers;

use App\Models\Bond;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BondController extends Controller
{
    public function interest_dates($id){
        $bond = Bond::findOrFail($id);

        $calculation_period = intval($bond->calculating_period);
        $payment_frequency = intval($bond->payment_frequency);
        $issue_date = $bond->issue_date;
        switch ($calculation_period) {
            case 360:
                $periodWithDays = (12 / $payment_frequency) * 30;
                break;
            case 364:
                $periodWithDays = 364 / $payment_frequency;
                break;
            case 365:
                $periodWithMonth = 12 / $payment_frequency;
                break;
        }

        $dates = array();

        $payment_date = $issue_date;

        for ($i = 0; $i < 12 / $payment_frequency; $i++) {
            $date = Carbon::createFromFormat('Y-m-d', $payment_date);
            if ($calculation_period != 365) {
                $date = $date->addDays($periodWithDays)->toDateString();
            }
            else{
                $date = $date->addMonth($periodWithMonth)->toDateString();
            }

            $dayOfWeek = Carbon::parse($date)->dayOfWeek;

            if (in_array($dayOfWeek, [0, 6]) ){
                $date = Carbon::parse($date)->startOfWeek()->addWeeks(1)->toDateString();
            }

            $payment_date = $date;
            $date = array("date" => $date);
            array_push($dates, $date);
        }

        return response()->json([
            'dates' => $dates
        ]);
    }
}
