<?php

namespace App\Repositories\Eloquent;

use App\Models\TravelPayment;
use App\Repositories\TravelPaymentInterface;

class TravelPaymentRepository extends BaseRepository implements TravelPaymentInterface
{
    /**
     * UserRepository constructor.
     *
     * @param TravelPayment $model
     */
    public function __construct(TravelPayment $model)
    {
        parent::__construct($model);
    }
}
