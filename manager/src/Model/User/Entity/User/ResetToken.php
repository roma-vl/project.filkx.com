<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
class ResetToken
{
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $token = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $expires = null;

    public function __construct(string $token, \DateTimeImmutable $expires)
    {
        Assert::notEmpty($token);

        $this->token = $token;
        $this->expires = $expires;
    }

    public function isExpiredTo(\DateTimeImmutable $date): bool
    {
        return $this->expires !== null && $this->expires <= $date;
    }

    public function getToken(): string
    {
        return $this->token ?? '';
    }

    /**
     * @internal for postLoad callback
     */
    public function isEmpty(): bool
    {
        return empty($this->token);
    }
}
