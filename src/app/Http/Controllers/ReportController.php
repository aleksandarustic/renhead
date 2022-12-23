<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReportResource;
use App\Repositories\ReportRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ReportController
 * @package App\Http\Controllers
 */
class ReportController extends Controller
{
    /**
     * Return report made by query in sql view using report model
     * @param ReportRepositoryInterface $reportRepository
     * @return AnonymousResourceCollection
     */
    public function report(ReportRepositoryInterface $reportRepository)
    {
        $report = $reportRepository->all();

        return ReportResource::collection($report);
    }

}
