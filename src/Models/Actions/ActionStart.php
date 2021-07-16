<?php
namespace TaskForce\Models\Actions;

use TaskForce\Models\Task;

class ActionStart extends AbstractAction
{
    protected string $name = "Начать";
    protected string $innerName = "action_start";

    public function checkAllowByUserIds(int $user_id, int $executor_id, int $task_creator_id, string $status): bool
    {
        return ($user_id === $executor_id) && ($status === Task::STATUS_NEW);
    }
}
//
