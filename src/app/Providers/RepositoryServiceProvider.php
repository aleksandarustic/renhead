<?php

namespace App\Providers;

use App\Repositories\Eloquent\PaymentApprovalRepository;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\ReportRepository;
use App\Repositories\Eloquent\TravelPaymentRepository;
use App\Repositories\PaymentApprovalRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use App\Repositories\ReportRepositoryInterface;
use App\Repositories\TravelPaymentInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->singleton(TravelPaymentInterface::class, TravelPaymentRepository::class);
        $this->app->singleton(PaymentApprovalRepositoryInterface::class, PaymentApprovalRepository::class);
        $this->app->singleton(ReportRepositoryInterface::class, ReportRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
