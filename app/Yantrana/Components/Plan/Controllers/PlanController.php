<?php
/**
 * PlanController.php - Controller file
 *
 * This file is part of the Plan component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Plan\Controllers;

use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\Plan\PlanEngine;
use App\Yantrana\Components\Plan\Requests\PlanRequest;
use Illuminate\Support\Facades\Request;

class PlanController extends BaseController
{
    /**
     * @var  PlanEngine - Plan Engine
     */
    protected $planEngine;

    /**
     * Constructor
     *
     * @param  PlanEngine  $planEngine - Plan Engine
     * @return  void
     *-----------------------------------------------------------------------*/
    public function __construct(PlanEngine $planEngine)
    {
        $this->planEngine = $planEngine;
    }

    /**
     * Show Plan List View.
     *
     *-----------------------------------------------------------------------*/
    public function getPlanList()
    {
        $processReaction = $this->planEngine->preparePlanList();

        return $this->loadManageView('plan.manage.list', $processReaction['data']);
    }

    /**
     * Show Plan Add View.
     *
     *-----------------------------------------------------------------------*/
    public function planAddView()
    {
        return $this->loadManageView('plan.manage.add');
    }

    /**
     * Handle add new plan request.
     *
     * @param  PlanRequest  $request
     * @return json response
     *---------------------------------------------------------------- */
    public function addPlan(PlanRequest $request)
    {
        $processReaction = $this->planEngine
            ->processAddNewPlan($request->all());

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.plan.read.list')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Show Plan Edit View.
     *
     *-----------------------------------------------------------------------*/
    public function planEditView($planUId)
    {
        $processReaction = $this->planEngine->preparePlanUpdateData($planUId);

        return $this->loadManageView('plan.manage.edit', $processReaction['data']);
    }

    /**
     * Handle edit new plan request.
     *
     * @param  PlanRequest  $request
     * @return json response
     *---------------------------------------------------------------- */
    public function editPlan(PlanRequest $request, $planUId)
    {
        $processReaction = $this->planEngine
            ->processEditPlan($request->all(), $planUId);

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.plan.read.list')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Handle delete plan data request.
     *
     * @param  int  $planUId
     * @return json object
     *---------------------------------------------------------------- */
    public function processDeletePlan($planUId)
    {
        $processReaction = $this->planEngine->processDeletePlan($planUId);

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    /**
     * Handle update plan status.
     *
     * @param  int  $planUId
     * @return json object
     *---------------------------------------------------------------- */
    public function processUpdatePlanStatus(\Illuminate\Http\Request $request, $planUId)
    {
        $action = $request->action;
        $processReaction = $this->planEngine->processUpdatePlanStatus($planUId, $action);
        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }
}
