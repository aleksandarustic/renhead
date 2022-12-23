<?php

namespace App\Http\Requests;

use App\Models\TravelPayment;
use Illuminate\Foundation\Http\FormRequest;

class IndexTravelPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('index', TravelPayment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => 'numeric',
            'user_id' => 'exists:users,id'
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->user()->tokenCan('NON_APPROVER')) {
            $this->offsetSet('user_id', $this->user()->id);
        }
    }
}
