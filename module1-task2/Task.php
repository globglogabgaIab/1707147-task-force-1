<?php

namespace TaskClass;

class Task
{
    // "Marker" in which state the job is in
    // One Task - ONLY one Status
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
    /*
    * Class constructor
    * 
    * Invoked when creating a new object of class
    * Collects job status, customer id and performer id
    */
    public function __construct(string $curr_status, int $UserID, int $WorkerID): void
    {
        $this->curr_status = $curr_status;
        $this->UserID = $UserID;
        $this->WorkerID = $WorkerID;
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
        $STATUS_ACTION_MAP = [
            self::STATUS_NEW => [self::ACTION_START, self::ACTION_CANCEL],
            self::STATUS_CANCELLED => [self::ACTION_CANCEL],
            self::STATUS_IN_PROGRESS => [self::ACTION_START, self::ACTION_FAILED],
            self::STATUS_DONE => [self::ACTION_DONE],
            self::STATUS_FAILED => [self::ACTION_FAILED]
        ];

        if (array_key_exists($status, $STATUS_ACTION_MAP)) 
        {
            return $STATUS_ACTION_MAP[$status];
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
        $ACTION_STATUS_MAP = [
            self::ACTION_START => [self::STATUS_IN_PROGRESS],
            self::ACTION_DONE => [self::STATUS_DONE],
            self::ACTION_CANCEL => [self::STATUS_CANCELLED],
            self::ACTION_FAILED => [self::STATUS_FAILED]
        ];

        if (array_key_exists($action, $ACTION_STATUS_MAP)) 
        {
            return $ACTION_STATUS_MAP[$action];
        }
        return [];
    }

}