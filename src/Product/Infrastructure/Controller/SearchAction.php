<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Controller;

use App\Product\Application\DTO\ProductDTO;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/search', name: 'search', methods: ['GET'])]
class SearchAction extends AbstractController
{
    public function __invoke(Request $request, ProductRepositoryInterface $productRepository): Response
    {
        $data = $request->get('qs');

        if (!isset($data)) {
            throw new InvalidArgumentException('Пустой запрос');
        }

        $products = $productRepository->createQueryBuilder('c')
            ->where('LOWER(c.name) LIKE :data')
            ->setParameter('data', '%' . mb_strtolower($data) . '%')
            ->orderBy('c.name', 'ASC')
            ->getQuery()->getResult();

        if (1 === \count($products)) {
            return $this->redirectToRoute('show_product', ['id' => $products[0]->getId()], Response::HTTP_SEE_OTHER);
        }

        $productDTOs = [];
        foreach ($products as $product) {
            $productDTOs[] = (new ProductDTO())::fromEntity($product);
        }

        return $this->renderForm('product/search_product.html.twig', [
            'products' => $productDTOs,
        ]);
    }
}