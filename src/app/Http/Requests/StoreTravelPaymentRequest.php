<?php

namespace App\Http\Requests;

use App\Models\TravelPayment;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreTravelPaymentRequest
 * @package App\Http\Requests
 */
class StoreTravelPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', TravelPayment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'user_id' => 'required|exists:users,id'
        ];
    }

    /**
     * Overwrite input by setting user_id of loged in user
     */
    protected function prepareForValidation(): void
    {
        $this->offsetSet('user_id', $this->user()->id);
    }
}
