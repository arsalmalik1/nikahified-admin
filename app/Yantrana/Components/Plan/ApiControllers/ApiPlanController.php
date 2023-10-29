<?php
/**
 * ApiPlanController.php - Controller file
 *
 * This file is part of the Plan component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Plan\ApiControllers;

use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\Plan\PlanEngine;
use Illuminate\Support\Facades\Request;

class ApiPlanController extends BaseController
{
    /**
     * @var PlanEngine - Plan Engine
     */
    protected $planEngine;

    /**
     * Constructor.
     *
     * @param  PlanEngine  $planEngine - Plan Engine
     *-----------------------------------------------------------------------*/
    public function __construct(PlanEngine $planEngine)
    {
        $this->planEngine = $planEngine;
    }

    /**
     * Get Plan DataTable data.
     *
     *-----------------------------------------------------------------------*/
    public function getPlanList(Request $request, $user_id = null)
    {
        return $this->planEngine->prepareApiPlanList($user_id);
    }
}
