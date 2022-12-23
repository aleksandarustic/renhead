<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentApprovalRequest;
use App\Repositories\PaymentApprovalRepositoryInterface;


/**
 * Class PaymentApprovalController
 * @package App\Http\Controllers
 */
class PaymentApprovalController extends Controller
{
    /**
     * @var PaymentApprovalRepositoryInterface
     */
    protected $repo;

    /**
     * PaymentApprovalController constructor.
     * @param PaymentApprovalRepositoryInterface $paymentApprovalRepository
     */
    public function __construct(PaymentApprovalRepositoryInterface $paymentApprovalRepository)
    {
        $this->repo = $paymentApprovalRepository;
    }

    /**
     * @param $payment
     * @param PaymentApprovalRequest $request
     */
    public function approve($payment, PaymentApprovalRequest $request)
    {
        $this->repo->approveOrDisapprove($payment , $request->validated());
    }
}
