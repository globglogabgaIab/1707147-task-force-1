<?php
namespace TaskForce\Models\Actions;

abstract class abstract_action {
    abstract function get_name();
    abstract function get_inner_name();
    abstract function id_checker(int $user_id, int $executor_id, int $task_creator_id, string $status);
}