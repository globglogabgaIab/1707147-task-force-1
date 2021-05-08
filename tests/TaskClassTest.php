<?php
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
assert($task->getAllowActionsForStatus($task::STATUS_NEW) == [$task::ACTION_START, $task::ACTION_CANCEL]);
assert($task->getAllowActionsForStatus($task::STATUS_CANCELLED) == [$task::ACTION_CANCEL]);
assert($task->getAllowActionsForStatus($task::STATUS_IN_PROGRESS) == [$task::ACTION_START, $task::ACTION_FAILED]);
assert($task->getAllowActionsForStatus($task::STATUS_DONE) == [$task::ACTION_DONE]);
assert($task->getAllowActionsForStatus($task::STATUS_NEW) == [$task::ACTION_START, $task::ACTION_CANCEL]);

assert($task->getStatusForAction($task::ACTION_START) == [$task::STATUS_IN_PROGRESS]);
assert($task->getStatusForAction($task::ACTION_DONE) == [$task::STATUS_DONE]);
assert($task->getStatusForAction($task::ACTION_CANCEL) == [$task::STATUS_CANCELLED]);
assert($task->getStatusForAction($task::ACTION_FAILED) == [$task::STATUS_FAILED]);

print_r("All working fine")
?>