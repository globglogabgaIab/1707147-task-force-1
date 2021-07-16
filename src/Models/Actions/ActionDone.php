<?php
namespace TaskForce\Models\Actions;

use TaskForce\Models\Task;

class ActionDone extends AbstractAction
{
    protected string $name = "Выполнено";
    protected string $innerName = "action_done";

    public function checkAllowByUserIds(int $user_id, int $executor_id, int $task_creator_id, string $status): bool
    {
        return ($user_id === $task_creator_id) && ($status === Task::STATUS_IN_PROGRESS);
    }
}
//
