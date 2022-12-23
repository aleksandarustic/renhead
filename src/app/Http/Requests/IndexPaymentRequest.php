<?php

namespace App\Http\Requests;

use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class IndexPaymentRequest
 * @package App\Http\Requests
 */
class IndexPaymentRequest extends FormRequest
{

    /**
     * @return mixed
     */
    public function authorize()
    {
        return $this->user()->can('index', Payment::class);
    }


    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'total_amount' => 'numeric',
            'user_id' => 'exists:users,id'
        ];
    }

    /**
     *
     */
    protected function prepareForValidation(): void
    {
        if ($this->user()->tokenCan('NON_APPROVER')) {
            $this->offsetSet('user_id', $this->user()->id);
        }
    }
}
