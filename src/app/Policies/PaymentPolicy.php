<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if payments can be viewed by the user.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user): bool
    {
        return $user->tokenCan('APPROVER') || $user->tokenCan('NON_APPROVER');
    }

    /**
     * Determine if payment can be stored by the user.
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
     * @param Payment $payment
     * @return bool
     */
    public function show(User $user, Payment $payment): bool
    {
        return $user->tokenCan('APPROVER') || ($user->tokenCan('NON_APPROVER') && $user->id === $payment->user_id);
    }

    /**
     * Determine if the given payment can be updated by the user.
     *
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function update(User $user, Payment $payment): bool
    {
        return  $user->tokenCan('NON_APPROVER') && $user->id === $payment->user_id;
    }


    /**
     * Determine if the given payment can be deleted by the user.
     *
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $user->tokenCan('NON_APPROVER') && $user->id === $payment->user_id;
    }


}
