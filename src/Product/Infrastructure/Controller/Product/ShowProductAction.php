<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Controller\Product;

use App\Core\Application\Query\QueryBusInterface;
use App\Product\Application\Command\Product\GetProductQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowProductAction extends AbstractController
{
    #[Route('/product/{id}', name: 'show_product', methods: ['GET'])]
    public function index(int $id, QueryBusInterface $queryBus): Response
    {
        $query = new GetProductQuery($id);
        $productDTO = $queryBus->execute($query);

        return $this->render('product/show_product.html.twig', [
            'product' => $productDTO,
        ]);
    }
}
