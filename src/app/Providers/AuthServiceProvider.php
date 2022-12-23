<?php

namespace App\Providers;

use App\Models\Payment;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use App\Policies\PaymentApprovalPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\TravelPaymentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Payment::class => PaymentPolicy::class,
        TravelPayment::class => TravelPaymentPolicy::class,
        PaymentApproval::class => PaymentApprovalPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
