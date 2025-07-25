<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Take;

use App\Model\Flusher;
use App\Model\Work\Entity\Members\Member\Id as MemberId;
use App\Model\Work\Entity\Members\Member\MemberRepository;
use App\Model\Work\Entity\Projects\Task\Id;
use App\Model\Work\Entity\Projects\Task\TaskRepository;

class Handler
{
    private TaskRepository $tasks;
    private Flusher $flusher;
    private MemberRepository $members;

    public function __construct(
        TaskRepository $tasks,
        MemberRepository $members,
        Flusher $flusher,
    ) {
        $this->tasks = $tasks;
        $this->flusher = $flusher;
        $this->members = $members;
    }

    public function handle(Command $command): void
    {
        $task = $this->tasks->get(new Id($command->id));
        $actor = $this->members->get(new MemberId($command->actor));

        if (!$task->hasExecutor($actor->getId())) {
            $task->assignExecutor($actor, new \DateTimeImmutable(), $actor);
        }

        $this->flusher->flush($task);
    }
}
