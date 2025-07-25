<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Executor\Revoke;

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
        $actor = $this->members->get(new MemberId($command->actor));
        $task = $this->tasks->get(new Id($command->id));
        $member = $this->members->get(new MemberId($command->member));

        $task->revokeExecutor($actor, new \DateTimeImmutable(), $member->getId());

        $this->flusher->flush($task);
    }
}
