<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsurancePlanRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'insurance_plan_id',
        'service_category',
        'coverage_percentage',
        'coverage_limit',
        'notes',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(InsurancePlan::class);
    }
}
