<?php

declare(strict_types=1);

namespace App\Security\Voter\Work\Projects;

use App\Model\Work\Entity\Members\Member\Id;
use App\Model\Work\Entity\Projects\Project\Project;
use App\Model\Work\Entity\Projects\Role\Permission;
use App\Security\UserIdentity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectAccess extends Voter
{
    public const VIEW = 'view';
    public const MANAGE_MEMBERS = 'manage_members';
    public const EDIT = 'edit';

    private AuthorizationCheckerInterface $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        return \in_array($attribute, [self::VIEW, self::MANAGE_MEMBERS, self::EDIT], true) && $subject instanceof Project;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserIdentity) {
            return false;
        }

        if (!$subject instanceof Project) {
            return false;
        }

        return match ($attribute) {
            self::VIEW => $this->security->isGranted('ROLE_WORK_MANAGE_PROJECTS')
                || $subject->hasMember(new Id($user->getId())),
            self::EDIT => $this->security->isGranted('ROLE_WORK_MANAGE_PROJECTS'),
            self::MANAGE_MEMBERS => $this->security->isGranted('ROLE_WORK_MANAGE_PROJECTS')
                || $subject->isMemberGranted(new Id($user->getId()), Permission::MANAGE_PROJECT_MEMBERS),
            default => false,
        };
    }
}
