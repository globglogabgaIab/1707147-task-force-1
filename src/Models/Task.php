<?php
namespace TaskForce\Models;
use TaskForce\Models\Exceptions\TaskException;

require_once "../../vendor/autoload.php";

class Task
{
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
        self::STATUS_IN_PROGRESS => [self::ACTION_START, self::ACTION_FAILED]
    ];
    const ACTION_STATUS_MAP = [
        self::ACTION_START => [self::STATUS_IN_PROGRESS],
        self::ACTION_DONE => [self::STATUS_DONE],
        self::ACTION_CANCEL => [self::STATUS_CANCELLED],
        self::ACTION_FAILED => [self::STATUS_FAILED]
    ];

    const STATUS_ARRAY = [self::STATUS_NEW,
        self::STATUS_IN_PROGRESS,
        self::ACTION_CANCEL,
        self::STATUS_CANCELLED,
        self::STATUS_FAILED];
    private string $current_status;
    private int $user_id;
    private int $executor_id;

    /**
     * Class constructor
     *
     * Invoked when creating a new object of class
     * Collects job status, customer id and performer id
     *
     * @param string $current_status
     * @param int $user_id
     * @param int $executor_id
     * @throws TaskException
     */
    public function __construct(string $current_status, int $user_id, int $executor_id)
    {
        if (!in_array($current_status, self::STATUS_ARRAY)) {
            throw new TaskException();
        }
        else {
            $this->current_status = $current_status;
            $this->user_id = $user_id;
            $this->executor_id = $executor_id;
        }
    }

    /**
     * Get Available actions for current status
     *
     * Takes $status and returns a list of 0 to 2 elements
     * (0 elements if you assign a status that is not available for further actions)
     * Array contains action classes
     *
     * @param string $status
     * @return array
     * @throws TaskException
     */
    public function getAllowedActions(string $status): array
    {
        if ($status == self::STATUS_NEW) {
            return [new Actions\ActionStart(), new Actions\ActionCancel()];
        }
        if ($status == self::STATUS_IN_PROGRESS) {
            return [new Actions\ActionDone(), new Actions\ActionFailed()];
        }
        throw new TaskException("Wrong status");
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
//
