<?php
namespace TaskForce\Models\Actions;

use TaskForce\Models\Task;

class ActionCancel extends AbstractAction
{
    protected string $name = "Отменить";
    protected string $innerName = "action_cancel";

    public function checkAllowByUserIds(int $user_id, int $executor_id, int $task_creator_id, string $status): bool
    {
        return ($user_id === $task_creator_id) && ($status === Task::STATUS_NEW);
    }
}
//
