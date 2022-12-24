<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PaymentApprovalPolicy
 * @package App\Policies
 */
class PaymentApprovalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the payment can be approved by the user.
     * @param User $user
     * @return bool
     */
    public function approveOrDisapprove(User $user): bool
    {
        return $user->tokenCan('APPROVER');
    }
}
