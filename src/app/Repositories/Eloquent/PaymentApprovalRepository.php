<?php

namespace App\Repositories\Eloquent;


use App\Models\Payment;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use App\Repositories\PaymentApprovalRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentApprovalRepository
 * @package App\Repositories\Eloquent
 */
class PaymentApprovalRepository extends BaseRepository implements PaymentApprovalRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param PaymentApproval $model
     */
    public function __construct(PaymentApproval $model)
    {
        parent::__construct($model);
    }

    /**
     *  Approve or disapprove one of payment type
     * @param Payment|TravelPayment $payment
     * @param array $data
     * @return Model
     */
    public function approveOrDisapprove(Payment|TravelPayment $payment, array $data): Model
    {
        return $payment->paymentApproval()->updateOrCreate([
            'user_id' => $data['user_id'],
            'payment_id' => $payment->id,
            'payment_type' => $payment->getMorphClass()
        ], ['status' => $data['status']]);
    }

}
