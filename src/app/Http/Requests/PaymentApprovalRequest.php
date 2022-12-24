<?php

namespace App\Http\Requests;

use App\Models\PaymentApproval;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PaymentApprovalRequest
 * @package App\Http\Requests
 */
class PaymentApprovalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('approveOrDisapprove', PaymentApproval::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status' => 'required|in:APPROVED,DISAPPROVED',
            'user_id' => 'required|exists:users,id'
        ];
    }

    /**
     *
     */
    protected function prepareForValidation(): void
    {
        $this->offsetSet('user_id', $this->user()->id);
    }
}
