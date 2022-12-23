<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTravelPaymentRequest;
use App\Http\Requests\PaymentApprovalRequest;
use App\Http\Requests\StoreTravelPaymentRequest;
use App\Http\Requests\UpdateTravelPaymentRequest;
use App\Http\Resources\PaymentApprovalResource;
use App\Http\Resources\TravelPaymentResource;
use App\Models\TravelPayment;
use App\Repositories\Eloquent\PaymentApprovalRepository;
use App\Repositories\TravelPaymentInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class TravelPaymentController
 * @package App\Http\Controllers
 */
class TravelPaymentController extends Controller
{
    /**
     * @var TravelPaymentInterface
     */
    protected $repo;

    /**
     * TravelPaymentController constructor.
     * @param TravelPaymentInterface $travelPaymentRepository
     */
    public function __construct(TravelPaymentInterface $travelPaymentRepository)
    {
        $this->repo = $travelPaymentRepository;
    }


    /**
     * @param IndexTravelPaymentRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexTravelPaymentRequest $request)
    {
        $travelPayments = $this->repo->all($request->validated(), true);

        return TravelPaymentResource::collection($travelPayments);
    }


    /**
     * @param StoreTravelPaymentRequest $request
     * @return TravelPaymentResource
     */
    public function store(StoreTravelPaymentRequest $request)
    {
        $travelPayment = $this->repo->create($request->validated());

        return TravelPaymentResource::make($travelPayment);
    }


    /**
     * @param TravelPayment $travelPayment
     * @return TravelPaymentResource
     * @throws AuthorizationException
     */
    public function show(TravelPayment $travelPayment)
    {
        $this->authorize('show', $travelPayment);

        return TravelPaymentResource::make($travelPayment);
    }


    /**
     * @param UpdateTravelPaymentRequest $request
     * @param TravelPayment $travelPayment
     * @return JsonResponse
     */
    public function update(UpdateTravelPaymentRequest $request, TravelPayment $travelPayment)
    {
        $this->repo->updateExisting($travelPayment, $request->validated());

        return $this->message('Record is successfully updated');
    }


    /**
     * @param TravelPayment $travelPayment
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(TravelPayment $travelPayment)
    {
        $this->authorize('delete', $travelPayment);

        $this->repo->deleteExisting($travelPayment);

        return $this->message('Record is successfully deleted');
    }

    /**
     * Calls repository to update status of payment approval
     * @param PaymentApprovalRepository $paymentApprovalRepository
     * @param TravelPayment $travelPayment
     * @param PaymentApprovalRequest $request
     * @return PaymentApprovalResource
     */
    public function approve(
        PaymentApprovalRepository $paymentApprovalRepository,
        TravelPayment $travelPayment,
        PaymentApprovalRequest $request
    ) {

        $paymentApproval = $paymentApprovalRepository->approveOrDisapprove($travelPayment, $request->validated());

        return PaymentApprovalResource::make($paymentApproval);
    }
}
