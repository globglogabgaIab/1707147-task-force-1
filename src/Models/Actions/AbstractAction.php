<?php
namespace TaskForce\Models\Actions;

abstract class AbstractAction
{
    protected string $name;
    protected string $innerName;

    public function getName(): string
    {
        return $this->name;
    }

    public function getInnerName(): string
    {
        return $this->innerName;
    }

    abstract function checkAllowByUserIds(int $user_id, int $executor_id, int $task_creator_id, string $status);
}

