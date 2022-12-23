<?php

namespace App\Http\Requests;

use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StorePaymentRequest
 * @package App\Http\Requests
 */
class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', Payment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'total_amount' => 'required|numeric',
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
