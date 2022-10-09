<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Controller\Product;

use App\Core\Application\Command\CommandBusInterface;
use App\Core\Infrastructure\Tools\BootstrapType;
use App\Product\Application\Command\Product\EditProductCommand;
use App\Product\Application\DTO\ProductFormDTO;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Product\Infrastructure\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product/{id}/edit', name: 'product_card', methods: ['GET', 'POST'])]
class EditProductAction extends AbstractController
{
    public function __invoke(
        Request $request, int $id, CommandBusInterface $commandBus, ProductRepositoryInterface $productRepository
    ): Response {
        $product = $productRepository->find($id);
        $productFormDTO = ProductFormDTO::fromEntity($product);

        $form = $this->createForm(ProductType::class, $productFormDTO, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new EditProductCommand(
                $productFormDTO->getId(),
                $productFormDTO->getName(),
                $productFormDTO->getDescription(),
                $productFormDTO->getPrice(),
                $productFormDTO->getImage()
            );
        }
        $productId = $commandBus->execute($command);

        $this->addFlash(
            BootstrapType::BOOTSTRAP_TYPE_SUCCESS,
            "Продукт {$productFormDTO->getName()} обновлён"
        );

        return $this->renderForm('product/edit_product.html.twig', [
            'product' => $productFormDTO,
            'form' => $form,
        ]);
    }
}