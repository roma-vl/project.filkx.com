<?php

declare(strict_types=1);

namespace App\Controller;

use App\Infrastructure\Inertia\InertiaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, InertiaService $inertia): Response
    {
        return $inertia->render($request, 'Home', [
            'message' => 'Inertia без Laravel!',
        ]);
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(Request $request, InertiaService $inertia): Response
    {
        return $inertia->render($request, 'Dashboard');
    }
}
