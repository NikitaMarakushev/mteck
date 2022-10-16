<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Controller\ProductCategory;

use App\Core\Application\Query\QueryBusInterface;
use App\Product\Application\Command\Product\GetProductByCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListCategoryProductAction extends AbstractController
{
    #[Route('/product-category/{id}', name: 'list_category_product', methods: ['GET'])]
    public function __invoke(
        Request $request,
        int $id,
        QueryBusInterface $queryBus,
    ): Response
    {
        $query = new GetProductByCategory($id);
        $productDTOs = $queryBus->execute($query);

        return $this->render('product/list_product.html.twig', [
            'products' => $productDTOs,
        ]);
    }
}