<?php

declare(strict_types=1);

namespace App\ReadModel\Work\Members;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

readonly class GroupFetcher
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    /**
     * @throws Exception
     */
    public function assoc(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select('id', 'name')
            ->from('work_members_groups')
            ->orderBy('name')
            ->executeQuery();

        return $stmt->fetchAllKeyValue();
    }

    /**
     * @throws Exception
     */
    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'g.id',
                'g.name',
                '(SELECT COUNT(*) FROM work_members_members m WHERE m.group_id = g.id) AS members'
            )
            ->from('work_members_groups', 'g')
            ->orderBy('g.name')
            ->executeQuery();

        return $stmt->fetchAllAssociative();
    }
}
