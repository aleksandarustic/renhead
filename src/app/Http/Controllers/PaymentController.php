<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexPaymentRequest;
use App\Http\Requests\PaymentApprovalRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentApprovalResource;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Repositories\Eloquent\PaymentApprovalRepository;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Class PaymentController
 * @package App\Http\Controllers
 */
class PaymentController extends Controller
{
    /**
     * @var PaymentRepositoryInterface
     */
    protected $repo;

    /**
     * PaymentController constructor.
     * @param PaymentRepositoryInterface $paymentRepository
     */
    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->repo = $paymentRepository;
    }

    /**
     * @param IndexPaymentRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexPaymentRequest $request)
    {
        $payments = $this->repo->all($request->validated(), true);

        return PaymentResource::collection($payments);
    }


    /**
     * @param StorePaymentRequest $request
     * @return PaymentResource
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = $this->repo->create($request->validated());

        return PaymentResource::make($payment);
    }


    /**
     * @param Payment $payment
     * @return PaymentResource
     * @throws AuthorizationException
     */
    public function show(Payment $payment)
    {
        $this->authorize('show', $payment);

        return PaymentResource::make($payment);
    }


    /**
     * @param UpdatePaymentRequest $request
     * @param Payment $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $this->repo->updateExisting($payment, $request->validated());

        return $this->message('Record is successfully updated');
    }


    /**
     * @param Payment $payment
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);

        $this->repo->deleteExisting($payment);

        return $this->message('Record is successfully deleted');
    }


    /**
     * @param PaymentApprovalRepository $paymentApprovalRepository
     * @param Payment $payment
     * @param PaymentApprovalRequest $request
     * @return PaymentApprovalResource
     */
    public function approve(
        PaymentApprovalRepository $paymentApprovalRepository,
        Payment $payment,
        PaymentApprovalRequest $request
    ) {

        $paymentApproval = $paymentApprovalRepository->approveOrDisapprove($payment, $request->validated());

        return PaymentApprovalResource::make($paymentApproval);
    }

}
