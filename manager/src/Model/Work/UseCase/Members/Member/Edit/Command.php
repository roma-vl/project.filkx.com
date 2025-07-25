<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Members\Member\Edit;

use App\Model\Work\Entity\Members\Member\Member;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    #[Assert\NotBlank]
    public string $id;

    #[Assert\NotBlank]
    public string $firstName;

    #[Assert\NotBlank]
    public string $lastName;

    #[Assert\Email]
    public string $email;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromMember(Member $member): self
    {
        $command = new self($member->getId()->getValue());
        $command->firstName = $member->getName()->getFirst();
        $command->lastName = $member->getName()->getLast();
        $command->email = $member->getEmail()->getValue();

        return $command;
    }
}
