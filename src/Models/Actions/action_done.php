<?php
namespace TaskForce\Models\Actions;

use TaskForce\Models\Task;


class action_done extends abstract_action {
    public function get_name(): string
    {
        return "Выполнено";
    }

    public function get_inner_name(): string
    {
        return "action_done";
    }

    public function id_checker(int $user_id, int $executor_id, int $task_creator_id, string $status): bool
    {
        $task = new Task("status", 0, 0);
        return ($user_id == $task_creator_id) && ($status == $task::STATUS_IN_PROGRESS);
    }
}
