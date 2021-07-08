<?php

use TaskForce\Models\Actions\action_cancel;
use TaskForce\Models\Actions\action_done;
use TaskForce\Models\Actions\action_failed;
use TaskForce\Models\Actions\action_start;

require_once "../vendor/autoload.php";
$task = new TaskForce\Models\Task("status", 0, 0);

function assert_handler($file, $line, $code)
{
	print_r("False assert
File: $file
Line: $line
Code: $code
");
}

assert_options(ASSERT_CALLBACK, 'assert_handler');
assert($task->getAllowedActionsForStatus($task::STATUS_NEW)[0]->get_inner_name() == "action_start");
assert($task->getAllowedActionsForStatus($task::STATUS_NEW)[1]->get_inner_name() == "action_cancel");
assert($task->getAllowedActionsForStatus($task::STATUS_IN_PROGRESS)[0]->get_inner_name() == "action_done");
assert($task->getAllowedActionsForStatus($task::STATUS_IN_PROGRESS)[1]->get_inner_name() == "action_failed");

assert($task->getAllowedActionsForStatus($task::STATUS_NEW)[0]->id_checker(1, 1, 2, "status_new") == true);
assert($task->getAllowedActionsForStatus($task::STATUS_NEW)[1]->id_checker(1, 1, 2, "status_in_progress") == false);
assert($task->getAllowedActionsForStatus($task::STATUS_IN_PROGRESS)[0]->id_checker(1, 2, 1, "status_in_progress") == true);
assert($task->getAllowedActionsForStatus($task::STATUS_IN_PROGRESS)[1]->id_checker(1, 2, 1, "status_new") == false);

print_r("All working fine");
