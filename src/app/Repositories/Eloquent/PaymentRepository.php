<?php

namespace App\Repositories\Eloquent;

use App\Models\Payment;
use App\Repositories\PaymentRepositoryInterface;

/**
 * Class PaymentRepository
 * @package App\Repositories\Eloquent
 */
class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{

    /**
     * PaymentRepository constructor.
     * @param Payment $model
     */
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

}
