<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Move;

use App\Model\Work\Entity\Projects\Task\Task;
use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    #[Assert\NotBlank]
    public string $actor;

    #[Assert\NotBlank]
    public int $id;

    #[Assert\NotBlank]
    public string $project;

    #[Assert\Type('bool')]
    public bool $withChildren = false;

    public function __construct(string $actor, int $id)
    {
        $this->actor = $actor;
        $this->id = $id;
    }

    public static function fromTask(string $actor, Task $task): self
    {
        $command = new self($actor, $task->getId()->getValue());
        $command->project = $task->getProject()->getId()->getValue();

        return $command;
    }
}
