<?php
namespace TaskForce\Models\Actions;

use TaskForce\Models\Task;

class action_failed extends abstract_action {
    public function get_name(): string
    {
        return "Не выполнено";
    }

    public function get_inner_name(): string
    {
    	return "action_failed";
    }

    public function id_checker(int $user_id, int $executor_id, int $task_creator_id, string $status): bool
    {
        $task = new Task("status", 0, 0);
        return ($user_id == $executor_id) && ($status == $task::STATUS_IN_PROGRESS);
    }
}
