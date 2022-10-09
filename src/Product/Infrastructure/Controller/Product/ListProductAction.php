<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Controller\Product;

use App\Core\Application\Query\QueryBusInterface;
use App\Product\Application\Command\Product\GetAllProductsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListProductAction extends AbstractController
{
    #[Route('/product', name: 'list_product', methods: ['GET'])]
    public function index(QueryBusInterface $queryBus): Response
    {
        $query = new GetAllProductsQuery();
        $productDTOs = $queryBus->execute($query);

        return $this->render('card/list_product.html.twig', [
            'products' => $productDTOs,
        ]);
    }
}