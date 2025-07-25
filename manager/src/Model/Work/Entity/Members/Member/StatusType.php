<?php

declare(strict_types=1);

namespace App\Model\Work\Entity\Members\Member;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class StatusType extends StringType
{
    public const NAME = 'work_members_member_status';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Status ? $value->getName() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new Status($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
