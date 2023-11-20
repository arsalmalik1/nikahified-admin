<?php
/**
 * PlanEngine.php - Main component file
 *
 * This file is part of the Plan component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Plan;

use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\Plan\Interfaces\PlanEngineInterface;
use App\Yantrana\Components\Plan\Repositories\PlanRepository;
use App\Yantrana\Components\User\Models\UserSubscription;
use App\Yantrana\Components\User\Repositories\UserRepository;

class PlanEngine extends BaseEngine implements PlanEngineInterface
{
    /**
     * @var  PlanRepository - Plan Repository
     */
    protected $planRepository;

    /**
     * @var UserRepository - User Repository
     */
    protected $userRepository;

    /**
     * Constructor
     *
     * @param  PlanRepository  $planRepository - Plan Repository
     * @return  void
     *-----------------------------------------------------------------------*/
    public function __construct(
        PlanRepository $planRepository,
        UserRepository $userRepository
    ) {
        $this->planRepository = $planRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * get plan list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function preparePlanList()
    {
        $planCollection = $this->planRepository->fetchAllActiveCreditPlan();

        $planData = [];
        if (! __isEmpty($planCollection)) {
            foreach ($planCollection as $key => $plan) {
                $planData[] = [
                    '_id' => $plan['_id'],
                    '_uid' => $plan['_uid'],
                    'title' => $plan['title'],
                    'price' => intval($plan['price']),
                    'description' => $plan['description'],
                    'duration' => $plan['duration'],
                    'status' => $plan['status'],
                    'created_at' => formatDate($plan['created_at']),
                    'updated_at' => formatDate($plan['updated_at'])
                ];
            }
        }
        //success response
        return $this->engineReaction(1, [
            'planData' => $planData,
        ]);
    }

    /**
     * Process add new plan.
     *
     * @param  array  $inputData
     *---------------------------------------------------------------- */
    public function processAddNewPlan($inputData)
    {
        // Fetch Authority of login user
        $user = $this->userRepository->fetch(getUserID());

        //check if empty
        if (__isEmpty($user)) {
            return $this->engineReaction(1, null, __tr('User not exist.'));
        }

        //store data
        $storeData = [
            'title' => $inputData['title'],
            'price' => $inputData['price'],
            'duration' => $inputData['duration'],
            'description' => $inputData['description']
        ];

        //Check if plan added
        if ($newPlan = $this->planRepository->storePlan($storeData)) {
            return $this->engineReaction(1, [], __tr('Plan added successfully.'));
        }
        //error response
        return $this->engineReaction(2, null, __tr('Plan not added.'));
    }

    /**
     * get plan edit data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function preparePlanUpdateData($planUId)
    {
        $planCollection = $this->planRepository->fetch($planUId);

        //if is empty then show error message
        if (__isEmpty($planCollection)) {
            return $this->engineReaction(1, null, __tr('Plan does not exist'));
        }

        $planEditData = [];
        if (! __isEmpty($planCollection)) {
            $planEditData = [
                '_id' => $planCollection['_id'],
                '_uid' => $planCollection['_uid'],
                'title' => $planCollection['title'],
                'price' => intval($planCollection['price']),
                'description' => $planCollection['description'],
                'duration' => $planCollection['duration']
            ];
        }

        return $this->engineReaction(1, [
            'planEditData' => $planEditData,
        ]);
    }

    /**
     * Process edit plan.
     *
     * @param  array  $inputData
     *---------------------------------------------------------------- */
    public function processEditPlan($inputData, $planUId)
    {
        $planCollection = $this->planRepository->fetch($planUId);

        //if is empty then show error message
        if (__isEmpty($planCollection)) {
            return $this->engineReaction(1, null, __tr('Plan does not exist'));
        }

        $isPlanUpdate = false;
        //update data
        $updateData = [
            'title' => $inputData['title'],
            'price' => $inputData['price'],
            'duration' => $inputData['duration'],
            'description' => $inputData['description']
        ];

        // Check if plan updated
        $this->planRepository->updatePlan($planCollection, $updateData);
        $isPlanUpdate = true;

        // Check if plan updated
        if ($isPlanUpdate) {
            return $this->engineReaction(1, null, __tr('Plan updated successfully.'));
        }
        //error response
        return $this->engineReaction(2, null, __tr('Plan not updated.'));
    }

    /**
     * Process plan delete.
     *
     * @param int planUId
     * @return array
     *---------------------------------------------------------------- */
    public function processDeletePlan($planUId)
    {
        $planCollection = $this->planRepository->fetch($planUId);

        //if is empty then show error message
        if (__isEmpty($planCollection)) {
            return $this->engineReaction(1, null, __tr('Plan does not exist'));
        }

        //Check if plan deleted
        if ($this->planRepository->delete($planCollection)) {
            return $this->engineReaction(1, [
                'planUId' => $planCollection->_uid,
            ], __tr('Plan deleted successfully.'));
        }

        //error response
        return $this->engineReaction(18, null, __tr('Plan not deleted.'));
    }

    /**
     * Process plan update status.
     *
     * @param int planUId
     * @return array
     *---------------------------------------------------------------- */
    public function processUpdatePlanStatus($planUId, $action)
    {
        $planCollection = $this->planRepository->fetch($planUId);

        //if is empty then show error message
        if (__isEmpty($planCollection)) {
            return $this->engineReaction(1, null, __tr('Plan does not exist'));
        }

        $isPlanUpdate = false;
        $updateData = [
            'status' => ($action == 'active') ? 1 : 0
        ];

        // Check if plan updated
        if ($this->planRepository->updatePlan($planCollection, $updateData)) {
            $isPlanUpdate = true;
        }

        // Check if plan updated
        if ($isPlanUpdate) {
            return $this->engineReaction(1, null, __tr('Plan status updated successfully.'));
        }
        //error response
        return $this->engineReaction(2, null, __tr('Plan not updated.'));
    }

    /**
     * get Api notification list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareApiPlanList($user_id)
    {
        $subscriptionArr['subscribed_plan'] = [];
        $planCollection = $this->planRepository->fetchApiPlanListData();
        if($user_id){
            $where = [['users__id', '=', $user_id], ['status', '=', 1]];
            $subscription = UserSubscription::where($where)->first();
            if($subscription){
               $subscriptionArr['subscribed_plan'] = [
                   '_id' => $subscription->plan_id,
                   '_uid' => $subscription->_uid,
                   'title' => $subscription->plan_name,
                   'duration' => $subscription->duration,
                   'price' => $subscription->price,
                   'description' => html_entity_decode($subscription->description),
                   'status' => 1,
                   'expiry_date' => $subscription->expiry_at,
                   'created_at' => formatDate($subscription->created_at),
                   'updated_at' => formatDate($subscription->updated_at)
               ];
            }
        }

        $requireColumns = [
            '_id',
            '_uid',
            'title',
            'duration',
            'price',
            'status' => function($key) {
                return ($key['status'] == 1) ? 'Active' : 'Inactive';
            },
            'description' => function($key) {
                return html_entity_decode($key['description']);
            },
            'created_at' => function ($pageData) {
                return formatDate($pageData['created_at']);
            },
            'updated_at' => function ($pageData) {
                return formatDate($pageData['updated_at']);
            }
        ];

        $dataResponse = $this->customTableResponse($planCollection, $requireColumns);
        $jsonContent = $dataResponse->getContent();
        $contentArray = json_decode($jsonContent, true);
        $contentArray['data'] = array_merge($subscriptionArr, $contentArray['data']);
        return response()->json($contentArray);
    }

}
