<?php

use TaskForce\Models\Actions\ActionCancel;
use TaskForce\Models\Actions\ActionDone;
use TaskForce\Models\Actions\ActionFailed;
use TaskForce\Models\Actions\ActionStart;

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
assert($task->getAllowedActions($task::STATUS_NEW)[0]->getInnerName() == "action_start");
assert($task->getAllowedActions($task::STATUS_NEW)[1]->getInnerName() == "action_cancel");
assert($task->getAllowedActions($task::STATUS_IN_PROGRESS)[0]->getInnerName() == "action_done");
assert($task->getAllowedActions($task::STATUS_IN_PROGRESS)[1]->getInnerName() == "action_failed");

assert($task->getAllowedActions($task::STATUS_NEW)[0]->checkAllowByUserIds(1, 1, 2, "status_new") == true);
assert($task->getAllowedActions($task::STATUS_NEW)[1]->checkAllowByUserIds(1, 1, 2, "status_in_progress") == false);
assert($task->getAllowedActions($task::STATUS_IN_PROGRESS)[0]->checkAllowByUserIds(1, 2, 1, "status_in_progress") == true);
assert($task->getAllowedActions($task::STATUS_IN_PROGRESS)[1]->checkAllowByUserIds(1, 2, 1, "status_new") == false);

print_r("All working fine");

