<?php
namespace TaskForce\Models\Actions;

use TaskForce\Models\Task;

class ActionFailed extends AbstractAction
{
    protected string $name = "Не выполнено";
    protected string $innerName = "action_failed";

    public function checkAllowByUserIds(int $user_id, int $executor_id, int $task_creator_id, string $status): bool
    {
        return ($user_id === $executor_id) && ($status === Task::STATUS_IN_PROGRESS);
    }
}

