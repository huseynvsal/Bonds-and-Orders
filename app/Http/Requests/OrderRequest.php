<?php

namespace App\Http\Requests;

use App\Models\Bond;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $bond = Bond::findOrFail($request->id);
        return [
            'order_date' => 'required|date|after_or_equal:'.$bond->issue_date.'|before_or_equal:'.$bond->last_turnover_date.'',
            'bonds_quantity' => 'required|integer',
        ];
    }
}
