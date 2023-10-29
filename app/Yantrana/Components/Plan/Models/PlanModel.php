<?php
/**
 * Plan.php - Model file
 *
 * This file is part of the Plan component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Plan\Models;

use App\Yantrana\Base\BaseModel;
use App\Yantrana\Components\User\Models\UserSubscription;

class PlanModel extends BaseModel
{
    /**
     * @var  string - The database table used by the model.
     */
    protected $table = 'plans';

    /**
     * @var  array - The attributes that should be casted to native types.
     */
    protected $casts = [];

    /**
     * @var  array - The attributes that are mass assignable.
     */
    protected $fillable = [];

    /**
     * Get user gift transaction data.
     */
    public function subscription()
    {
        return $this->hasOne(UserSubscription::class, '_id', 'plan_id');
    }
}
