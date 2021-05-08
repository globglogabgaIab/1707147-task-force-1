<?php

namespace TaskForce\Models;

class Task
{
    private string $currStatus;
    private int $userID;
    private int $workerID;
    private string $status;
    private string $action;
    // "Marker" in which state the job is in
    // ONE Task - only ONE Status
    const STATUS_NEW = 'status_new';
    const STATUS_CANCELLED = 'status_cancelled';
    const STATUS_IN_PROGRESS = 'status_in_progress';
    const STATUS_DONE = 'status_done';
    const STATUS_FAILED = 'status_failed';
    // Available Actions for Task
    // Task may contain many Actions
    const ACTION_START = 'action_start';
    const ACTION_DONE = 'action_done';
    const ACTION_CANCEL = 'action_cancel';
    const ACTION_FAILED = 'action_failed';

    const STATUS_ACTION_MAP = [
            self::STATUS_NEW => [self::ACTION_START, self::ACTION_CANCEL],
            self::STATUS_CANCELLED => [self::ACTION_CANCEL],
            self::STATUS_IN_PROGRESS => [self::ACTION_START, self::ACTION_FAILED],
            self::STATUS_DONE => [self::ACTION_DONE],
            self::STATUS_FAILED => [self::ACTION_FAILED]
        ];
    const ACTION_STATUS_MAP = [
            self::ACTION_START => [self::STATUS_IN_PROGRESS],
            self::ACTION_DONE => [self::STATUS_DONE],
            self::ACTION_CANCEL => [self::STATUS_CANCELLED],
            self::ACTION_FAILED => [self::STATUS_FAILED]
        ];
    /**
    * Class constructor
    * 
    * Invoked when creating a new object of class
    * Collects job status, customer id and performer id
    *
    * @param string $currStatus, int userID, int workerID
    * @return void
    */
    public function __construct(string $currStatus, int $userID, int $workerID) 
    {
        $this->currStatus = $currStatus;
        $this->userID = $userID;
        $this->workerID = $workerID;
    }

    /**
    * Get Available actions for current status
    * 
    * Takes $status and returns a list of 0 to 2 elements
    * (0 elements if you assign a status that is not in the STATUS_ACTION_MAP dictionary)
    * Array contains available actions
    * 
    * @param string $status
    * @return array
    */
    public function getAllowActionsForStatus(string $status): array 
    {
        if (array_key_exists($status, self::STATUS_ACTION_MAP)) {
            return self::STATUS_ACTION_MAP[$status];
        }
        return [];
    }

    /**
    * Provides information on which status to assign
    * depending on the Action
    * 
    * Takes $status and returns a list of 0 to 2 elements
    * (0 elements if you assign a status that is not in the STATUS_ACTION_MAP dictionary)
    * Array contains available actions
    * 
    * @param string $action
    * @return array
    */
    public function getStatusForAction(string $action): array 
    {
        if (array_key_exists($action, self::ACTION_STATUS_MAP)) {
            return self::ACTION_STATUS_MAP[$action];
        }
        return [];
    }

}
