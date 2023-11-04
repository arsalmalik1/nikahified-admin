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
        $planCollection = $this->planRepository->fetchAllPlan();

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
        if ($this->planRepository->updatePlan($planCollection, $updateData)) {
            $isPlanUpdate = true;
        }

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
     * get Api notification list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareApiPlanList($user_id)
    {
        $planCollection = $this->planRepository->fetchApiPlanListData();
        $requireColumns = [
            '_id',
            '_uid',
            'title',
            'duration',
            'price',
            'description' => function($key) {
                return html_entity_decode($key['description']);
            },
            'is_subscribed' => function ($key) use ($user_id){
                return (getUserSubscribedPlanId($user_id) == $key['_id']);
            },
            'expiry_date' => function($key) use($user_id) {
                return getUserSubscriptionExpiry($user_id, $key['_id']);
            },
            'created_at' => function ($pageData) {
                return formatDate($pageData['created_at']);
            },
            'updated_at' => function ($pageData) {
                return formatDate($pageData['updated_at']);
            },
        ];

        return $this->customTableResponse($planCollection, $requireColumns);
    }

}
