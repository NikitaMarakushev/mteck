<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Route('/', name: 'home', methods: ['GET'])]
class HomeAction extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        return $this->render('home.html.twig');
    }
}