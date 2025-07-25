<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Start;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    #[Assert\NotBlank]
    public string $actor;
    #[Assert\NotBlank]
    public int $id;

    public function __construct(string $actor, int $id)
    {
        $this->actor = $actor;
        $this->id = $id;
    }
}
