<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\ReadModel\User\UserFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowController extends AbstractController
{
    private $users;

    public function __construct(UserFetcher $users)
    {
        $this->users = $users;
    }
    #[Route('/profile', name: 'profile')]
    public function show(): Response
    {
        $user = $this->users->get($this->getUser()->getId());

        return $this->render('app/profile/show.html.twig', compact('user'));
    }
}
