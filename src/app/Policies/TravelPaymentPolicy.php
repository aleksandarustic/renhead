<?php

namespace App\Policies;

use App\Models\TravelPayment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TravelPaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user have access to fetch payments.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user): bool
    {
        return $user->tokenCan('APPROVER') || $user->tokenCan('NON_APPROVER');
    }

    /**
     * Determine if user can store payment.
     *
     * @param User $user
     * @return bool
     */
    public function store(User $user): bool
    {
        return $user->tokenCan('NON_APPROVER');
    }

    /**
     * Determine if the given payment can be viewed by the user.
     *
     * @param User $user
     * @param TravelPayment $payment
     * @return bool
     */
    public function show(User $user, TravelPayment $payment): bool
    {
        return $user->tokenCan('APPROVER') || ($user->tokenCan('NON_APPROVER') && $user->id === $payment->user_id);
    }

    /**
     * Determine if the given payment can be updated by the user.
     *
     * @param User $user
     * @param TravelPayment $payment
     * @return bool
     */
    public function update(User $user, TravelPayment $payment): bool
    {
        return  $user->tokenCan('NON_APPROVER') && $user->id === $payment->user_id;
    }


    /**
     * Determine if the given payment can be deleted by the user.
     *
     * @param User $user
     * @param TravelPayment $payment
     * @return bool
     */
    public function delete(User $user, TravelPayment $payment): bool
    {
        return $user->tokenCan('NON_APPROVER') && $user->id === $payment->user_id;
    }


}
