<?php

namespace App\Repositories\Eloquent;

use App\Models\Report;
use App\Repositories\ReportRepositoryInterface;

/**
 * Class ReportRepository
 * @package App\Repositories\Eloquent
 */
class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{

    /**
     * ReportRepository constructor.
     * @param Report $model
     */
    public function __construct(Report $model)
    {
        parent::__construct($model);
    }
}
