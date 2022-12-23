<?php

namespace App\Repositories;


use App\Models\Payment;
use App\Models\TravelPayment;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface PaymentApprovalRepositoryInterface
 * @package App\Repositories
 */
interface PaymentApprovalRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param Payment|TravelPayment $payment
     * @param array $data
     * @return Model
     */
    public function approveOrDisapprove(Payment|TravelPayment $payment, array $data): Model;
}
