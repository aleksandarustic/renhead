<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Report
 * Report is model connected to sql view
 * @package App\Models
 */
class Report extends Model
{
    /**
     * @var string
     */
    public $table = "report";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
