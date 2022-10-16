<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Controller;

use App\Core\Application\Query\QueryBusInterface;
use App\Product\Application\Command\ProductCategory\GetAllProductCategoriesQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/', name: 'home', methods: ['GET'])]
class HomeAction extends AbstractController
{
    public function __invoke(
        Request $request,
        QueryBusInterface $queryBus,
    ): Response
    {
        $query = new GetAllProductCategoriesQuery();
        $categoriesDTOs = $queryBus->execute($query);

        return $this->render('home.html.twig', [
            'categories' => $categoriesDTOs,
        ]);
    }
}